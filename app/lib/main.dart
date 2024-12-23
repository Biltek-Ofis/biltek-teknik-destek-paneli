import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/gestures.dart';
import 'package:flutter/material.dart';
import 'package:flutter_ringtone_player/flutter_ringtone_player.dart';
import 'package:overlay_support/overlay_support.dart';
import 'package:provider/provider.dart';
import 'package:universal_io/io.dart';

import 'firebase_options.dart';
import 'models/kullanici.dart';
import 'models/theme_model.dart';
import 'sayfalar/anasayfa.dart';
import 'sayfalar/cihazlarim.dart';
import 'sayfalar/giris_sayfasi.dart';
import 'utils/my_notifier.dart';
import 'utils/post.dart';
import 'utils/shared_preferences.dart';

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  if (Platform.isAndroid) {
    await Firebase.initializeApp(
      options: DefaultFirebaseOptions.currentPlatform,
    );
    FirebaseMessaging.onMessage.listen(
      (message) {
        if (Platform.isAndroid) {
          FlutterRingtonePlayer().playNotification();
        }
        showOverlayNotification(
          (context) {
            return Card(
              margin: const EdgeInsets.symmetric(horizontal: 4),
              child: SafeArea(
                child: ListTile(
                  leading: SizedBox.fromSize(
                    size: Size(message.notification?.title != null ? 40 : 20,
                        message.notification?.title != null ? 40 : 20),
                    child: ClipOval(
                      child: Container(
                        color: Colors.black,
                      ),
                    ),
                  ),
                  title: Text(message.notification?.title != null
                      ? message.notification!.title!
                      : (message.notification?.body != null
                          ? message.notification!.body!
                          : "")),
                  subtitle: message.notification?.title != null
                      ? (message.notification?.body != null
                          ? Text(message.notification!.body!)
                          : null)
                      : null,
                  trailing: IconButton(
                    icon: Icon(Icons.close),
                    onPressed: () {
                      OverlaySupportEntry.of(context)?.dismiss();
                    },
                  ),
                ),
              ),
            );
          },
          duration: Duration(milliseconds: 4000),
        );
      },
    );
  }

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
              themeMode: myNotifier.isDark == null
                  ? ThemeMode.system
                  : (myNotifier.isDark! ? ThemeMode.dark : ThemeMode.light),
              debugShowCheckedModeBanner: false,
              scrollBehavior: const MaterialScrollBehavior().copyWith(
                dragDevices: {
                  PointerDeviceKind.mouse,
                  PointerDeviceKind.touch,
                  PointerDeviceKind.stylus,
                  PointerDeviceKind.unknown
                },
              ),
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
      body: FutureBuilder<String?>(
        future: SharedPreference.getString(SharedPreference.authString),
        builder: (context, AsyncSnapshot<String?> snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return Center(
              child: CircularProgressIndicator(),
            );
          } else {
            if (snapshot.hasData && snapshot.data != null) {
              return FutureBuilder<KullaniciModel?>(
                future: BiltekPost.kullaniciGetir(snapshot.data!),
                builder: (context, AsyncSnapshot<KullaniciModel?> snapshot) {
                  if (snapshot.connectionState == ConnectionState.waiting) {
                    return Center(
                      child: CircularProgressIndicator(),
                    );
                  } else {
                    if (snapshot.hasData && snapshot.data != null) {
                      return snapshot.data!.teknikservis
                          ? CihazlarimSayfasi(
                              kullanici: snapshot.data!,
                            )
                          : Anasayfa(
                              kullanici: snapshot.data!,
                            );
                    } else {
                      return GirisSayfasi();
                    }
                  }
                },
              );
            } else {
              return GirisSayfasi();
            }
          }
        },
      ),
    );
  }
}
