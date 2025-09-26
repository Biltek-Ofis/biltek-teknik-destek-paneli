class BildirimModel {
  static const String cagriKey = "cagri";
  final String id;
  final String tur;
  final bool durum;

  const BildirimModel({
    required this.id,
    required this.tur,
    required this.durum,
  });
  factory BildirimModel.create({required String tur, required bool durum}) {
    return BildirimModel(id: "1", tur: tur, durum: durum);
  }
  factory BildirimModel.fromJson(Map<String, dynamic> json) {
    return BildirimModel(
      id: json["id"] ?? "0",
      tur: json["tur"] ?? "",
      durum: (json["durum"] ?? "0") == "1" ? true : false,
    );
  }
  Map<String, dynamic> toJson() {
    return {'id': id, 'tur': tur, 'durum': durum};
  }
}
