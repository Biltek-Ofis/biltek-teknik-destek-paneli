import 'package:flutter/material.dart';

import '../models/kullanici.dart';
import '../widgets/scaffold.dart';
import 'cihazlar.dart';

class CihazlarimSayfasi extends StatefulWidget {
  const CihazlarimSayfasi({super.key, required this.kullanici});

  final KullaniciModel kullanici;

  @override
  State<CihazlarimSayfasi> createState() => _CihazlarimSayfasiState();
}

class _CihazlarimSayfasiState extends State<CihazlarimSayfasi> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      drawer: biltekDrawer(
        context,
        kullanici: widget.kullanici,
        seciliSayfa: "Cihazlarım",
      ),
      appBar: biltekAppBar(
        context,
        title: widget.kullanici.adSoyad,
      ),
      body: CihazlarSayfasi(
        sorumlu: widget.kullanici.id,
      ),
    );
  }
}
