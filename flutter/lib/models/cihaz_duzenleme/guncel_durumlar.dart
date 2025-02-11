class GuncelDurumModel {
  final int id;
  final int siralama;
  final String durum;
  final String renk;
  final bool kilitle;
  final bool varsayilan;

  const GuncelDurumModel({
    required this.id,
    required this.siralama,
    required this.durum,
    required this.renk,
    required this.kilitle,
    required this.varsayilan,
  });

  factory GuncelDurumModel.fromJson(Map<String, dynamic> json) {
    return switch (json) {
      {
        'id': String id,
        'siralama': String siralama,
        'durum': String durum,
        'renk': String renk,
        'kilitle': String kilitle,
        'varsayilan': String varsayilan,
      } =>
        GuncelDurumModel(
          id: int.tryParse(id) ?? 0,
          siralama: int.tryParse(siralama) ?? 0,
          durum: durum,
          renk: renk,
          kilitle: kilitle.toString() == "1",
          varsayilan: varsayilan.toString() == "1",
        ),
      _ => throw const FormatException(
          "Güncel durumları getirilirken bir hata oluştu"),
    };
  }
}
