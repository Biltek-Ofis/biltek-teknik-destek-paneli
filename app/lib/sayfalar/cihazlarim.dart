import 'package:flutter/material.dart';

import '../models/kullanici.dart';
import 'cihazlar.dart';

class CihazlarimSayfasi extends StatelessWidget {
  const CihazlarimSayfasi({
    super.key,
    required this.kullanici,
  });

  final KullaniciModel kullanici;
  @override
  Widget build(BuildContext context) {
    return CihazlarSayfasi(
      kullanici: kullanici,
      seciliSayfa: "Cihazlarım",
      sorumlu: kullanici.id,
    );
  }
}
