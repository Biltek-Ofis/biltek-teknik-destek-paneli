import 'dart:async';

import 'package:biltekteknikservis/main.dart';
import 'package:biltekteknikservis/sayfalar/cagri_kayitlari/cagri_kayitlari.dart';
import 'package:flutter/material.dart';

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
  @override
  void initState() {
    super.initState();

    Future.delayed(Duration.zero, () async {
      if (mounted) {
        String tip = bildirimIntent["tip"] ?? "standart";
        String id = bildirimIntent["id"] ?? "0";
        NativeNotification.init((tip, id) {
          bildirimIntent.addAll({"tip": tip, "id": id});
          debugPrint("Bildirim tıklandı");
          bildirimTiklamaYonlendir(tip: tip, id: id);
        });
        bildirimTiklamaYonlendir(tip: tip, id: id);

        Alerts alerts = Alerts.of(context);
        bool guncelleme = await BiltekPost.guncellemeGerekli();
        if (guncelleme) {
          alerts.guncelleme();
        }
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    Widget? sayfa;
    String tip = bildirimIntent["tip"] ?? "standart";
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
                    servisNo: idInt,
                    cihazlariYenile: () async {},
                  ),
            ),
          );
        }
      case "cagri":
        if (id.isNotEmpty && id != "0") {
          navigatorState.push(
            MaterialPageRoute(
              builder:
                  (context) => CagriKaydiDetaySayfasi(
                    kullanici: widget.kullanici,
                    id: id,
                  ),
            ),
          );
        }
    }
  }
}
