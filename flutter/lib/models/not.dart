class NotModel {
  final int id;
  final String aciklama;
  final int olusturanID;
  final String olusturan;
  final String tarih;
  final int duzenleyenID;
  final String duzenleyen;
  final String sonDuzenleme;

  const NotModel({
    required this.id,
    required this.aciklama,
    required this.olusturanID,
    required this.olusturan,
    required this.tarih,
    required this.duzenleyenID,
    required this.duzenleyen,
    required this.sonDuzenleme,
  });

  factory NotModel.create({
    required int id,
    required String aciklama,
    required int olusturanID,
    required String olusturan,
    required String tarih,
    required int duzenleyenID,
    required String duzenleyen,
    required String sonDuzenleme,
  }) {
    return NotModel(
      id: id,
      aciklama: aciklama,
      olusturanID: olusturanID,
      olusturan: olusturan,
      tarih: tarih,
      duzenleyenID: duzenleyenID,
      duzenleyen: duzenleyen,
      sonDuzenleme: sonDuzenleme,
    );
  }
  factory NotModel.fromJson(Map<String, dynamic> json) {
    return NotModel(
      id: int.tryParse(json["id"].toString()) ?? 0,
      aciklama: json["aciklama"] ?? "",
      olusturanID: int.tryParse(json["olusturan_id"].toString()) ?? 0,
      olusturan: json["olusturan"] ?? "",
      tarih: json["tarih"] ?? "2025-01-01 0:00:00",
      duzenleyenID: int.tryParse(json["duzenleyen_id"].toString()) ?? 0,
      duzenleyen: json["duzenleyen"] ?? "",
      sonDuzenleme: json["son_duzenleme"] ?? "2025-01-01 0:00:00",
    );
  }
}
