import 'package:flutter/material.dart';
import 'package:teknikservis/sayfalar/anasayfa.dart';
import 'package:teknikservis/sayfalar/cihazlarim.dart';

import '../models/kullanici.dart';
import '../sayfalar/ayarlar.dart';
import '../sayfalar/giris_sayfasi.dart';
import '../utils/assets.dart';
import '../utils/shared_preferences.dart';

Drawer biltekDrawer(
  BuildContext context, {
  required KullaniciModel kullanici,
  String seciliSayfa = "",
}) {
  return Drawer(
    child: ListView(
      padding: EdgeInsets.zero,
      children: [
        DrawerHeader(
          decoration: BoxDecoration(
            color: Colors.white,
          ),
          child: Image.asset(BiltekAssets.logo),
        ),
        ListTile(
          title: const Text("Anasayfa"),
          selected: seciliSayfa == "Anasayfa",
          onTap: () {
            Navigator.pop(context);
            Navigator.of(context).pushAndRemoveUntil(
              MaterialPageRoute(
                builder: (context) => Anasayfa(
                  kullanici: kullanici,
                ),
              ),
              (route) => false,
            );
          },
        ),
        ListTile(
          title: const Text("Cihazlarım"),
          selected: seciliSayfa == "Cihazlarım",
          onTap: () {
            Navigator.pop(context);
            Navigator.of(context).pushAndRemoveUntil(
              MaterialPageRoute(
                builder: (context) => CihazlarimSayfasi(
                  kullanici: kullanici,
                ),
              ),
              (route) => false,
            );
          },
        ),
      ],
    ),
  );
}

AppBar biltekAppBar(
  BuildContext context, {
  String title = "",
}) {
  return AppBar(
    leading: Builder(
      builder: (context) {
        return IconButton(
          icon: const Icon(Icons.menu),
          onPressed: () {
            Scaffold.of(context).openDrawer();
          },
        );
      },
    ),
    title: Text(title),
    actions: [
      IconButton(
        onPressed: () async {
          NavigatorState navigatorState = Navigator.of(context);
          await SharedPreference.remove(SharedPreference.authString);
          navigatorState.push(
            MaterialPageRoute(
              builder: (context) => AyarlarSayfasi(),
            ),
          );
        },
        icon: Icon(Icons.settings),
      ),
      IconButton(
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
        icon: Icon(Icons.logout),
      ),
    ],
  );
}
