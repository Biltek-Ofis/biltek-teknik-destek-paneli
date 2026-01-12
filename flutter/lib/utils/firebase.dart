import 'package:firebase_app_check/firebase_app_check.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:flutter/foundation.dart';

import '../ayarlar.dart';
import '../firebase_ayarlari.dart';

class FirebaseApi {
  static FirebaseApp? instance;
  static FirebaseAppCheck get appCheck => FirebaseAppCheck.instance;

  static Future<void> initialize() async {
    instance ??= await Firebase.initializeApp(
      options: DefaultFirebaseOptions.currentPlatform,
    );

    await FirebaseAppCheck.instance.activate(
      providerWeb: ReCaptchaV3Provider(Ayarlar.firebase.recaptchaSiteKey),
      providerAndroid:
          kDebugMode ? AndroidDebugProvider() : AndroidPlayIntegrityProvider(),
      providerApple:
          kDebugMode ? AppleDebugProvider() : AppleAppAttestProvider(),
    );

    /*FirebaseMessaging.onMessage.listen((message) {
      showNotification(
        title: message.notification?.title,
        body: message.notification?.body,
      );
    });*/
  }
}
