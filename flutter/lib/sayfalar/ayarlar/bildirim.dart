import 'package:biltekteknikservis/models/bildirim.dart';
import 'package:biltekteknikservis/models/cihaz_duzenleme/cihaz_turleri.dart';
import 'package:biltekteknikservis/models/kullanici.dart';
import 'package:biltekteknikservis/utils/post.dart';
import 'package:biltekteknikservis/widgets/list.dart';
import 'package:biltekteknikservis/widgets/overlay_notification.dart';
import 'package:flutter/material.dart';

import '../../widgets/selector.dart';

class BildirimAyarlari extends StatefulWidget {
  const BildirimAyarlari({super.key, required this.kullanici});

  final KullaniciAuthModel kullanici;

  @override
  State<BildirimAyarlari> createState() => _BildirimAyarlariState();
}

class _BildirimAyarlariState extends State<BildirimAyarlari> {
  bool yuklendi = false;
  List<BildirimModel> bildirimler = [];
  List<CihazTurleriModel> cihazTurleri = [];
  @override
  void initState() {
    super.initState();
    Future.delayed(Duration.zero, () async {
      await bildirimleriGetir();
      await cihazTurleriniGetir();
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("Bildirim Ayarları")),
      body: SizedBox(
        width: MediaQuery.of(context).size.width,
        child: ListView(
          children: [
            BiltekListTile(
              title: "Cihaz Bildirimleri",
              subtitle:
                  "Sorumlu personel olarak seçildiğiniz cihazlarla ilgili bildirimler.",
              trailing: Text(
                yuklendi
                    ? (bildirimBul("cihaz", varsayilan: true).durum
                        ? "Açık"
                        : "Kapalı")
                    : "",
              ),
              onTap: () {
                showSelector<bool>(
                  context,
                  items: [
                    SelectorItem(text: "Açık", value: true),
                    SelectorItem(text: "Kapalı", value: false),
                  ],
                  currentValue: bildirimBul("cihaz", varsayilan: true).durum,
                  onSelect: (value) async {
                    NavigatorState navigatorState = Navigator.of(context);
                    ScaffoldMessengerState scaffoldMessengerState =
                        ScaffoldMessenger.of(context);
                    bool durum = await BiltekPost.bildirimAyarla(
                      widget.kullanici.id,
                      "cihaz",
                      !bildirimBul("cihaz", varsayilan: true).durum,
                    );
                    if (durum) {
                      navigatorState.pop();
                      bildirimleriGetir();
                    } else {
                      navigatorState.pop();
                      toast(
                        "Bildirim ayarı güncellenemedi. Daha sonra tekrar deneyin",
                        scaffoldMessenger: scaffoldMessengerState,
                      );
                    }
                  },
                );
              },
            ),
            BiltekListTile(
              title: "Çağrı Kaydı Bildirimleri",
              subtitle:
                  "Müşteriler çağrı kaydı açtığında alınacak bildirimleri düzenleyin",
              onTap: () {
                showCheckSelector(
                  context,
                  items:
                      cihazTurleri.map((ct) {
                        return SelectorItem(
                          key: "${BildirimModel.cagriKey}-${ct.id}",
                          text: ct.isim,
                          value:
                              bildirimBul(
                                "${BildirimModel.cagriKey}-${ct.id}",
                                varsayilan: false,
                              ).durum,
                        );
                      }).toList(),
                  onSaveItems: (items) async {
                    ScaffoldMessengerState scaffoldMessengerState =
                        ScaffoldMessenger.of(context);
                    List<BildirimModel> bildirimlerTemp = [];
                    for (var i = 0; i < items.length; i++) {
                      bildirimlerTemp.add(
                        BildirimModel.create(
                          tur: items[i].key!,
                          durum: items[i].value,
                        ),
                      );
                    }
                    bool sonuc = await BiltekPost.bildirimAyarlaToplu(
                      widget.kullanici.id,
                      bildirimlerTemp,
                    );
                    if (sonuc) {
                      await bildirimleriGetir();
                    } else {
                      toast(
                        "Bildirim ayarları güncellenemedi. Daha sonra tekrar deneyin.",
                        scaffoldMessenger: scaffoldMessengerState,
                      );
                    }
                  },
                );
              },
            ),
          ],
        ),
      ),
    );
  }

  Future<void> bildirimleriGetir() async {
    var bildirimlerTemp = await BiltekPost.bildirimleriGetir(
      widget.kullanici.id,
    );
    setState(() {
      bildirimler = bildirimlerTemp;
      yuklendi = true;
    });
  }

  BildirimModel bildirimBul(String tur, {bool varsayilan = false}) {
    return bildirimler.firstWhere(
      (b) => b.tur == tur,
      orElse: () => BildirimModel.create(tur: tur, durum: varsayilan),
    );
  }

  Future<void> cihazTurleriniGetir() async {
    List<CihazTurleriModel> cihazTurleriTemp = await BiltekPost.cihazTurleri();
    setState(() {
      cihazTurleri = cihazTurleriTemp;
    });
  }
}
