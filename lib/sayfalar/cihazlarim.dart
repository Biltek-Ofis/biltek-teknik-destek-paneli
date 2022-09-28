import 'package:flutter/material.dart';

import '../widget/menuler.dart';
import 'sayfa.dart';
import 'statefulwidget.dart';

class Cihazlarim extends VarsayilanStatefulWidget {
  const Cihazlarim({super.key});

  @override
  State<Cihazlarim> createState() => _CihazlarimState();
}

class _CihazlarimState extends VarsayilanStatefulWidgetState<Cihazlarim> {
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
