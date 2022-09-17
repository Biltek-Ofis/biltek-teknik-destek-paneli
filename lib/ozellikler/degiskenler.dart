import 'package:decimal/decimal.dart';

class Degiskenler {
  static int parseInt({
    required String? sayi,
    int varsayilan = 0,
  }) {
    return int.tryParse(sayi ?? "0") ?? varsayilan;
  }

  static Decimal parseDecimal({
    required String? sayi,
    Decimal? varsayilan,
  }) {
    varsayilan = varsayilan ?? Decimal.parse("0.00");
    return Decimal.tryParse(sayi ?? "0.00") ?? varsayilan;
  }

  static bool parseBool({
    required String? durum,
  }) {
    return (durum ?? "false").toLowerCase() == "true" ? true : false;
  }

  static String parseString({
    required String? yazi,
  }) {
    return yazi ?? "";
  }
}
