import 'package:android_id/android_id.dart';
import 'package:flutter/material.dart';
import 'package:mask_text_input_formatter/mask_text_input_formatter.dart';
import 'package:universal_io/io.dart';

class Islemler {
  static Color? arkaRenk(
    String renkClass, {
    int? alpha,
  }) {
    alpha ??= (255 * 0.3).floor();
    switch (renkClass) {
      case "bg-white":
        return Colors.white;
      case "bg-dark":
        return Colors.black;
      case "bg-secondary":
        return Color.fromARGB(alpha, 108, 117, 125);
      case "bg-primary":
        return Color.fromARGB(alpha, 0, 123, 255);
      case "bg-success":
        return Color.fromARGB(alpha, 40, 167, 69);
      case "bg-danger":
        return Color.fromARGB(alpha, 220, 53, 69);
      case "bg-pink":
        return Color.fromARGB(alpha, 232, 62, 140);
      case "bg-warning":
        return Color.fromARGB(alpha, 255, 193, 7);
      case "bg-info":
        return Color.fromARGB(alpha, 23, 162, 184);

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
    "Diğer"
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

  static final List<String> evetHayirlar = [
    "Belirtilmemiş",
    "Evet",
    "Hayır",
  ];
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

  static String tarihFormat = "dd.MM.yyyy HH:mm";
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
}
