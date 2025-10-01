class AyarlarModel {
  final String sirketTelefonu;

  const AyarlarModel({required this.sirketTelefonu});
  factory AyarlarModel.create({required String sirketTelefonu}) {
    return AyarlarModel(sirketTelefonu: sirketTelefonu);
  }
  factory AyarlarModel.fromJson(Map<String, dynamic> json) {
    return AyarlarModel(sirketTelefonu: json["sirket_telefonu"] ?? "");
  }
}
