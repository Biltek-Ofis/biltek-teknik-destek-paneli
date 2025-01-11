class GirisDurumu {
  final bool durum;
  final String auth;

  const GirisDurumu({required this.durum, required this.auth});

  factory GirisDurumu.fromJson(Map<String, dynamic> json) {
    return switch (json) {
      {
        'durum': bool durum,
        'auth': String auth,
      } =>
        GirisDurumu(
          durum: durum,
          auth: auth,
        ),
      _ =>
        throw const FormatException("Giriş durumu yüklerken bir hata oluştu"),
    };
  }
}

class HataDurumu {
  final int kod;
  final String mesaj;

  const HataDurumu({required this.kod, required this.mesaj});

  factory HataDurumu.fromJson(Map<String, dynamic> json) {
    return switch (json) {
      {
        'kod': int kod,
        'mesaj': String mesaj,
      } =>
        HataDurumu(
          kod: kod,
          mesaj: mesaj,
        ),
      _ =>
        throw const FormatException("Hata mesajı yüklerken bir hata oluştu."),
    };
  }
}
