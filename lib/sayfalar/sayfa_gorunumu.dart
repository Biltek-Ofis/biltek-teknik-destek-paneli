import 'package:biltekbilgisayar/sayfalar/giris.dart';
import 'package:biltekbilgisayar/ozellikler/veriler.dart';
import 'package:biltekbilgisayar/ozellikler/sp.dart';
import 'package:flutter/material.dart';

import '../widget/menuler.dart';

class SayfaGorunumu extends StatefulWidget {
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
  State<SayfaGorunumu> createState() => _SayfaGorunumuState();
}

class _SayfaGorunumuState extends State<SayfaGorunumu> {
  double varsayilanMenuGenisligi = 0;
  double menuGenisligi = 0;
  @override
  void initState() {
    Future.delayed(Duration.zero, () {
      setState(() {
        menuGenisligi = varsayilanMenuGenisligi = widget.menuGenisligi;
      });
    });
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    final genislik = MediaQuery.of(context).size.width;
    return Scaffold(
      appBar: AppBar(
        leading: genislik >= widget.gerekliGenislik
            ? IconButton(
                onPressed: () {
                  setState(() {
                    menuGenisligi =
                        menuGenisligi == 0 ? varsayilanMenuGenisligi : 0;
                  });
                },
                icon: const Icon(Icons.menu))
            : null,
        title: Text(
          "${Veriler.kullaniciBilgileri.adSoyad} (@${Veriler.kullaniciBilgileri.kullaniciAdi})",
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
      body: genislik >= widget.gerekliGenislik
          ? Row(
              children: [
                SizedBox(
                  width: menuGenisligi,
                  child: widget.menu,
                ),
                Container(width: 0.5, color: Colors.black),
                SingleChildScrollView(
                  child: SizedBox(
                    width:
                        MediaQuery.of(context).size.width - menuGenisligi - 0.5,
                    child: widget.icerik,
                  ),
                ),
              ],
            )
          : SingleChildScrollView(
              child: SizedBox(
                width: MediaQuery.of(context).size.width,
                child: widget.icerik,
              ),
            ),
      drawer: genislik >= widget.gerekliGenislik
          ? null
          : SizedBox(
              width: menuGenisligi,
              child: Drawer(
                child: widget.menu,
              ),
            ),
    );
  }
}
