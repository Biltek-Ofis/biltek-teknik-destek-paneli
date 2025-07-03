import '../utils/islemler.dart';

class AiChatModel {
  final String id;
  final String mesaj;
  final String? tarih;
  final bool isUser;

  const AiChatModel({
    required this.id,
    required this.mesaj,
    required this.tarih,
    required this.isUser,
  });
  factory AiChatModel.create({required String mesaj, required bool isUser}) {
    return AiChatModel(
      id: Islemler.rastgeleYazi(10),
      mesaj: mesaj,
      tarih: DateTime.now().toIso8601String(),
      isUser: isUser,
    );
  }
  factory AiChatModel.fromJson(Map<String, dynamic> json) {
    return switch (json) {
      {
        'id': String id,
        'mesaj': String mesaj,
        'tarih': String tarih,
        "isUser": String isUser,
      } =>
        AiChatModel(
          id: id,
          mesaj: mesaj,
          tarih: tarih,
          isUser: (int.tryParse(isUser) ?? 1) == 1,
        ),
      _ => AiChatModel(id: "0", mesaj: "", tarih: "", isUser: true),
    };
  }
  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'mesaj': mesaj,
      'tarih': tarih ?? DateTime.now().toIso8601String(),
      'isUser': isUser ? '1' : '0',
    };
  }
}
