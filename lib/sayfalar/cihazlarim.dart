import 'package:flutter/material.dart';

import '../ozellikler/veriler.dart';
import '../widget/liste.dart';
import '../widget/menuler.dart';
import 'sayfa.dart';
import 'statefulwidget.dart';

class Cihazlarim extends VarsayilanStatefulWidget {
  const Cihazlarim({super.key});

  @override
  State<Cihazlarim> createState() => _CihazlarimState();
}

class _CihazlarimState extends VarsayilanStatefulWidgetState<Cihazlarim> {
  final ScrollController scrollController = ScrollController();

  bool yukariGit = false;

  @override
  void dispose() {
    super.dispose();
    scrollController.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Sayfa(
      menu: const AnaMenu(
        seciliSayfa: "Cihazlarım",
      ),
      floatingActionButton: yukariGit
          ? FloatingActionButton(
              child: const Icon(Icons.arrow_upward),
              onPressed: () {
                scrollController.animateTo(
                  0.0,
                  curve: Curves.easeOut,
                  duration: const Duration(milliseconds: 300),
                );
              })
          : null,
      baslik: "Cihazlarım",
      icerik: CihazListesi(
        controller: scrollController,
        yukariGitButonDurumu: (durum) {
          setState(() {
            yukariGit = durum;
          });
        },
        kullaniciID: Veriler.kullaniciBilgileri.id,
      ),
    );
  }
}
