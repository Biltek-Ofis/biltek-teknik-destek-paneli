import 'package:flutter/foundation.dart';

class Ayarlar {
  static const String _debugUrl = String.fromEnvironment('DEBUG_API_URL');
  static const String _apiUrl = String.fromEnvironment('API_URL');
  static String get _url {
    return kDebugMode ? _debugUrl : _apiUrl;
  }

  static String get url {
    if (_url.endsWith("/")) {
      return _url;
    } else {
      return "$_url/";
    }
  }

  static String get deepLinkUrl => "biltekts://";

  static String get appUrl => "${url}app/";

  static String get ayarlar => "${appUrl}ayarlar/";

  static String get fcmToken => "${appUrl}fcmToken/";
  static String get fcmTokenSifirla => "${appUrl}fcmTokenSifirla/";

  static String get girisYap => "${appUrl}girisyap/";
  static String get kullaniciGetir => "${appUrl}kullaniciGetir/";
  static String get kullaniciGuncelle => "${appUrl}kullaniciGuncelle/";
  static String get cihazlarTumu => "${appUrl}cihazlarTumu/";
  static String get tekCihaz => "${appUrl}tekCihaz/";
  static String get tekCihazNoAuth => "${appUrl}tekCihazNoAuth/";
  static String get version => "${appUrl}version/";
  static String get download => "${appUrl}download/";
  static String get bilgisayardaAc => "${appUrl}bilgisayardaAc/";
  static String get medyalar => "${appUrl}medyalar/";
  static String get medyaYukle => "${appUrl}medyaYukle/";
  static String get medyaSil => "${appUrl}medyaSil/";
  static String get cihazEkle => "${appUrl}cihazEkle/";
  static String get cihazDuzenle => "${appUrl}cihazDuzenle/";
  static String get cihazTurleri => "${appUrl}cihazTurleri/";
  static String get cihazDuzenleme => "${appUrl}cihazDuzenleme/";
  static String get musteriler => "${appUrl}musteriler/";

  static String get bildirimleriGetir => "${appUrl}bildirimleriGetir/";
  static String get bildirimAyarla => "${appUrl}bildirimAyarla/";
  static String get bildirimAyarlaToplu => "${appUrl}bildirimAyarlaToplu/";

  static String get cagriKaydi => "${appUrl}cagriKaydi/";
  static String get cagriKayitlari => "${appUrl}cagriKayitlari/";
  static String get fiyatiOnayla => "${appUrl}fiyatiOnayla/";
  static String get fiyatiReddet => "${appUrl}fiyatiReddet/";
  static String get cagriKaydiSil => "${appUrl}cagriKaydiSil/";

  static String get imzaYukle => "${appUrl}imzaYukle/";
  static String get imzaSil => "${appUrl}imzaSil/";

  static String get malzemeTeslimleri => "${appUrl}malzemeTeslimleri/";

  static String get notlar => "${appUrl}notlar/";
  static String get notEkle => "${appUrl}notEkle/";
  static String get notDuzenle => "${appUrl}notDuzenle/";
  static String get notSil => "${appUrl}notSil/";

  static String get sifreler => "${appUrl}sifreler/";
  static String get sifreEkle => "${appUrl}sifreEkle/";
  static String get sifreDuzenle => "${appUrl}sifreDuzenle/";
  static String get sifreSil => "${appUrl}sifreSil/";

  static String get qrEkle => "${appUrl}qrEkle/";

  // Deeplinks
  static String get cihazDurumu => "${url}cihazdurumu/";
  static String get cihazDurumuDeep => "$deepLinkUrl/cihazdurumu/";

  static String teknikservisformu({
    required String auth,
    required int cihazID,
  }) {
    return "${url}cihaz/teknik_servis_formu/$cihazID?auth=$auth&inApp=1";
  }

  static const String _lisansEtkin = String.fromEnvironment('LISANS_ETKIN');
  static bool get lisansEtkin => _lisansEtkin.toLowerCase() == "true";

  static const String _urlLisans = String.fromEnvironment('LISANS_URL');

  static String get urlLisans {
    if (_url.endsWith("/")) {
      return _urlLisans;
    } else {
      return "$_urlLisans/";
    }
  }

  static String get appUrlLisans => "${urlLisans}app/";
  static String get lisanslarTumu => "${appUrlLisans}lisanslar/";
  static String get lisansEkle => "${appUrlLisans}lisans_ekle/";
  static String get lisansDuzenle => "${appUrlLisans}lisans_duzenle/";
  static String get lisansSil => "${appUrlLisans}lisans_sil/";
  static String get versiyonlarTumu => "${appUrlLisans}versiyonlar/";
  static String get versiyonEkle => "${appUrlLisans}versiyon_ekle/";
  static String get versiyonDuzenle => "${appUrlLisans}versiyon_duzenle/";
  static String get versiyonSil => "${appUrlLisans}versiyon_sil/";

  static const String token = String.fromEnvironment('TOKEN');

  static const String surumTarihi = String.fromEnvironment('SURUM_TARIHI');

  static FirebaseAyarlari get firebase => FirebaseAyarlari();
}

class FirebaseAyarlari {
  static const String _projectID = String.fromEnvironment(
    'FIREBASE_PROJECT_ID',
  );
  String get projectID => _projectID;

  static const String _storageBucket = String.fromEnvironment(
    'FIREBASE_STORAGE_BUCKET',
  );
  String get storageBucket => _storageBucket;

  static const String _messagingSenderId = String.fromEnvironment(
    'FIREBASE_MESSAGING_SENDER_ID',
  );
  String get messagingSenderId => _messagingSenderId;

  static const String _authDomain = String.fromEnvironment(
    'FIREBASE_AUTH_DOMAIN',
  );
  String get authDomain => _authDomain;

  static const String _androidApiKey = String.fromEnvironment(
    'FIREBASE_ANDROID_API_KEY',
  );
  String get androidApiKey => _androidApiKey;

  static const String _androidAppID = String.fromEnvironment(
    'FIREBASE_ANDROID_APP_ID',
  );
  String get androidAppID => _androidAppID;

  static const String _webApiKey = String.fromEnvironment(
    'FIREBASE_WEB_API_KEY',
  );
  String get webApiKey => _webApiKey;

  static const String _webAppID = String.fromEnvironment('FIREBASE_WEB_APP_ID');
  String get webAppID => _webAppID;

  static const String _recaptchaSiteKey = String.fromEnvironment(
    'RECAPTCHA_SITE_KEY',
  );
  String get recaptchaSiteKey => _recaptchaSiteKey;
}
