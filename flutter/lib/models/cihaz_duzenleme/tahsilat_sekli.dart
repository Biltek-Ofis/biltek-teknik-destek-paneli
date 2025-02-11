class TahsilatSekli {
  final int id;
  final String isim;

  const TahsilatSekli({
    required this.id,
    required this.isim,
  });

  factory TahsilatSekli.fromJson(Map<String, dynamic> json) {
    return switch (json) {
      {
        'id': String id,
        'isim': String isim,
      } =>
        TahsilatSekli(
          id: int.tryParse(id) ?? 0,
          isim: isim,
        ),
      _ => throw const FormatException(
          "Tahsilat şekilleri getirilirken bir hata oluştu"),
    };
  }
}
