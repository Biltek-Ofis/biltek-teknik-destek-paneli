class SifreModel {
  final int id;
  final String musteriAdi;
  final String aciklama;
  final String kAdi;
  final String sifre;
  final int olusturanID;
  final String olusturan;
  final String tarih;
  final int duzenleyenID;
  final String duzenleyen;
  final String sonDuzenleme;

  const SifreModel({
    required this.id,
    required this.musteriAdi,
    required this.aciklama,
    required this.kAdi,
    required this.sifre,
    required this.olusturanID,
    required this.olusturan,
    required this.tarih,
    required this.duzenleyenID,
    required this.duzenleyen,
    required this.sonDuzenleme,
  });

  factory SifreModel.create({
    required int id,
    required String musteriAdi,
    required String aciklama,
    required String kAdi,
    required String sifre,
    required int olusturanID,
    required String olusturan,
    required String tarih,
    required int duzenleyenID,
    required String duzenleyen,
    required String sonDuzenleme,
  }) {
    return SifreModel(
      id: id,
      musteriAdi: musteriAdi,
      aciklama: aciklama,
      kAdi: kAdi,
      sifre: sifre,
      olusturanID: olusturanID,
      olusturan: olusturan,
      tarih: tarih,
      duzenleyenID: duzenleyenID,
      duzenleyen: duzenleyen,
      sonDuzenleme: sonDuzenleme,
    );
  }
  factory SifreModel.fromJson(Map<String, dynamic> json) {
    return SifreModel(
      id: int.tryParse(json["id"].toString()) ?? 0,
      musteriAdi: json["musteri_adi"] ?? "",
      aciklama: json["aciklama"] ?? "",
      kAdi: json["k_adi"] ?? "",
      sifre: json["sifre"] ?? "",
      olusturanID: int.tryParse(json["olusturan_id"].toString()) ?? 0,
      olusturan: json["olusturan"] ?? "",
      tarih: json["tarih"] ?? "2025-01-01 0:00:00",
      duzenleyenID: int.tryParse(json["duzenleyen_id"].toString()) ?? 0,
      duzenleyen: json["duzenleyen"] ?? "",
      sonDuzenleme: json["son_duzenleme"] ?? "2025-01-01 0:00:00",
    );
  }
}
