class AyarlarModel {
  final String sirketTelefonu;
  final bool maliyetGoster;

  const AyarlarModel({
    required this.sirketTelefonu,
    required this.maliyetGoster,
  });
  factory AyarlarModel.create({
    required String sirketTelefonu,
    required bool maliyetGoster,
  }) {
    return AyarlarModel(
      sirketTelefonu: sirketTelefonu,
      maliyetGoster: maliyetGoster,
    );
  }
  factory AyarlarModel.fromJson(Map<String, dynamic> json) {
    return AyarlarModel(
      sirketTelefonu: json["sirket_telefonu"] ?? "",
      maliyetGoster: (json["maliyet_goster"] ?? "0").toString() != "0",
    );
  }
}
