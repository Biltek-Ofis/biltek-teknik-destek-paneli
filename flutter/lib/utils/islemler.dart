import 'dart:math';

import 'package:android_id/android_id.dart';
import 'package:device_info_plus/device_info_plus.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import 'package:mask_text_input_formatter/mask_text_input_formatter.dart';
import 'package:universal_io/io.dart';

import '../models/cihaz.dart';
import '../widgets/dizayn.dart';

class Islemler {
  static Color? arkaRenk(String renkClass, {double? alpha}) {
    alpha ??= 0.3;
    switch (renkClass) {
      case "bg-white":
        return Colors.white;
      case "bg-dark":
        return Colors.black;
      case "bg-secondary":
        return Color.fromARGB(255, 108, 117, 125).withValues(alpha: alpha);
      case "bg-primary":
        return Color.fromARGB(255, 0, 123, 255).withValues(alpha: alpha);
      case "bg-success":
        return Color.fromARGB(255, 40, 167, 69).withValues(alpha: alpha);
      case "bg-danger":
        return Color.fromARGB(255, 220, 53, 69).withValues(alpha: alpha);
      case "bg-pink":
        return Color.fromARGB(255, 232, 62, 140).withValues(alpha: alpha);
      case "bg-warning":
        return Color.fromARGB(255, 255, 193, 7).withValues(alpha: alpha);
      case "bg-yellow":
        return Color.fromARGB(255, 255, 251, 33).withValues(alpha: alpha);
      case "bg-info":
        return Color.fromARGB(255, 23, 162, 184).withValues(alpha: alpha);

      default:
        return Colors.white;
    }
  }

  static Color? yaziRengi(String renkClass) {
    switch (renkClass) {
      case "bg-dark":
        return Colors.white;
      /*case "bg-white":
        Color.fromARGB(255, 31, 45, 61);
      case "bg-secondary":
        Color.fromARGB(255, 31, 45, 61);
      case "bg-primary":
        Color.fromARGB(255, 31, 45, 61);
      case "bg-success":
        Color.fromARGB(255, 31, 45, 61);
      case "bg-danger":
        Color.fromARGB(255, 31, 45, 61);
      case "bg-pink":
        Color.fromARGB(255, 31, 45, 61);
      case "bg-warning":
        Color.fromARGB(255, 31, 45, 61);*/

      default:
        return Color.fromARGB(255, 31, 45, 61);
    }
  }

  static Future<String?> getId() async {
    if (kIsWeb) {
      final DeviceInfoPlugin deviceInfo = DeviceInfoPlugin();
      WebBrowserInfo webBrowserInfo = await deviceInfo.webBrowserInfo;
      return "dart+${webBrowserInfo.userAgent}";
    }

    ///DeviceInfoPlugin deviceInfo = DeviceInfoPlugin();
    if (Platform.isAndroid) {
      //var androidDeviceInfo = await deviceInfo.androidInfo;
      return AndroidId().getId();
    }
    return null;
  }

  static String _listGetir(List<String> list, int index) {
    if (index < list.length) {
      return list[index];
    } else {
      return list[0];
    }
  }

  static final List<String> cihazdakiHasarlar = [
    "Belirtilmemiş",
    "Çizik",
    "Kırık",
    "Çatlak",
    "Diğer",
  ];
  static String cihazdakiHasar(int index) {
    return _listGetir(cihazdakiHasarlar, index);
  }

  static final List<String> servisTurleri = [
    "Belirtilmemiş",
    "GARANTİ KAPSAMINDA BAKIM/ONARIM",
    "ANLAŞMALI BAKIM/ONARIM",
    "ÜCRETLİ BAKIM/ONARIM",
    "ÜCRETLİ ARIZA TESPİTİ",
  ];
  static String servisTuru(int index) {
    return _listGetir(servisTurleri, index);
  }

  static final List<String> evetHayirlar = ["Belirtilmemiş", "Evet", "Hayır"];
  static String evetHayir(int index) {
    return _listGetir(evetHayirlar, index);
  }

  static final List<String> faturaDurumlari = [
    "Belirtilmedi",
    "Fatura Kesilmedi",
    "Fatura Kesildi",
  ];

  static String faturaDurumu(int index) {
    return _listGetir(faturaDurumlari, index);
  }

  static const String tarihFormat = "dd.MM.yyyy HH:mm";
  static const String tarihSQLFormat = "yyyy-MM-dd HH:mm:ss";
  static MaskTextInputFormatter gsmFormatter = MaskTextInputFormatter(
    mask: "+90 (###) ###-####",
    filter: {"#": RegExp(r'[0-9]')},
  );

  static String telNo(String telefon) {
    return telefon
        .replaceAll("_", "")
        .replaceAll("-", "")
        .replaceAll(" ", "")
        .replaceAll("(", "")
        .replaceAll(")", "");
  }

  static List<int> desenDonusturFlutter(String desen) {
    return desen.characters.map((e) => int.parse(e) - 1).toList();
  }

  static String desenDonusturSQL(List<int> desen) {
    String desenTemp = "";
    for (var desen in desen) {
      desenTemp += (desen + 1).toString();
    }
    return desenTemp;
  }

  static const int maxIslemSayisi = 10;

  static String lisansSQLTarih = "yyyy-MM-dd";
  static String lisansNormalTarih = "dd/MM/yyyy";

  static String tarihGoruntule(
    String date,
    String orjinalFormat,
    String goruntulemeFormati,
  ) {
    DateTime dateTime = DateFormat(orjinalFormat).parse(date).toLocal();

    return DateFormat(goruntulemeFormati).format(dateTime);
  }

  static String rastgeleYazi(int length) {
    const chars =
        'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz1234567890';
    Random rnd = Random();
    return String.fromCharCodes(
      Iterable.generate(
        length,
        (_) => chars.codeUnitAt(rnd.nextInt(chars.length)),
      ),
    );
  }

  static Widget liste(
    List<YapilanIslem> islemler, {
    bool maliyetGosterButon = false,
  }) {
    return _IslemlerListe(
      islemler: islemler,
      maliyetGosterButon: maliyetGosterButon,
    );
  }
}

class _IslemlerListe extends StatefulWidget {
  const _IslemlerListe({
    // ignore: unused_element_parameter
    super.key,
    required this.islemler,
    required this.maliyetGosterButon,
  });

  final List<YapilanIslem> islemler;
  final bool maliyetGosterButon;

  @override
  State<_IslemlerListe> createState() => _IslemlerListeState();
}

class _IslemlerListeState extends State<_IslemlerListe> {
  bool maliyetGoster = false;

  @override
  Widget build(BuildContext context) {
    List<Widget> fiyatlarTemp = [];
    double maliyetToplamTemp = 0;
    double kdvsizToplamTemp = 0;
    double kdvToplamTemp = 0;
    for (int i = 0; i < widget.islemler.length; i++) {
      YapilanIslem islem = widget.islemler[i];
      if (islem.ad.isNotEmpty) {
        double kdvsiz = islem.miktar * islem.birimFiyati;
        double kdv = (kdvsiz / 100) * islem.kdv;
        double kdvli = kdvsiz + kdv;
        maliyetToplamTemp += islem.maliyet;
        kdvsizToplamTemp += kdvsiz;
        kdvToplamTemp += kdv;
        Widget item = Container(
          width: MediaQuery.of(context).size.width,
          alignment: Alignment.topLeft,
          child: Column(
            children: [
              if (fiyatlarTemp.isEmpty)
                SizedBox(
                  width: MediaQuery.of(context).size.width,
                  child: Divider(),
                ),
              Container(
                alignment: Alignment.topLeft,
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.start,
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      "Malzeme/İşçilik: ",
                      style: TextStyle(fontWeight: FontWeight.bold),
                    ),
                    Text(islem.ad),
                  ],
                ),
              ),
              buildRow("Miktar", islem.miktar.toString()),
              if (maliyetGoster && widget.maliyetGosterButon)
                buildRow("Maliyet", "${islem.maliyet} TL"),
              buildRow("Birim Fiyatı", "${islem.birimFiyati} TL"),
              buildRow("KDV", "${islem.kdv} ($kdv TL)"),
              buildRow("Tutar (KDV'siz)", "$kdvsiz TL"),
              buildRow("Toplam", "$kdvli TL"),
              SizedBox(
                width: MediaQuery.of(context).size.width,
                child: Divider(),
              ),
            ],
          ),
        );
        fiyatlarTemp.add(item);
      }
    }

    double maliyetToplam = maliyetToplamTemp;
    double kdvsizToplam = kdvsizToplamTemp;
    double kdvToplam = kdvToplamTemp;

    double genelToplam = kdvsizToplam + kdvToplam;
    //double kar = kdvsizToplam - maliyetToplam;
    List<Widget> fiyatlar = fiyatlarTemp;
    return Column(
      children: [
        SectionCard(
          icon: Icons.price_check,
          title: "Yapılan İşlemler",
          children: [
            if (fiyatlar.isNotEmpty && widget.maliyetGosterButon)
              Container(
                width: MediaQuery.of(context).size.width,
                alignment: Alignment.centerLeft,
                child: IconButton(
                  onPressed: () async {
                    setState(() {
                      maliyetGoster = !maliyetGoster;
                    });
                  },
                  icon: Icon(
                    maliyetGoster
                        ? CupertinoIcons.eye
                        : CupertinoIcons.eye_slash,
                  ),
                ),
              ),

            if (fiyatlar.isNotEmpty) ...fiyatlar,
            if (fiyatlar.isEmpty)
              Text(
                "Şuanda yapılmış bir işlem yok.",
                textAlign: TextAlign.center,
              ),
          ],
        ),
        SectionCard(
          icon: Icons.price_change,
          title: "Toplam Tutarlar",
          children: [
            if (maliyetGoster && widget.maliyetGosterButon)
              buildRow("Maliyet", "${maliyetToplam.toStringAsFixed(2)} TL"),
            buildRow("Toplam", "${kdvsizToplam.toStringAsFixed(2)} TL"),
            buildRow("KDV", "${kdvToplam.toStringAsFixed(2)} TL"),
            buildRow("Genel Toplam", "${genelToplam.toStringAsFixed(2)} TL"),
            //if (maliyetGoster && widget.maliyetGosterButon)
            //  buildRow("Kar", "${kar.toStringAsFixed(2)} TL"),
          ],
        ),
      ],
    );
  }

  Widget buildRow(String title, String value) {
    return Row(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text("$title: ", style: TextStyle(fontWeight: FontWeight.bold)),
        Expanded(child: Text(value)),
      ],
    );
  }
}
