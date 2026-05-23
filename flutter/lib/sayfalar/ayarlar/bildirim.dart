import 'package:flutter/material.dart';

import '../../models/bildirim.dart';
import '../../models/cihaz_duzenleme/cihaz_turleri.dart';
import '../../models/kullanici.dart';
import '../../utils/post.dart';
import '../../widgets/list.dart';
import '../../widgets/overlay_notification.dart';
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
    Future.delayed(Duration.zero, () async {
      await bildirimleriGetir();
      await cihazTurleriniGetir();
    });
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("Bildirim Ayarları")),
      resizeToAvoidBottomInset: false,
      body: SafeArea(
        child: SizedBox(
          width: MediaQuery.of(context).size.width,
          child: ListView(
            children: [
              if (!widget.kullanici.musteri)
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
                      currentValue:
                          bildirimBul("cihaz", varsayilan: true).durum,
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
              if (!widget.kullanici.musteri)
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
              if (widget.kullanici.musteri)
                BiltekListTile(
                  title: "Çağrı Kaydı Bildirimleri",
                  subtitle: "Hesabınıza çağrı kaydı açıldığında bildirim alın",
                  onTap: () {
                    showSelector<bool>(
                      context,
                      items: [
                        SelectorItem(text: "Açık", value: true),
                        SelectorItem(text: "Kapalı", value: false),
                      ],
                      currentValue:
                          bildirimBul(
                            "cagri_kaydi_musteri",
                            varsayilan: true,
                          ).durum,
                      onSelect: (value) async {
                        NavigatorState navigatorState = Navigator.of(context);
                        ScaffoldMessengerState scaffoldMessengerState =
                            ScaffoldMessenger.of(context);
                        bool durum = await BiltekPost.bildirimAyarla(
                          widget.kullanici.id,
                          "cagri_kaydi_musteri",
                          !bildirimBul(
                            "cagri_kaydi_musteri",
                            varsayilan: true,
                          ).durum,
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
              if (widget.kullanici.musteri)
                BiltekListTile(
                  title: "Servis Kaydı Bildirimleri",
                  subtitle:
                      "Çağrı kaydınıza bir servis kaydı açıldığında ve bu servis kaydı güncellendiğinde bildirim alın",
                  onTap: () {
                    showSelector<bool>(
                      context,
                      items: [
                        SelectorItem(text: "Açık", value: true),
                        SelectorItem(text: "Kapalı", value: false),
                      ],
                      currentValue:
                          bildirimBul(
                            "servis_kaydi_musteri",
                            varsayilan: true,
                          ).durum,
                      onSelect: (value) async {
                        NavigatorState navigatorState = Navigator.of(context);
                        ScaffoldMessengerState scaffoldMessengerState =
                            ScaffoldMessenger.of(context);
                        bool durum = await BiltekPost.bildirimAyarla(
                          widget.kullanici.id,
                          "servis_kaydi_musteri",
                          !bildirimBul(
                            "servis_kaydi_musteri",
                            varsayilan: true,
                          ).durum,
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
            ],
          ),
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
