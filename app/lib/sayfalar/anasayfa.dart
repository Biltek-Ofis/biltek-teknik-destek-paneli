import 'package:flutter/material.dart';

import '../models/kullanici.dart';
import '../utils/shared_preferences.dart';
import 'giris_sayfasi.dart';

class Anasayfa extends StatefulWidget {
  const Anasayfa({super.key, required this.kullanici});

  final KullaniciModel kullanici;

  @override
  State<Anasayfa> createState() => _AnasayfaState();
}

class _AnasayfaState extends State<Anasayfa> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SizedBox(
        width: MediaQuery.of(context).size.width,
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          mainAxisSize: MainAxisSize.max,
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            Text("Kullanıcı Adı: ${widget.kullanici.kullaniciAdi}"),
            Text("Ad Soyad: ${widget.kullanici.adSoyad}"),
            Text("Ürün Düzenleme: ${widget.kullanici.urunduzenleme}"),
            Text("Teknik Servis: ${widget.kullanici.teknikservis}"),
            Text("Yönetici: ${widget.kullanici.yonetici}"),
            Text("Auth: ${widget.kullanici.auth}"),
            TextButton(
              onPressed: () async {
                NavigatorState navigatorState = Navigator.of(context);
                await SharedPreference.remove(SharedPreference.authString);
                navigatorState.pushAndRemoveUntil(
                  MaterialPageRoute(
                    builder: (context) => GirisSayfasi(),
                  ),
                  (route) => false,
                );
              },
              child: Text("Çıkış Yap"),
            ),
          ],
        ),
      ),
    );
  }
}
