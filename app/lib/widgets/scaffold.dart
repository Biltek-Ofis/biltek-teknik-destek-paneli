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
          onTap: seciliSayfa != "Anasayfa"
              ? () {
                  Navigator.pop(context);
                  Navigator.of(context).pushAndRemoveUntil(
                    MaterialPageRoute(
                      builder: (context) => Anasayfa(
                        kullanici: kullanici,
                      ),
                    ),
                    (route) => false,
                  );
                }
              : null,
        ),
        if (kullanici.teknikservis)
          ListTile(
            title: const Text("Cihazlarım"),
            selected: seciliSayfa == "Cihazlarım",
            onTap: seciliSayfa != "Cihazlarım"
                ? () {
                    Navigator.pop(context);
                    Navigator.of(context).pushAndRemoveUntil(
                      MaterialPageRoute(
                        builder: (context) => CihazlarimSayfasi(
                          kullanici: kullanici,
                        ),
                      ),
                      (route) => false,
                    );
                  }
                : null,
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
      PopupMenuButton<String>(
        onSelected: (value) async {
          NavigatorState navigatorState = Navigator.of(context);
          switch (value) {
            case "Ayarlar":
              navigatorState.push(
                MaterialPageRoute(
                  builder: (context) => AyarlarSayfasi(),
                ),
              );
              break;
            case "Çıkış Yap":
              await SharedPreference.remove(SharedPreference.authString);
              navigatorState.pushAndRemoveUntil(
                MaterialPageRoute(
                  builder: (context) => GirisSayfasi(),
                ),
                (route) => false,
              );
              break;
          }
        },
        itemBuilder: (context) {
          return [
            PopupMenuItem<String>(
              value: "Ayarlar",
              child: ListTile(
                leading: Icon(Icons.settings),
                title: Text("Ayarlar"),
              ),
            ),
            PopupMenuItem<String>(
              value: "Çıkış Yap",
              child: ListTile(
                leading: Icon(Icons.logout),
                title: Text("Çıkış Yap"),
              ),
            ),
          ];
        },
      ),
    ],
  );
}
