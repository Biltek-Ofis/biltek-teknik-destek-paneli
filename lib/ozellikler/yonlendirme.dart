import 'package:fluro/fluro.dart';
import 'package:flutter/cupertino.dart';

import '../sayfalar/anasayfa.dart';
import '../sayfalar/cihazlarim.dart';
import '../sayfalar/detaylar.dart';
import '../sayfalar/giris.dart';
import '../sayfalar/splash.dart';

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
      "${CihazDetaylari.yol}${CihazDetaylari.argumanlar()}",
      handler: cihazDetaylariHandler,
    );
  }

  static Handler anasayfaHandler = Handler(
    handlerFunc: (context, Map<String, dynamic> params) => const Anasayfa(),
  );
  static Handler splashScreenHandler = Handler(
    handlerFunc: (context, Map<String, dynamic> params) => const SplashScreen(),
  );
  static Handler girisYapHandler = Handler(
    handlerFunc: (context, Map<String, dynamic> params) => const GirisYap(),
  );
  static Handler cihazlarimHandler = Handler(
    handlerFunc: (context, Map<String, dynamic> params) => const Cihazlarim(),
  );
  static Handler cihazDetaylariHandler = Handler(
    handlerFunc: (context, Map<String, dynamic> params) => CihazDetaylari(
      servisNo: (params["servisNo"].first as String?) ?? "0",
    ),
  );

  static void git(BuildContext context, String yol,
      {bool clearStack = false,
      bool replace = false,
      TransitionType transition = TransitionType.fadeIn,
      t}) {
    router.navigateTo(
      context,
      yol,
      clearStack: clearStack,
      replace: replace,
      transition: transition,
    );
  }
}
