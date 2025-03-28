class Versiyon {
  final int id;
  final String versiyon;

  const Versiyon({
    required this.id,
    required this.versiyon,
  });
  factory Versiyon.fromJson(Map<String, dynamic> json) {
    return switch (json) {
      {
        "id": String id,
        "versiyon": String versiyon,
      } =>
        Versiyon(
          id: int.tryParse(id) ?? 0,
          versiyon: versiyon,
        ),
      _ => throw FormatException("Versiyon yüklenirken hata oluştu."),
    };
  }
}
