import 'package:biltekteknikservis/models/kullanici.dart';
import 'package:biltekteknikservis/widgets/list.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../../utils/barkod_okuyucu.dart';
import '../../utils/my_notifier.dart';
import '../../utils/post.dart';
import '../../utils/shared_preferences.dart';
import '../../widgets/selector.dart';
import '../giris_sayfasi.dart';
import 'barkod_okuyucu.dart';
import 'bildirim.dart';

class AyarlarSayfasi extends StatefulWidget {
  const AyarlarSayfasi({
    super.key,
    required this.pcYenile,
    required this.kullanici,
  });

  final VoidCallback pcYenile;
  final KullaniciAuthModel kullanici;
  @override
  State<AyarlarSayfasi> createState() => _AyarlarSayfasiState();
}

class _AyarlarSayfasiState extends State<AyarlarSayfasi> {
  BarkodOkuyucu? barkodOkuyucu;

  @override
  void initState() {
    super.initState();
    Future.delayed(Duration.zero, () async {
      await barkodOkuyucuYenile();
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("Ayarlar")),
      body: Consumer<MyNotifier>(
        builder: (context, MyNotifier myNotifier, child) {
          return SizedBox(
            width: MediaQuery.of(context).size.width,
            child: ListView(
              children: [
                /*ListTile(
                  title: Text("Barkod Okuyucu Ayarları"),
                  subtitle: barkodOkuyucu != null
                      ? Text("${barkodOkuyucu!.ip}:${barkodOkuyucu!.port}")
                      : null,
                  subtitleTextStyle: TextStyle(
                      color: Theme.of(context)
                          .textTheme
                          .bodySmall
                          ?.color
                          ?.withAlpha(200)),
                  onTap: () {
                    Navigator.of(context).push(
                      MaterialPageRoute(
                        builder: (context) => BarkodOkuyucuAyarlari(
                          onBOKaydet: (durum, elle) {
                            barkodOkuyucuAyarlariDurumu(
                              durum,
                              elle,
                              kaydedildi: () async {
                                await barkodOkuyucuYenile();
                              },
                              pcYenile: widget.pcYenile,
                            );
                          },
                        ),
                      ),
                    );
                  },
                ),*/
                BiltekListTile(
                  title: "Tema",
                  subtitle:
                      myNotifier.isDark == null
                          ? "Sistem Varsayılanı"
                          : (myNotifier.isDark == true
                              ? "Karanlık"
                              : "Aydınlık"),
                  onTap: () {
                    showSelector<bool?>(
                      context,
                      items: [
                        SelectorItem(text: "Sistem Varsayılanı", value: null),
                        SelectorItem(text: "Aydınlık", value: false),
                        SelectorItem(text: "Karanlık", value: true),
                      ],
                      currentValue: myNotifier.isDark,
                      onSelect: (value) {
                        myNotifier.isDark = value;
                      },
                    );
                  },
                ),
                if (!widget.kullanici.musteri)
                  BiltekListTile(
                    title: "Bildirimler",
                    subtitle: "Bildirim ayarlarınızı özelleştirin.",
                    onTap: () {
                      Navigator.of(context).push(
                        MaterialPageRoute(
                          builder:
                              (context) =>
                                  BildirimAyarlari(kullanici: widget.kullanici),
                        ),
                      );
                    },
                  ),
                BiltekListTile(
                  leading: Icon(Icons.logout),
                  title: "Çıkış Yap",
                  onTap: () async {
                    NavigatorState navigatorState = Navigator.of(context);
                    await SharedPreference.remove(SharedPreference.authString);
                    String? fcmToken = await SharedPreference.getString(
                      SharedPreference.fcmTokenString,
                    );
                    await BiltekPost.fcmTokenSifirla(fcmToken: fcmToken);
                    navigatorState.pushAndRemoveUntil(
                      MaterialPageRoute(
                        builder:
                            (context) =>
                                GirisSayfasi(kullaniciAdi: myNotifier.username),
                      ),
                      (route) => false,
                    );
                  },
                ),
              ],
            ),
          );
        },
      ),
    );
  }

  void barkodOkuyucuAyarlariDurumu(
    bool durum,
    bool elle, {
    VoidCallback? kaydedildi,
    VoidCallback? pcYenile,
  }) {
    if (durum) {
      kaydedildi?.call();
      pcYenile?.call();
      if (context.mounted) {
        showDialog(
          context: context,
          builder: (context) {
            return AlertDialog(
              title: Text(elle ? "Başarılı" : "Eşleştirme"),
              content: Text(
                elle
                    ? "Ayarlarınız başarıyla kaydedildi"
                    : "Windows uygulamasında yeşil onay resmi görüyorsanız işlem başarılı demektir.",
              ),
              actions: [
                TextButton(
                  onPressed: () {
                    Navigator.of(context).pop();
                  },
                  child: Text("Tamam"),
                ),
              ],
            );
          },
        );
      }
    } else {
      showDialog(
        context: context,
        barrierDismissible: false,
        builder: (context2) {
          return AlertDialog(
            title: Text("Hata"),
            content: Text(
              "QR Kod Geçersiz! Lütfen tekrar deneyin veya el ile girin",
            ),
            actions: [
              TextButton(
                onPressed: () {
                  Navigator.pop(context2);
                  Navigator.push(
                    context,
                    MaterialPageRoute(
                      builder:
                          (context) => BarkodOkuyucuAyarlari(
                            onBOKaydet: (durum, elle) {
                              barkodOkuyucuAyarlariDurumu(
                                durum,
                                elle,
                                kaydedildi: kaydedildi,
                                pcYenile: pcYenile,
                              );
                            },
                          ),
                    ),
                  );
                },
                child: Text("Tamam"),
              ),
            ],
          );
        },
      );
    }
  }

  Future<void> barkodOkuyucuYenile() async {
    BarkodOkuyucu? barkodOkuyucuTemp = await BarkodOkuyucu.getir();
    if (mounted) {
      setState(() {
        barkodOkuyucu = barkodOkuyucuTemp;
      });
    } else {
      barkodOkuyucu = barkodOkuyucuTemp;
    }
  }
}
