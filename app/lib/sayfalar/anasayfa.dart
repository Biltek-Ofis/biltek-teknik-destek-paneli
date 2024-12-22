import 'package:flutter/material.dart';
import 'package:teknikservis/sayfalar/cihazlar.dart';

import '../models/kullanici.dart';

class Anasayfa extends StatelessWidget {
  const Anasayfa({
    super.key,
    required this.kullanici,
  });
  final KullaniciModel kullanici;
  @override
  Widget build(BuildContext context) {
    return CihazlarSayfasi(
      kullanici: kullanici,
      seciliSayfa: "Anasayfa",
    );
  }
}
