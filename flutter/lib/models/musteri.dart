class MusteriModel {
  final int id;
  final String musteriAdi;
  final String adres;
  final String telefonNumarasi;

  const MusteriModel({
    required this.id,
    required this.musteriAdi,
    required this.adres,
    required this.telefonNumarasi,
  });

  factory MusteriModel.fromJson(Map<String, dynamic> json) {
    return switch (json) {
      {
        'id': String id,
        'musteri_adi': String musteriAdi,
        'adres': String adres,
        'telefon_numarasi': String telefonNumarasi,
      } =>
        MusteriModel(
          id: int.tryParse(id) ?? 0,
          musteriAdi: musteriAdi,
          adres: adres,
          telefonNumarasi: telefonNumarasi,
        ),
      _ => throw const FormatException("Musteri getirilirken bir hata oluştu"),
    };
  }
}
