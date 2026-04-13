import 'dart:async';

import 'package:app_links/app_links.dart';
import 'package:biltekteknikservis/sayfalar/cagri_kayitlari/cagri_kayitlari.dart';
import 'package:biltekteknikservis/sayfalar/notlar/notlar.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';

import '../models/kullanici.dart';
import '../utils/alerts.dart';
import '../utils/notification.dart';
import '../utils/post.dart';
import 'cagri_kayitlari/cagri_kaydi_detay.dart';
import 'cihazlar.dart';
import 'cihazlarim.dart';
import 'detaylar/detaylar.dart';

class Anasayfa extends StatefulWidget {
  const Anasayfa({super.key, required this.sayfa, required this.kullanici});

  final String sayfa;
  final KullaniciAuthModel kullanici;

  @override
  State<Anasayfa> createState() => _AnasayfaState();
}

class _AnasayfaState extends State<Anasayfa> {
  String tip = "standart";
  CihazNo? cihazNoCls;
  StreamSubscription? _deepLinkSubscription;

  @override
  void initState() {
    super.initState();

    Future.delayed(Duration.zero, () async {
      if (mounted) {
        cihazNoCls = CihazNo.of(context);
        NativeNotification.init((tip, id) {
          debugPrint("Bildirim tıklandı");
          bildirimTiklamaYonlendir(tip: tip, id: id);
        });

        Alerts alerts = Alerts.of(context);
        bool guncelleme = await BiltekPost.guncellemeGerekli();
        if (guncelleme) {
          alerts.guncelleme();
        }
        await initUniLinks();
      }
    });
  }

  @override
  void dispose() {
    _deepLinkSubscription?.cancel();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    Widget? sayfa;
    String tip = this.tip;
    switch (tip) {
      case "cihaz":
        sayfa = CihazlarimSayfasi(kullanici: widget.kullanici);
        break;
      case "cagri":
        sayfa = CagriKayitlariSayfasi(kullanici: widget.kullanici);
        break;
      default:
        switch (widget.sayfa) {
          case "cagri":
            sayfa = CagriKayitlariSayfasi(kullanici: widget.kullanici);
            break;
          case "cihazlarim":
            sayfa = CihazlarimSayfasi(kullanici: widget.kullanici);
            break;
          case "notlar":
            sayfa = NotlarSayfasi(kullanici: widget.kullanici);
            break;
          default:
            sayfa = CihazlarSayfasi(
              kullanici: widget.kullanici,
              seciliSayfa: "Anasayfa",
            );
            break;
        }
    }
    return sayfa;
  }

  void bildirimTiklamaYonlendir({required String tip, required String id}) {
    setState(() {
      this.tip = tip;
    });
    NavigatorState navigatorState = Navigator.of(context);
    switch (tip) {
      case "cihaz":
        int idInt = int.tryParse(id) ?? 0;
        if (idInt > 0) {
          navigatorState.push(
            MaterialPageRoute(
              builder:
                  (context) => DetaylarSayfasi(
                    kullanici: widget.kullanici,
                    no: idInt,
                    cihazlariYenile: () async {},
                  ),
            ),
          );
        }
        break;
      case "cagri":
        if (id.isNotEmpty) {
          int idInt = int.tryParse(id) ?? 0;
          if (idInt > 0) {
            navigatorState.push(
              MaterialPageRoute(
                builder:
                    (context) => CagriKaydiDetaySayfasi(
                      kullanici: widget.kullanici,
                      id: idInt,
                    ),
              ),
            );
          }
        }
        break;
      case "not":
        navigatorState.push(
          MaterialPageRoute(
            builder:
                (context) =>
                    Anasayfa(sayfa: "notlar", kullanici: widget.kullanici),
          ),
        );
        break;
    }
  }

  Future<void> initUniLinks() async {
    // Platform messages may fail, so we use a try/catch PlatformException.
    try {
      final appLinks = AppLinks(); // AppLinks is singleton

      // Subscribe to all events (initial link and further)
      _deepLinkSubscription = appLinks.uriLinkStream.listen((uri) {
        if (cihazNoCls != null) {
          cihazNoCls!.qrAc(
            qr: uri.toString(),
            kullanici: widget.kullanici,
            cihazlariYenile: () async {},
          );
        }
      });
    } on PlatformException catch (e) {
      debugPrint("Failed to get initial link.\n$e");
    }
  }
}
