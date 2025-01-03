class AyarlarModel {
  final bool kisModu;

  const AyarlarModel({
    required this.kisModu,
  });

  factory AyarlarModel.fromJson(Map<String, dynamic> json) {
    if (json.containsKey("kis_modu")) {
      return AyarlarModel.empty();
      //return AyarlarModel(kisModu: json["kis_modu"] == "1");
    } else {
      return AyarlarModel.empty();
    }
  }

  factory AyarlarModel.empty() {
    return AyarlarModel(kisModu: false);
  }
}
