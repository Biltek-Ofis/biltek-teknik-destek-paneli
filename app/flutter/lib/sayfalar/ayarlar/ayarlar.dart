import 'package:biltekteknikservis/sayfalar/ayarlar/barkod_okuyucu.dart';
import 'package:biltekteknikservis/widgets/kis_modu.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../../utils/my_notifier.dart';
import '../../utils/shared_preferences.dart';
import '../../widgets/selector.dart';

class AyarlarSayfasi extends StatefulWidget {
  const AyarlarSayfasi({super.key});

  @override
  State<AyarlarSayfasi> createState() => _AyarlarSayfasiState();
}

class _AyarlarSayfasiState extends State<AyarlarSayfasi> {
  String? ip;
  int? port;

  @override
  void initState() {
    super.initState();
    Future.delayed(Duration.zero, () async {
      String? ipTemp =
          await SharedPreference.getString(SharedPreference.barkodIP);
      int? portTemp =
          await SharedPreference.getInt(SharedPreference.barkodPort);
      if (mounted) {
        setState(() {
          ip = ipTemp;
          port = portTemp;
        });
      } else {
        ip = ipTemp;
        port = portTemp;
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Ayarlar"),
      ),
      body: Consumer<MyNotifier>(
        builder: (context, MyNotifier myNotifier, child) {
          return SizedBox(
            width: MediaQuery.of(context).size.width,
            child: KisModu(
              child: ListView(
                children: [
                  ListTile(
                    title: Text("Barkod Okuyucu Ayarları"),
                    subtitle: (ip != null && port != null)
                        ? (ip!.isNotEmpty ? Text("$ip:$port") : null)
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
                                  String? ipTemp =
                                      await SharedPreference.getString(
                                          SharedPreference.barkodIP);
                                  int? portTemp = await SharedPreference.getInt(
                                      SharedPreference.barkodPort);
                                  setState(() {
                                    ip = ipTemp;
                                    port = portTemp;
                                  });
                                },
                              );
                            },
                          ),
                        ),
                      );
                    },
                  ),
                  ListTile(
                    title: Text("Tema"),
                    subtitleTextStyle: TextStyle(
                        color: Theme.of(context)
                            .textTheme
                            .bodySmall
                            ?.color
                            ?.withAlpha(200)),
                    subtitle: Container(
                      padding: EdgeInsets.only(left: 5),
                      child: myNotifier.isDark == null
                          ? Text("Sistem Varsayılanı")
                          : (myNotifier.isDark == true
                              ? Text("Karanlık")
                              : Text("Aydınlık")),
                    ),
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
                  )
                ],
              ),
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
  }) {
    if (durum) {
      kaydedildi?.call();
      if (context.mounted) {
        showDialog(
          context: context,
          builder: (context) {
            return AlertDialog(
              title: Text(elle ? "Başarılı" : "Eşleştirme"),
              content: Text(elle
                  ? "Ayarlarınız başarıyla kaydedildi"
                  : "Windows uygulamasında yeşil onay resmi görüyorsanız işlem başarılı demektir."),
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
                "QR Kod Geçersiz! Lütfen tekrar deneyin veya el ile girin"),
            actions: [
              TextButton(
                onPressed: () {
                  Navigator.pop(context2);
                  Navigator.push(
                    context,
                    MaterialPageRoute(
                      builder: (context) => BarkodOkuyucuAyarlari(
                        onBOKaydet: (durum, elle) {
                          barkodOkuyucuAyarlariDurumu(
                            durum,
                            elle,
                            kaydedildi: kaydedildi,
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
}
