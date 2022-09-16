class Variables {
  static int parseInt({
    required String? sayi,
    int varsayilan = 0,
  }) {
    return int.tryParse(sayi ?? "0") ?? varsayilan;
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
