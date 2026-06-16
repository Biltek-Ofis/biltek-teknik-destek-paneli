import 'package:biltekteknikservis/sayfalar/ayarlar/yazici.dart';
import 'package:flutter/foundation.dart';
import 'package:flutter/gestures.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutter_inappwebview/flutter_inappwebview.dart';
import 'package:flutter_localizations/flutter_localizations.dart';
import 'package:overlay_support/overlay_support.dart';
import 'package:provider/provider.dart';

import 'models/kullanici.dart';
import 'models/theme_model.dart';
import 'models/yazici.dart';
import 'sayfalar/anasayfa.dart';
import 'sayfalar/giris_sayfasi.dart';
import 'sayfalar/guncelleme.dart';
import 'utils/firebase.dart';
import 'utils/my_notifier.dart';
import 'utils/post.dart';
import 'utils/secure_storage.dart';
import 'widgets/restart.dart';

WebViewEnvironment? webViewEnvironment;

void main() async {
  WidgetsFlutterBinding.ensureInitialized();

  const channel = MethodChannel('biltekteknikservis/printer');
  String? initialRoute;
  try {
    initialRoute = await channel.invokeMethod<String>('getInitialRoute');
  } catch (_) {}

  await YaziciModel.loadSavedPrinters();

  SystemChrome.setEnabledSystemUIMode(SystemUiMode.edgeToEdge);

  await SecureStorage.init();

  await FirebaseApi.initialize();

  LicenseRegistry.addLicense(() async* {
    final license = await rootBundle.loadString('fonts/OFL.txt');
    yield LicenseEntryWithLineBreaks(['google_fonts'], license);
  });
  if (!kIsWeb) {
    await InAppWebViewController.setWebContentsDebuggingEnabled(kDebugMode);
  }
  runApp(RestartWidget(child: MyApp(initialRoute: initialRoute)));
}

class MyApp extends StatelessWidget {
  const MyApp({super.key, this.initialRoute});

  final String? initialRoute;

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
              supportedLocales: [Locale("tr")],
              locale: Locale("tr"),
              home: MainPage(initialRoute: initialRoute),
            ),
          );
        },
      ),
    );
  }
}

class MainPage extends StatelessWidget {
  const MainPage({super.key, this.initialRoute});

  final String? initialRoute;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Consumer<MyNotifier>(
        builder: (context, MyNotifier myNotifier, child) {
          return initialRoute == 'yazici_ayarlari'
              ? YaziciAyarlari()
              : FutureBuilder<bool>(
                future: BiltekPost.guncellemeGerekli(),
                builder: (context, AsyncSnapshot<bool> guncellemeSnapshot) {
                  if (guncellemeSnapshot.connectionState ==
                      ConnectionState.waiting) {
                    return Center(child: CircularProgressIndicator());
                  } else {
                    if (guncellemeSnapshot.data == true) {
                      return GuncellemeSayfasi();
                    } else {
                      return FutureBuilder<String?>(
                        future: SecureStorage.getString(
                          SecureStorage.authString,
                        ),
                        builder: (
                          context,
                          AsyncSnapshot<String?> authSnapshot,
                        ) {
                          if (authSnapshot.connectionState ==
                              ConnectionState.waiting) {
                            return Center(child: CircularProgressIndicator());
                          } else {
                            if (authSnapshot.hasData &&
                                authSnapshot.data != null) {
                              return FutureBuilder<KullaniciAuthModel?>(
                                future: BiltekPost.kullaniciGetir(
                                  authSnapshot.data!,
                                ),
                                builder: (
                                  context,
                                  AsyncSnapshot<KullaniciAuthModel?>
                                  kullaniciSnapshot,
                                ) {
                                  if (kullaniciSnapshot.connectionState ==
                                      ConnectionState.waiting) {
                                    return Center(
                                      child: CircularProgressIndicator(),
                                    );
                                  } else {
                                    if (kullaniciSnapshot.hasData &&
                                        kullaniciSnapshot.data != null &&
                                        kullaniciSnapshot.data!.id != 0) {
                                      return Anasayfa(
                                        sayfa:
                                            kullaniciSnapshot.data!.musteri
                                                ? "cagri"
                                                : (kullaniciSnapshot
                                                        .data!
                                                        .teknikservis
                                                    ? "cihazlarim"
                                                    : "anasayfa"),
                                        kullanici: kullaniciSnapshot.data!,
                                      );
                                    } else {
                                      return GirisSayfasi(
                                        spKullanici: myNotifier.kullanici,
                                      );
                                    }
                                  }
                                },
                              );
                            } else {
                              return GirisSayfasi(
                                spKullanici: myNotifier.kullanici,
                              );
                            }
                          }
                        },
                      );
                    }
                  }
                },
              );
        },
      ),
    );
  }
}
