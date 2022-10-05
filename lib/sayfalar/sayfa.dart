import 'package:flutter/material.dart';

import '../ozellikler/yonlendirme.dart';
import '../ozellikler/sp.dart';
import '../widget/menuler.dart';
import 'giris.dart';

class Sayfa extends StatefulWidget {
  const Sayfa({
    super.key,
    this.menu,
    this.direktGiris = true,
    required this.icerik,
    this.menuGenisligi = 240,
    this.baslik = "",
    this.floatingActionButton,
  });

  final AnaMenu? menu;
  final bool direktGiris;
  final Widget icerik;
  final double menuGenisligi;
  final String baslik;
  final Widget? floatingActionButton;

  @override
  State<Sayfa> createState() => _SayfaState();
}

class _SayfaState extends State<Sayfa> {
  bool kullaniciKontrolEdildi = false;

  @override
  void initState() {
    super.initState();
    SharedPref.girisDurumu().then((value) {
      if (value) {
        setState(() {
          kullaniciKontrolEdildi = true;
        });
      } else {
        Yonlendirme.git(
          context,
          GirisYap.yol,
          clearStack: true,
          routeGoster: false,
        );
      }
    });
  }

  bool buildKontrol() {
    return widget.direktGiris ? kullaniciKontrolEdildi : true;
  }

  @override
  Widget build(BuildContext context) {
    Widget sayfaWidget = Scaffold(
      appBar: AppBar(
        title: Text(
          widget.baslik,
        ),
        actions: [
          IconButton(
            onPressed: () {
              SharedPref.girisDurumuSil().then((value) {
                if (value) {
                  Yonlendirme.git(
                    context,
                    GirisYap.yol,
                    clearStack: true,
                    routeGoster: false,
                  );
                }
              });
            },
            icon: const Icon(Icons.logout),
          ),
        ],
      ),
      floatingActionButton: widget.floatingActionButton,
      body: widget.icerik,
      drawer: widget.menu == null
          ? null
          : SizedBox(
              width: widget.menuGenisligi,
              child: Drawer(
                child: widget.menu,
              ),
            ),
    );
    return widget.direktGiris
        ? kullaniciKontrolEdildi
            ? sayfaWidget
            : const Scaffold(
                body: Center(
                  child: CircularProgressIndicator(),
                ),
              )
        : sayfaWidget;
  }
}
