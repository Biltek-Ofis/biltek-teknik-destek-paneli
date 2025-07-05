class AiResponseModel {
  final String type;
  final String query;

  const AiResponseModel({required this.type, required this.query});
  factory AiResponseModel.fromJson(Map<String, dynamic> json) {
    return switch (json) {
      {'type': String type, 'query': String query} => AiResponseModel(
        type: type,
        query: query,
      ),
      _ => AiResponseModel(type: "gecersiz", query: ""),
    };
  }
  Map<String, dynamic> toJson() {
    return {'type': type, 'query': query};
  }
}
