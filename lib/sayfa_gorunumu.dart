import 'package:biltekbilgisayar/login.dart';
import 'package:biltekbilgisayar/utils/datas.dart';
import 'package:biltekbilgisayar/utils/sp.dart';
import 'package:flutter/material.dart';

import 'widgets/menus.dart';

class SayfaGorunumu extends StatelessWidget {
  const SayfaGorunumu({
    super.key,
    required this.menu,
    required this.icerik,
    this.gerekliGenislik = 900,
    this.menuGenisligi = 240,
    this.baslik = "",
  });

  final AnaMenu menu;
  final Widget icerik;
  final double gerekliGenislik;
  final double menuGenisligi;
  final String baslik;

  @override
  Widget build(BuildContext context) {
    final genislik = MediaQuery.of(context).size.width;
    return Scaffold(
      appBar: AppBar(
        title: Text(
          "${Datas.kullaniciBilgileri.adSoyad} (@${Datas.kullaniciBilgileri.kullaniciAdi})",
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
      body: genislik >= gerekliGenislik
          ? Row(
              children: [
                SizedBox(
                  width: menuGenisligi,
                  child: menu,
                ),
                Container(width: 0.5, color: Colors.black),
                Expanded(
                  child: icerik,
                ),
              ],
            )
          : icerik,
      drawer: genislik >= gerekliGenislik
          ? null
          : SizedBox(
              width: menuGenisligi,
              child: Drawer(
                child: menu,
              ),
            ),
    );
  }
}
