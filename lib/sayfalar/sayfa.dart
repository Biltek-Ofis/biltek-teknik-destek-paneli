import 'package:flutter/material.dart';

import '../ozellikler/sp.dart';
import '../widget/menuler.dart';
import 'giris.dart';

class Sayfa extends StatelessWidget {
  const Sayfa({
    super.key,
    required this.menu,
    required this.icerik,
    this.menuGenisligi = 240,
    this.baslik = "",
    this.floatingActionButton,
  });

  final AnaMenu menu;
  final Widget icerik;
  final double menuGenisligi;
  final String baslik;
  final Widget? floatingActionButton;
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text(
          baslik,
        ),
        actions: [
          IconButton(
            onPressed: () {
              SharedPref.girisDurumuSil().then((value) {
                if (value) {
                  Navigator.pushAndRemoveUntil(
                    context,
                    MaterialPageRoute(
                      builder: (context) => const GirisYap(),
                    ),
                    (route) => false,
                  );
                }
              });
            },
            icon: const Icon(Icons.logout),
          ),
        ],
      ),
      floatingActionButton: floatingActionButton,
      body: icerik,
      drawer: SizedBox(
        width: menuGenisligi,
        child: Drawer(
          child: menu,
        ),
      ),
    );
  }
}
