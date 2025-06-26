import 'package:biltekteknikservis/widgets/overlay_notification.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/foundation.dart';
import 'package:flutter/gestures.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutter_inappwebview/flutter_inappwebview.dart';
import 'package:flutter_localizations/flutter_localizations.dart';
import 'package:overlay_support/overlay_support.dart';
import 'package:provider/provider.dart';

import 'firebase_ayarlari.dart';
import 'models/kullanici.dart';
import 'models/theme_model.dart';
import 'sayfalar/anasayfa.dart';
import 'sayfalar/cihazlarim.dart';
import 'sayfalar/giris_sayfasi.dart';
import 'utils/my_notifier.dart';
import 'utils/post.dart';
import 'utils/shared_preferences.dart';

WebViewEnvironment? webViewEnvironment;

void main() async {
  WidgetsFlutterBinding.ensureInitialized();

  LicenseRegistry.addLicense(() async* {
    final license = await rootBundle.loadString('fonts/OFL.txt');
    yield LicenseEntryWithLineBreaks(['google_fonts'], license);
  });

  await InAppWebViewController.setWebContentsDebuggingEnabled(kDebugMode);

  await Firebase.initializeApp(options: DefaultFirebaseOptions.currentPlatform);

  FirebaseMessaging.onMessage.listen((message) {
    showNotification(
      title: message.notification?.title,
      body: message.notification?.body,
    );
  });

  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return ChangeNotifierProvider(
      create: (_) => MyNotifier(),
      child: Consumer<MyNotifier>(
        builder: (context, MyNotifier myNotifier, child) {
          return OverlaySupport(
            child: MaterialApp(
              title: 'Biltek Teknik Servis',
              theme: ThemeModel.light,
              darkTheme: ThemeModel.dark,
              themeMode:
                  myNotifier.isDark == null
                      ? ThemeMode.system
                      : (myNotifier.isDark! ? ThemeMode.dark : ThemeMode.light),
              debugShowCheckedModeBanner: false,
              scrollBehavior: const MaterialScrollBehavior().copyWith(
                dragDevices: {
                  PointerDeviceKind.mouse,
                  PointerDeviceKind.touch,
                  PointerDeviceKind.stylus,
                  PointerDeviceKind.unknown,
                },
              ),
              localizationsDelegates: [
                GlobalMaterialLocalizations.delegate,
                GlobalWidgetsLocalizations.delegate,
                GlobalCupertinoLocalizations.delegate,
              ],
              locale: Locale("tr"),
              home: const MainPage(),
            ),
          );
        },
      ),
    );
  }
}

class MainPage extends StatelessWidget {
  const MainPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Consumer<MyNotifier>(
        builder: (context, MyNotifier myNotifier, child) {
          return FutureBuilder<String?>(
            future: SharedPreference.getString(SharedPreference.authString),
            builder: (context, AsyncSnapshot<String?> authSnapshot) {
              if (authSnapshot.connectionState == ConnectionState.waiting) {
                return Center(child: CircularProgressIndicator());
              } else {
                if (authSnapshot.hasData && authSnapshot.data != null) {
                  return FutureBuilder<KullaniciAuthModel?>(
                    future: BiltekPost.kullaniciGetir(authSnapshot.data!),
                    builder: (
                      context,
                      AsyncSnapshot<KullaniciAuthModel?> kullaniciSnapshot,
                    ) {
                      if (kullaniciSnapshot.connectionState ==
                          ConnectionState.waiting) {
                        return Center(child: CircularProgressIndicator());
                      } else {
                        if (kullaniciSnapshot.hasData &&
                            kullaniciSnapshot.data != null) {
                          return kullaniciSnapshot.data!.teknikservis
                              ? CihazlarimSayfasi(
                                kullanici: kullaniciSnapshot.data!,
                              )
                              : Anasayfa(kullanici: kullaniciSnapshot.data!);
                        } else {
                          return GirisSayfasi(
                            kullaniciAdi: myNotifier.username,
                          );
                        }
                      }
                    },
                  );
                } else {
                  return GirisSayfasi(kullaniciAdi: myNotifier.username);
                }
              }
            },
          );
        },
      ),
    );
  }
}
