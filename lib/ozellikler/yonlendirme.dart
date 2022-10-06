import 'package:fluro/fluro.dart';
import 'package:flutter/cupertino.dart';

import '../sayfalar/anasayfa.dart';
import '../sayfalar/cihazlarim.dart';
import '../sayfalar/detaylar.dart';
import '../sayfalar/giris.dart';
import '../sayfalar/splash.dart';
import '../sayfalar/yeni_cihaz_girisi.dart';
import 'argumanlar.dart';

class Yonlendirme {
  static FluroRouter router = FluroRouter();
  static void routerAyarla() {
    router.define(
      Anasayfa.yol,
      handler: anasayfaHandler,
    );
    router.define(
      SplashScreen.yol,
      handler: splashScreenHandler,
    );
    router.define(
      GirisYap.yol,
      handler: girisYapHandler,
    );
    router.define(
      Cihazlarim.yol,
      handler: cihazlarimHandler,
    );
    router.define(
      YeniCihazGirisi.yol,
      handler: yeniCihazGirisiHandler,
    );
    router.define(
      "${CihazDetaylari.yol}${CihazDetaylari.argumanlar()}",
      handler: cihazDetaylariHandler,
    );
  }

  static Handler anasayfaHandler = Handler(
    handlerFunc: (context, Map<String, dynamic> params) {
      DirektGiris giris =
          (context!.settings!.arguments as DirektGiris?) ?? DirektGiris(true);
      return Anasayfa(
        direktGiris: giris.direktGiris,
      );
    },
  );
  static Handler splashScreenHandler = Handler(
    handlerFunc: (context, Map<String, dynamic> params) {
      return const SplashScreen();
    },
  );
  static Handler girisYapHandler = Handler(
    handlerFunc: (context, Map<String, dynamic> params) {
      return const GirisYap();
    },
  );
  static Handler cihazlarimHandler = Handler(
    handlerFunc: (context, Map<String, dynamic> params) {
      DirektGiris giris =
          (context!.settings!.arguments as DirektGiris?) ?? DirektGiris(true);
      return Cihazlarim(
        direktGiris: giris.direktGiris,
      );
    },
  );
  static Handler yeniCihazGirisiHandler =
      Handler(handlerFunc: (context, Map<String, dynamic> params) {
    DirektGiris giris =
        (context!.settings!.arguments as DirektGiris?) ?? DirektGiris(true);
    return YeniCihazGirisi(
      direktGiris: giris.direktGiris,
    );
  });
  static Handler cihazDetaylariHandler =
      Handler(handlerFunc: (context, Map<String, dynamic> params) {
    DirektGiris giris =
        (context!.settings!.arguments as DirektGiris?) ?? DirektGiris(true);
    return CihazDetaylari(
      direktGiris: giris.direktGiris,
      servisNo: (params["servisNo"].first as String?) ?? "0",
    );
  });

  static void git(
    BuildContext context,
    String yol, {
    bool clearStack = false,
    bool replace = false,
    TransitionType transition = TransitionType.fadeIn,
    RouteSettings? routeSettings,
  }) {
    router.navigateTo(
      context,
      yol,
      clearStack: clearStack,
      replace: replace,
      transition: transition,
      routeSettings:
          routeSettings ?? RouteSettings(arguments: DirektGiris(false)),
    );
  }
}
