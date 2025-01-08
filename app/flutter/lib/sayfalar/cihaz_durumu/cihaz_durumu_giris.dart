import 'package:biltekteknikservis/sayfalar/cihaz_durumu/cihaz_durumu.dart';
import 'package:biltekteknikservis/utils/alerts.dart';
import 'package:biltekteknikservis/widgets/kis_modu.dart';
import 'package:flutter/material.dart';

import '../../models/cihaz.dart';
import '../../utils/assets.dart';
import '../../utils/buttons.dart';
import '../../utils/post.dart';

class CihazDurumuGiris extends StatefulWidget {
  const CihazDurumuGiris({super.key});

  @override
  State<CihazDurumuGiris> createState() => _CihazDurumuGirisState();
}

class _CihazDurumuGirisState extends State<CihazDurumuGiris> {
  TextEditingController takipNoController = TextEditingController();
  FocusNode takipNoFocus = FocusNode();

  String? cihazDurumuError;

  @override
  void initState() {
    super.initState();
    Future.delayed(Duration.zero, () async {
      if (mounted) {
        FocusScope.of(context).requestFocus(takipNoFocus);
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Cihaz Durumu Görüntüle"),
      ),
      body: Container(
        alignment: Alignment.center,
        padding: EdgeInsets.all(10),
        child: KisModu(
          child: SizedBox(
            width: MediaQuery.of(context).size.width > 400
                ? 400
                : MediaQuery.of(context).size.width,
            child: SingleChildScrollView(
              child: Column(
                mainAxisAlignment: MainAxisAlignment.end,
                children: [
                  Image.asset(BiltekAssets.logo),
                  TextField(
                    controller: takipNoController,
                    focusNode: takipNoFocus,
                    keyboardType: TextInputType.number,
                    textInputAction: TextInputAction.done,
                    onSubmitted: (val) async {
                      await _ara();
                    },
                    onChanged: (value) {
                      setState(() {
                        cihazDurumuError = null;
                      });
                    },
                    decoration: InputDecoration(
                      label: Text("Takip Numarası"),
                      errorText: cihazDurumuError,
                    ),
                  ),
                  SizedBox(
                    height: 10,
                  ),
                  SizedBox(
                    width: MediaQuery.of(context).size.width,
                    height: 50,
                    child: DefaultButton(
                      onPressed: () async {
                        await _ara();
                      },
                      text: "Ara",
                    ),
                  ),
                  SizedBox(
                    height: 10,
                  ),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }

  Future<void> _ara() async {
    setState(() {
      cihazDurumuError = null;
    });
    NavigatorState navigatorState = Navigator.of(context);
    yukleniyor(context);
    Cihaz? cihazTemp = await BiltekPost.cihazGetir(
      takipNo: int.tryParse(takipNoController.text),
    );
    navigatorState.pop();
    if (cihazTemp != null) {
      navigatorState.push(
        MaterialPageRoute(
          builder: (context) => CihazDurumu(cihaz: cihazTemp),
        ),
      );
    } else {
      setState(() {
        cihazDurumuError = "Cihaz bulunamadı.";
      });
    }
  }
}
