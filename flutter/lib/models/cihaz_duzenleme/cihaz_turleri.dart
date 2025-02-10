class CihazTurleriModel {
  final int id;
  final int siralama;
  final String isim;
  final bool sifre;
  final bool goster;

  const CihazTurleriModel({
    required this.id,
    required this.siralama,
    required this.isim,
    required this.sifre,
    required this.goster,
  });

  factory CihazTurleriModel.fromJson(Map<String, dynamic> json) {
    return switch (json) {
      {
        'id': String id,
        'siralama': String siralama,
        'isim': String isim,
        'sifre': String sifre,
        'goster': String goster,
      } =>
        CihazTurleriModel(
          id: int.tryParse(id) ?? 0,
          siralama: int.tryParse(siralama) ?? 0,
          isim: isim,
          sifre: sifre == "1",
          goster: goster == "1",
        ),
      _ => throw const FormatException(
          "Cihaz Türleri getirilirken bir hata oluştu"),
    };
  }
}
