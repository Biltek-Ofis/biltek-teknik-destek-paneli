import 'package:biltekteknikservis/sayfalar/cagri_kayitlari/cagri_kayitlari.dart';
import 'package:flutter/material.dart';

import '../models/kullanici.dart';
import '../utils/alerts.dart';
import '../utils/post.dart';
import 'cihazlar.dart';
import 'cihazlarim.dart';

class Anasayfa extends StatefulWidget {
  const Anasayfa({super.key, required this.kullanici});

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
    return widget.kullanici.musteri
        ? CagriKayitlariSayfasi(kullanici: widget.kullanici)
        : (widget.kullanici.teknikservis
            ? CihazlarimSayfasi(kullanici: widget.kullanici)
            : CihazlarSayfasi(
              kullanici: widget.kullanici,
              seciliSayfa: "Anasayfa",
            ));
  }
}
