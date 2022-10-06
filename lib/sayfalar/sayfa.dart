import 'package:flutter/material.dart';

import '../ozellikler/yonlendirme.dart';
import '../ozellikler/sp.dart';
import '../widget/menuler.dart';
import 'giris.dart';
import 'yeni_cihaz_girisi.dart';

class Sayfa extends StatefulWidget {
  const Sayfa({
    super.key,
    this.menu,
    required this.direktGiris,
    required this.icerik,
    this.yeniCihazEkleButonuGoster = false,
    this.kapatButonuGoster = false,
    this.menuGenisligi = 240,
    this.baslik = "",
    this.floatingActionButton,
  });

  final AnaMenu? menu;
  final bool direktGiris;
  final Widget icerik;
  final bool yeniCihazEkleButonuGoster;
  final bool kapatButonuGoster;
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
    if (widget.direktGiris) {
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
          );
        }
      });
    } else {
      setState(() {
        kullaniciKontrolEdildi = true;
      });
    }
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
          if (widget.yeniCihazEkleButonuGoster)
            ElevatedButton.icon(
              onPressed: () {
                Yonlendirme.git(
                  context,
                  YeniCihazGirisi.yol,
                );
              },
              icon: const Icon(Icons.add_outlined),
              label: Text(
                MediaQuery.of(context).size.width > 400
                    ? "Yeni Cihaz Girişi"
                    : "",
              ),
            ),
          if (!widget.kapatButonuGoster)
            IconButton(
              onPressed: () {
                SharedPref.girisDurumuSil().then((value) {
                  if (value) {
                    Yonlendirme.git(
                      context,
                      GirisYap.yol,
                      clearStack: true,
                    );
                  }
                });
              },
              icon: const Icon(Icons.logout_outlined),
            ),
          if (widget.kapatButonuGoster)
            IconButton(
              onPressed: () {
                Yonlendirme.kapat(context);
              },
              icon: const Icon(
                Icons.close_outlined,
              ),
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
