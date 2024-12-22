class Ayarlar {
  static String get _url => const String.fromEnvironment('API_URL');

  static String get url {
    if (_url.endsWith("/")) {
      return _url;
    } else {
      return "$_url/";
    }
  }

  static String get girisYap => "${url}girisyap/";
  static String get kullaniciGetir => "${url}kullaniciGetir/";
  static String get cihazlarTumu => "${url}cihazlarTumu/";

  static String get token => const String.fromEnvironment('TOKEN');
}
