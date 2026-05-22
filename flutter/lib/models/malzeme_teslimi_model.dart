class MalzemeTeslimiModel {
  final int id;
  final String teslimNo;
  final String firma;
  final String siparisTarihi;
  final String teslimTarihi;
  final String vadeTarihi;
  final String teslimEden;
  final String teslimAlan;
  final int odemeDurumu;
  final bool odendi;
  final bool vadeDurumu;
  final String vadeStr;

  const MalzemeTeslimiModel({
    required this.id,
    required this.teslimNo,
    required this.firma,
    required this.siparisTarihi,
    required this.teslimTarihi,
    required this.vadeTarihi,
    required this.teslimEden,
    required this.teslimAlan,
    required this.odemeDurumu,
    required this.odendi,
    required this.vadeDurumu,
    required this.vadeStr,
  });

  factory MalzemeTeslimiModel.create({
    required int id,
    required String teslimNo,
    required String firma,
    required String siparisTarihi,
    required String teslimTarihi,
    required String vadeTarihi,
    required String teslimEden,
    required String teslimAlan,
    required int odemeDurumu,
    required bool odendi,
    required bool vadeDurumu,
    required String vadeStr,
  }) {
    return MalzemeTeslimiModel(
      id: id,
      teslimNo: teslimNo,
      firma: firma,
      siparisTarihi: siparisTarihi,
      teslimTarihi: teslimTarihi,
      vadeTarihi: vadeTarihi,
      teslimEden: teslimEden,
      teslimAlan: teslimAlan,
      odendi: odendi,
      vadeDurumu: vadeDurumu,
      odemeDurumu: odemeDurumu,
      vadeStr: vadeStr,
    );
  }
  factory MalzemeTeslimiModel.fromJson(Map<String, dynamic> json) {
    return MalzemeTeslimiModel(
      id: int.tryParse(json["id"].toString()) ?? 0,
      teslimNo: json["teslim_no"] ?? "",
      firma: json["firma"] ?? "",
      siparisTarihi: json["siparis_tarihi"] ?? "2025-01-01 0:00:00",
      teslimTarihi: json["teslim_tarihi"] ?? "2025-01-01 0:00:00",
      vadeTarihi: json["vade_tarihi"] ?? "2025-01-01 0:00:00",
      teslimEden: json["teslim_eden"] ?? "",
      teslimAlan: json["teslim_alan"] ?? "",
      odemeDurumu: int.tryParse(json["odeme_durumu"].toString()) ?? 0,
      odendi: bool.tryParse(json["odendi"].toString()) ?? false,
      vadeDurumu: bool.tryParse(json["vade_durumu"].toString()) ?? false,
      vadeStr: json["vade_str"] ?? "",
    );
  }
}
