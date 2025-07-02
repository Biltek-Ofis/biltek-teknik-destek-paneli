class AiChatModel {
  final int id;
  final String mesaj;
  final String? tarih;
  final bool isUser;

  const AiChatModel({
    required this.id,
    required this.mesaj,
    required this.tarih,
    required this.isUser,
  });

  factory AiChatModel.fromJson(Map<String, dynamic> json) {
    return switch (json) {
      {
        'id': String id,
        'mesaj': String mesaj,
        'tarih': String tarih,
        "isUser": String isUser,
      } =>
        AiChatModel(
          id: int.tryParse(id) ?? 0,
          mesaj: mesaj,
          tarih: tarih,
          isUser: (int.tryParse(isUser) ?? 1) == 1,
        ),
      _ => AiChatModel(id: 0, mesaj: "", tarih: "", isUser: true),
    };
  }
}
