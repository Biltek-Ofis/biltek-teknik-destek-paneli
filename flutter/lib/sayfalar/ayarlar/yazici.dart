import 'dart:math';

import 'package:biltekteknikservis/widgets/input.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_net_printer/flutter_net_printer.dart';
import 'package:flutter_net_printer/model/network_device.dart';

import '../../models/yazici.dart';
import '../../widgets/ip_formatter.dart';
import '../../widgets/list.dart';

class YaziciAyarlari extends StatefulWidget {
  const YaziciAyarlari({super.key});

  @override
  State<YaziciAyarlari> createState() => _YaziciAyarlariState();
}

class _YaziciAyarlariState extends State<YaziciAyarlari> {
  List<YaziciModel> yazicilar = [];

  @override
  void initState() {
    super.initState();
    Future.delayed(Duration.zero, () async {
      await _yazicilariYukle();
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("Yazıcı Ayarları")),
      resizeToAvoidBottomInset: false,
      floatingActionButton: FloatingActionButton(
        heroTag: "YaziciEkleDuzenle${Random().nextInt(1000)}",
        onPressed: () {
          showDialog(
            context: context,
            builder:
                (context) => YaziciEkleDuzenle(
                  yazicilar: yazicilar,
                  onComplete: (yazici) async {
                    yazicilar.add(yazici);
                    setState(() {});
                    await _yazicilariKaydet();
                    await yazici.registerPrinter();
                  },
                ),
          );
        },
        shape: const CircleBorder(),
        child: Icon(CupertinoIcons.add),
      ),
      body: SafeArea(
        child: SizedBox(
          width: MediaQuery.of(context).size.width,
          child:
              yazicilar.isEmpty
                  ? Center(
                    child: Padding(
                      padding: EdgeInsets.symmetric(horizontal: 10),
                      child: Text(
                        "Henüz bir yazıcı eklenmemiş! + butonuna tıklayarak yazıcı ekleyebilirsiniz.",
                      ),
                    ),
                  )
                  : ListView.builder(
                    itemCount: yazicilar.length,
                    itemBuilder: (context, index) {
                      YaziciModel yazici = yazicilar[index];
                      return BiltekListTile(
                        onTapDown: _getTapPosition,
                        onLongPress: () async {
                          await _showContextMenu(context, index);
                        },
                        onTap: () async {
                          await _showContextMenu(context, index);
                        },
                        title: yazici.isim,
                        subtitle:
                            "${yazici.ip}${yazici.portIsDefault ? "" : ":${yazici.port}"}",
                      );
                    },
                  ),
        ),
      ),
    );
  }

  Offset _tapPosition = Offset.zero;

  void _getTapPosition(TapDownDetails details) {
    setState(() {
      _tapPosition = details.globalPosition;
    });
  }

  Future<void> _showContextMenu(BuildContext context, int index) async {
    final RenderBox overlay =
        Overlay.of(context).context.findRenderObject() as RenderBox;

    final String? selectedAction = await showMenu<String>(
      context: context,
      position: RelativeRect.fromRect(
        Rect.fromLTWH(_tapPosition.dx, _tapPosition.dy, 30, 30),
        Offset.zero & overlay.size,
      ),
      items: [
        PopupMenuItem<String>(
          value: "duzenle",
          child: ListTile(
            leading: Icon(CupertinoIcons.pen),
            title: Text("Düzenle"),
          ),
        ),
        PopupMenuItem<String>(
          value: "sil",
          child: ListTile(
            leading: Icon(CupertinoIcons.delete, color: Colors.red),
            title: Text("Sil", style: TextStyle(color: Colors.red)),
          ),
        ),
      ],
    );

    if (selectedAction != null) {
      await _handleMenuSelection(selectedAction, index);
    }
  }

  Future<void> _handleMenuSelection(String action, int index) async {
    switch (action) {
      case "duzenle":
        showDialog(
          context: context,
          builder:
              (context) => YaziciEkleDuzenle(
                yazicilar: yazicilar,
                index: index,
                onComplete: (yazici) async {
                  YaziciModel yaziciModel = yazicilar[index];
                  yazicilar[index] = yazici;
                  await yaziciModel.removePrinter();
                  await yazici.registerPrinter();
                  setState(() {});
                  await _yazicilariKaydet();
                },
              ),
        );
        break;
      case "sil":
        await yazicilar[index].removePrinter();
        yazicilar.removeAt(index);
        setState(() {});
        await _yazicilariKaydet();
        break;
    }
  }

  Future<void> _yazicilariKaydet() async {
    await YaziciModel.clearPrinters();
    await YaziciModel.registerAllPrinters(yazicilar);
  }

  Future<void> _yazicilariYukle() async {
    List<YaziciModel> androidYazicilar = await YaziciModel.getAndroidPrinters();
    if (androidYazicilar.isNotEmpty) {
      setState(() {
        yazicilar = androidYazicilar;
      });
      await _yazicilariKaydet();
      return;
    }
  }
}

class YaziciEkleDuzenle extends StatefulWidget {
  const YaziciEkleDuzenle({
    super.key,
    required this.yazicilar,
    required this.onComplete,
    this.index,
  });

  final List<YaziciModel> yazicilar;
  final void Function(YaziciModel) onComplete;
  final int? index;

  @override
  State<YaziciEkleDuzenle> createState() => _YaziciEkleDuzenleState();
}

class _YaziciEkleDuzenleState extends State<YaziciEkleDuzenle> {
  final printer = FlutterNetPrinter();
  bool controlEdiliyor = false;
  String hata = "";
  TextEditingController isimController = TextEditingController();
  FocusNode isimFocusNode = FocusNode();
  TextEditingController ipController = TextEditingController();
  FocusNode ipFocusNode = FocusNode();
  TextEditingController portController = TextEditingController(
    text: YaziciModel.defaultPort.toString(),
  );
  FocusNode portFocusNode = FocusNode();

  @override
  void initState() {
    super.initState();
    if (widget.index != null) {
      ipController.text = widget.yazicilar[widget.index!].ip;
      portController.text = widget.yazicilar[widget.index!].port.toString();
      isimController.text = widget.yazicilar[widget.index!].isim;
    }
  }

  @override
  Widget build(BuildContext context) {
    return AlertDialog(
      title: Text("Yazıcı Ekle"),
      content: Flexible(
        child: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            if (hata.isNotEmpty)
              Center(child: Text(hata, style: TextStyle(color: Colors.red))),
            if (controlEdiliyor) Center(child: CircularProgressIndicator()),
            if (controlEdiliyor || hata.isNotEmpty) SizedBox(height: 10),
            BiltekTextField(
              controller: ipController,
              currentFocus: ipFocusNode,
              nextFocus: portFocusNode,
              textInputAction: TextInputAction.next,
              readOnly: controlEdiliyor,
              inputFormatters: [IpAddressInputFormatter()],
              onChanged: (p0) {
                setState(() {
                  hata = "";
                });
              },
            ),
            SizedBox(height: 10),
            BiltekTextField(
              controller: portController,
              currentFocus: portFocusNode,
              nextFocus: isimFocusNode,
              textInputAction: TextInputAction.next,
              keyboardType: TextInputType.number,
              readOnly: controlEdiliyor,
              onChanged: (p0) {
                setState(() {
                  hata = "";
                });
              },
            ),
            SizedBox(height: 10),
            BiltekTextField(
              controller: isimController,
              currentFocus: isimFocusNode,
              textInputAction: TextInputAction.done,
              readOnly: controlEdiliyor,
              onChanged: (p0) {
                setState(() {
                  hata = "";
                });
              },
              onSubmitted: (v) async {
                await _gonder();
              },
            ),
          ],
        ),
      ),
      actions: [
        TextButton(
          onPressed:
              controlEdiliyor
                  ? null
                  : () async {
                    await _gonder();
                  },
          child: Text("Tamam"),
        ),
        TextButton(
          onPressed:
              controlEdiliyor
                  ? null
                  : () {
                    Navigator.pop(context);
                  },
          child: Text("iptal"),
        ),
      ],
    );
  }

  Future<void> _gonder() async {
    setState(() {
      hata = "";
      controlEdiliyor = true;
    });
    NavigatorState navigatorState = Navigator.of(context);
    int port = int.tryParse(portController.text) ?? YaziciModel.defaultPort;
    String ip = ipController.text.trim();
    String isim = isimController.text.trim();
    int yaziciIndex = widget.yazicilar.indexWhere((y) => y.ip.trim() == ip);
    if ((widget.index != null && widget.index != yaziciIndex) ||
        yaziciIndex < 0) {
      NetworkDevice? connectedDevice = await printer.connectToPrinter(
        ipController.text,
        port,
        timeout: Duration(seconds: 5),
      );
      if (connectedDevice != null) {
        widget.onComplete.call(
          YaziciModel(
            ip: connectedDevice.address,
            port: port,
            isim:
                isim.isNotEmpty
                    ? isim
                    : (connectedDevice.name ??
                        "Yazici ${(widget.yazicilar.length + 1).toString()}"),
          ),
        );
        navigatorState.pop();
      } else {
        setState(() {
          hata =
              "Yazıcı eklenemedi! Lütfen ip adresinizi veya portu kontrol edin.";
        });
      }
    } else {
      setState(() {
        hata = "Yazıcı eklenemedi! Bu ip adresi ile bir yazıcı zaten kayıtlı";
      });
    }
    setState(() {
      controlEdiliyor = false;
    });
  }
}
