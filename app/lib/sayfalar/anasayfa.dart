import 'package:flutter/material.dart';

import '../models/kullanici.dart';
import '../utils/alerts.dart';
import '../utils/post.dart';
import 'cihazlar.dart';

class Anasayfa extends StatefulWidget {
  const Anasayfa({
    super.key,
    required this.kullanici,
  });

  final KullaniciModel kullanici;

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
    return CihazlarSayfasi(
      kullanici: widget.kullanici,
      seciliSayfa: "Anasayfa",
    );
  }
}
