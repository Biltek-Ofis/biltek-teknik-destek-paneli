import 'package:biltekteknikservis/utils/alerts.dart';
import 'package:biltekteknikservis/utils/buttons.dart';
import 'package:biltekteknikservis/utils/islemler.dart';
import 'package:biltekteknikservis/widgets/input.dart';
import 'package:biltekteknikservis/widgets/kis_modu.dart';
import 'package:biltekteknikservis/widgets/takvim/dialog.dart';
import 'package:flutter/material.dart';
import 'package:flutter_multi_formatter/flutter_multi_formatter.dart';
import 'package:intl/intl.dart';

class YeniCihazSayfasi extends StatefulWidget {
  const YeniCihazSayfasi({
    super.key,
    required this.cihazlariYenile,
  });

  final VoidCallback cihazlariYenile;

  @override
  State<YeniCihazSayfasi> createState() => _YeniCihazSayfasiState();
}

String tarihFormat = "dd.MM.yyyy HH:mm";

class _YeniCihazSayfasiState extends State<YeniCihazSayfasi> {
  bool girildi = false;

  String tarihGirisi = "oto";

  TextEditingController tarihController = TextEditingController();

  TextEditingController musteriAdiController = TextEditingController();
  FocusNode musteriAdiFocus = FocusNode();
  String? musteriAdiHata;

  TextEditingController teslimEdenController = TextEditingController();
  FocusNode teslimEdenFocus = FocusNode();

  TextEditingController adresController = TextEditingController();
  FocusNode adresFocus = FocusNode();

  TextEditingController gsmController = TextEditingController();
  FocusNode gsmFocus = FocusNode();

  String? cihazTuru;
  String? cihazTuruHata;

  bool musteriyiKaydet = true;

  @override
  void initState() {
    super.initState();
    tarihGuncelle(DateTime.now().toLocal());
    gsmController.text = "+90";
    Future.delayed(Duration.zero, () {
      if (mounted) {
        FocusScope.of(context).requestFocus(musteriAdiFocus);
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    return PopScope(
      canPop: false,
      onPopInvokedWithResult: (didPop, result) async {
        if (didPop) {
          return;
        }
        if (girildi) {
          NavigatorState navigatorState = Navigator.of(context);
          bool? result = await showDialog<bool>(
            context: context,
            builder: (context) {
              return AlertDialog(
                title: Text("Değişiklikler Kaydedilmedi"),
                content: Text(
                    "Kaydedilmeyen değişiklikleriniz var. Çıkmak istediğinize emin misiniz?"),
                actions: [
                  TextButton(
                    onPressed: () {
                      navigatorState.pop(true);
                    },
                    child: Text(
                      "Sil ve Çık",
                      style: TextStyle(
                        color: Colors.red,
                      ),
                    ),
                  ),
                  TextButton(
                    onPressed: () {
                      navigatorState.pop(false);
                    },
                    child: Text("Kal"),
                  ),
                ],
              );
            },
          );
          if (result == true) {
            cik();
            navigatorState.pop<bool>(result);
          }
        } else {
          cik();
          Navigator.pop(context);
        }
      },
      child: Scaffold(
        appBar: AppBar(
          title: Text("Yeni Cihaz Girişi"),
        ),
        body: SizedBox(
          width: MediaQuery.of(context).size.width,
          height: MediaQuery.of(context).size.height,
          child: KisModu(
            child: SingleChildScrollView(
              child: Column(
                children: [
                  Text("Gerekli alanlar * ile belirtilmiştir."),
                  BiltekSelect(
                    value: tarihGirisi,
                    items: [
                      DropdownMenuItem(
                        value: "oto",
                        child: Text("Otomatik (Güncel Tarih)"),
                      ),
                      DropdownMenuItem(
                        value: "el",
                        child: Text("El ile Giriş"),
                      ),
                    ],
                    onChanged: (value) {
                      setState(() {
                        tarihGirisi = value!;
                        girildi = true;
                      });
                    },
                  ),
                  if (tarihGirisi == "el")
                    TextField(
                      controller: tarihController,
                      decoration: InputDecoration(
                        labelText: "Tarih",
                      ),
                      readOnly: true,
                      onTap: () {
                        showTakvim(
                          context,
                          initialDate: DateFormat(tarihFormat)
                              .parse(tarihController.text),
                          onConfirm: (date) {
                            tarihGuncelle(date!);
                          },
                        );
                      },
                      onChanged: (value) {
                        setState(() {
                          girildi = true;
                        });
                      },
                    ),
                  BiltekTextField(
                    controller: musteriAdiController,
                    currentFocus: musteriAdiFocus,
                    nextFocus: teslimEdenFocus,
                    label: "Müşteri Adı *",
                    errorText: musteriAdiHata,
                    onChanged: (value) {
                      setState(() {
                        girildi = true;
                        musteriAdiHata = null;
                      });
                    },
                  ),
                  BiltekTextField(
                    controller: teslimEdenController,
                    currentFocus: teslimEdenFocus,
                    nextFocus: adresFocus,
                    label: "Teslim Eden Kişi",
                    onChanged: (value) {
                      setState(() {
                        girildi = true;
                      });
                    },
                  ),
                  BiltekTextField(
                    controller: adresController,
                    currentFocus: adresFocus,
                    nextFocus: gsmFocus,
                    label: "Adresi",
                    onChanged: (value) {
                      setState(() {
                        girildi = true;
                      });
                    },
                  ),
                  BiltekCheckbox(
                    label: "Müşteri bilgilerini kaydet",
                    value: musteriyiKaydet,
                    onChanged: (value) {
                      setState(() {
                        musteriyiKaydet = value ?? true;
                      });
                    },
                  ),
                  BiltekTextField(
                    controller: gsmController,
                    currentFocus: gsmFocus,
                    label: "GSM",
                    onChanged: (value) {
                      setState(() {
                        girildi = true;
                      });
                    },
                    inputFormatters: [
                      MaskedInputFormatter("+90 (###) ###-####"),
                    ],
                  ),
                  BiltekSelect(
                    value: cihazTuru,
                    items: [
                      DropdownMenuItem(
                        value: null,
                        child: Text("Cihaz Türü Seçin *"),
                      ),
                    ],
                    onChanged: (value) {
                      setState(() {
                        cihazTuru = value;
                        cihazTuruHata = null;
                        girildi = true;
                      });
                    },
                    errorText: cihazTuruHata,
                  ),
                  SizedBox(
                    width: MediaQuery.of(context).size.width,
                    child: Row(
                      mainAxisSize: MainAxisSize.max,
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        SizedBox(),
                        DefaultButton(
                          width: MediaQuery.of(context).size.width / 2,
                          background: Islemler.arkaRenk("bg-primary"),
                          onPressed: () async {
                            await _cihazEkle();
                          },
                          text: "Ekle",
                        ),
                      ],
                    ),
                  )
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }

  void cik() {
    widget.cihazlariYenile.call();
  }

  void tarihGuncelle(DateTime tarih) {
    tarihController.text = DateFormat(tarihFormat).format(tarih);
  }

  Future<void> _cihazEkle() async {
    yukleniyor(context);
    NavigatorState navigatorState = Navigator.of(context);
    String musteriAdi = musteriAdiController.text;
    String gsm = gsmController.text;
    bool hataVar = false;
    if (musteriAdi.isEmpty) {
      setState(() {
        musteriAdiHata = "Müşteri Adı boş olamaz";
      });
      hataVar = true;
    }
    if (cihazTuru == null) {
      setState(() {
        cihazTuruHata = "Lütfen bir cihaz türü seçin";
      });
      hataVar = true;
    }
    if (!hataVar) {
      Map<String, String> postData = {
        "musteri_kod": "",
        "musteri_adi": musteriAdi,
        "teslim_eden": teslimEdenController.text,
        "adres": adresController.text,
        "cihaz_turu": "",
        "cihaz": "",
        "cihaz_modeli": "",
        "seri_no": "",
        "cihaz_sifresi": "",
        "cihaz_deseni": "",
        "hasar_tespiti": "",
        "cihazdaki_hasar": "",
        "ariza_aciklamasi": "",
        "teslim_alinanlar": "",
        "servis_turu": "",
        "yedek_durumu": "",
        "tarih_girisi": tarihGirisi,
      };
      if (tarihGirisi == "el") {
        postData.addAll({
          "tarih": tarihController.text,
        });
      }
      if (gsm.isNotEmpty && gsm != "+90") {
        postData.addAll({
          "telefon_numarasi": gsm,
        });
      }
      navigatorState.pop();
    } else {
      navigatorState.pop();
    }
  }
}
