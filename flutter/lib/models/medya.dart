class MedyaModel {
  final int id;
  final int cihazID;
  final String konum;
  final bool yerel;
  final String tur;

  const MedyaModel({
    required this.id,
    required this.cihazID,
    required this.konum,
    required this.yerel,
    required this.tur,
  });

  factory MedyaModel.fromJson(Map<String, dynamic> json) {
    return switch (json) {
      {
        'id': String id,
        'cihaz_id': String cihazID,
        'konum': String konum,
        'yerel': String yerel,
        'tur': String tur,
      } =>
        MedyaModel(
          id: int.tryParse(id) ?? 0,
          cihazID: int.tryParse(cihazID) ?? 0,
          konum: konum,
          yerel: yerel == "1",
          tur: tur,
        ),
      _ => throw const FormatException("Medya getirilirken bir hata oluştu"),
    };
  }
}
