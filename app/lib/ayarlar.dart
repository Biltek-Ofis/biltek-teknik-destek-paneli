class Ayarlar {
  static String get _url => const String.fromEnvironment('API_URL');

  static String get url {
    if (_url.endsWith("/")) {
      return _url;
    } else {
      return "$_url/";
    }
  }

  static String get appUrl => "${url}app/";

  static String get fcmToken => "${appUrl}fcmToken/";
  static String get fcmTokenSifirla => "${appUrl}fcmTokenSifirla/";

  static String get girisYap => "${appUrl}girisyap/";
  static String get kullaniciGetir => "${appUrl}kullaniciGetir/";
  static String get cihazlarTumu => "${appUrl}cihazlarTumu/";
  static String get tekCihaz => "${appUrl}tekCihaz/";
  static String get version => "${appUrl}version/";
  static String get download => "${appUrl}download/";

  static String teknikservisformu({
    required String auth,
    required int cihazID,
  }) {
    return "${url}cihaz/teknik_servis_formu/$cihazID?auth=$auth&inApp=1";
  }

  static String get token => const String.fromEnvironment('TOKEN');

  static FirebaseAyarlari get firebase => FirebaseAyarlari();
}

class FirebaseAyarlari {
  String get projectID => const String.fromEnvironment('FIREBASE_PROJECT_ID');
  String get authDomain => const String.fromEnvironment('FIREBASE_AUTH_DOMAIN');
  String get storageBucket =>
      const String.fromEnvironment('FIREBASE_STORAGE_BUCKET');
  String get messagingSenderId =>
      const String.fromEnvironment('FIREBASE_MESSAGING_SENDER_ID');

  String get androidApiKey =>
      const String.fromEnvironment('FIREBASE_ANDROID_API_KEY');
  String get androidAppID =>
      const String.fromEnvironment('FIREBASE_ANDROID_APP_ID');

  String get windowsApiKey =>
      const String.fromEnvironment('FIREBASE_WINDOWS_API_KEY');
  String get windowsAppID =>
      const String.fromEnvironment('FIREBASE_WINDOWS_APP_ID');
}
