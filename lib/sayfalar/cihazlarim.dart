import 'package:flutter/material.dart';

import '../widget/menuler.dart';
import 'sayfa.dart';

class Cihazlarim extends StatefulWidget {
  const Cihazlarim({super.key});

  @override
  State<Cihazlarim> createState() => _CihazlarimState();
}

class _CihazlarimState extends State<Cihazlarim> {
  @override
  Widget build(BuildContext context) {
    return const Sayfa(
      menu: AnaMenu(
        seciliSayfa: "Cihazlarım",
      ),
      baslik: "Cihazlarım",
      icerik: Center(
        child: Text("Cihazlarım"),
      ),
    );
  }
}
