import 'package:biltekteknikservis/utils/buttons.dart';
import 'package:biltekteknikservis/utils/shared_preferences.dart';
import 'package:biltekteknikservis/widgets/input.dart';
import 'package:flutter/material.dart';
import 'package:simple_barcode_scanner/simple_barcode_scanner.dart';

import '../../utils/barkod_okuyucu.dart';

typedef OnBOKaydet = Function(bool durum, bool elle);

class BarkodOkuyucuAyarlari extends StatefulWidget {
  const BarkodOkuyucuAyarlari({
    super.key,
    this.onBOKaydet,
  });

  final OnBOKaydet? onBOKaydet;

  @override
  State<BarkodOkuyucuAyarlari> createState() => _BarkodOkuyucuAyarlariState();
}

class _BarkodOkuyucuAyarlariState extends State<BarkodOkuyucuAyarlari> {
  final TextEditingController ipController = TextEditingController();
  final FocusNode ipFocus = FocusNode();
  final TextEditingController portController = TextEditingController();
  FocusNode portFocus = FocusNode();

  BarkodOkuyucu? barkodOkuyucu;

  @override
  void initState() {
    super.initState();
    Future.delayed(Duration.zero, () async {
      if (mounted) {
        FocusScope.of(context).requestFocus(ipFocus);
      }
      BarkodOkuyucu? barkodOkuyucu = await BarkodOkuyucu.getir();
      if (barkodOkuyucu != null) {
        ipController.text = barkodOkuyucu.ip;
        portController.text = barkodOkuyucu.port.toString();
      } else {
        portController.text = BarkodOkuyucu.varsayilanPort.toString();
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Barkod Okuyucu Ayarları"),
        actions: [
          IconButton(
            onPressed: () async {
              NavigatorState navigatorState = Navigator.of(context);
              try {
                String? res = await SimpleBarcodeScanner.scanBarcode(
                  context,
                  barcodeAppBar: const BarcodeAppBar(
                    appBarTitle: 'Barkod Tara',
                    centerTitle: false,
                    enableBackButton: true,
                    backButtonIcon: Icon(Icons.arrow_back_ios),
                  ),
                  cancelButtonText: "İptal",
                  isShowFlashIcon: true,
                  delayMillis: 2000,
                  cameraFace: CameraFace.back,
                );
                if (res != null && res.isNotEmpty && res != "-1") {
                  var spl = res.split(":");
                  if (spl.length == 2) {
                    ipController.text = spl[0];
                    portController.text = spl[1];
                    await kaydet(false);
                  } else {
                    navigatorState.pop();
                    widget.onBOKaydet?.call(false, false);
                  }
                }
              } on Exception catch (e) {
                debugPrint(e.toString());
                navigatorState.pop();
                widget.onBOKaydet?.call(false, false);
              }
            },
            icon: Icon(Icons.qr_code),
          ),
        ],
      ),
      body: SizedBox(
        width: MediaQuery.of(context).size.width,
        height: MediaQuery.of(context).size.height,
        child: SingleChildScrollView(
          child: Column(
            children: [
              BiltekTextField(
                controller: ipController,
                label: "IP",
                currentFocus: ipFocus,
                nextFocus: portFocus,
              ),
              BiltekTextField(
                controller: portController,
                label: "PORT",
                currentFocus: portFocus,
                keyboardType: TextInputType.number,
                onSubmitted: (value) async {
                  await kaydet(true);
                },
              ),
              Row(
                mainAxisSize: MainAxisSize.max,
                mainAxisAlignment: MainAxisAlignment.end,
                children: [
                  DefaultButton(
                    onPressed: () async {
                      await kaydet(true);
                    },
                    text: "Kaydet",
                  ),
                ],
              )
            ],
          ),
        ),
      ),
    );
  }

  Future<void> kaydet(bool elle) async {
    NavigatorState navigatorState = Navigator.of(context);
    try {
      await SharedPreference.setString(
          SharedPreference.barkodIP, ipController.text);
      await SharedPreference.setInt(
          SharedPreference.barkodPort, int.parse(portController.text));

      navigatorState.pop();
      widget.onBOKaydet?.call(true, elle);
      await barkodOkuyucu?.eslestir();
    } on Exception catch (e) {
      debugPrint(e.toString());
      navigatorState.pop();
      widget.onBOKaydet?.call(false, elle);
    }
  }
}
