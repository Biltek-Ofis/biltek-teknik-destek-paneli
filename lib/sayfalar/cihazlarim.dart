import 'package:flutter/material.dart';

import '../env.dart';
import 'sayfa_gorunumu.dart';
import '../widget/menuler.dart';

class Cihazlarim extends StatefulWidget {
  const Cihazlarim({super.key});

  @override
  State<Cihazlarim> createState() => _CihazlarimState();
}

class _CihazlarimState extends State<Cihazlarim> {
  @override
  Widget build(BuildContext context) {
    return SayfaGorunumu(
      menu: const AnaMenu(
        seciliSayfa: "Cihazlarım",
      ),
      baslik: Env.uygulamaAdi,
      icerik: const Center(
        child: Text("Cihazlarım"),
      ),
    );
  }
}
