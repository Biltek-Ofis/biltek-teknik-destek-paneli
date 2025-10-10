import 'dart:convert';

import 'package:biltekteknikservis/models/cagri_kaydi.dart';
import 'package:biltekteknikservis/models/kullanici.dart';
import 'package:biltekteknikservis/sayfalar/cagri_kayitlari/cagri_kaydi_detay.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';

import '../../models/cihaz.dart';
import '../../utils/alerts.dart';
import '../../utils/buttons.dart';
import '../../utils/islemler.dart';
import '../../utils/post.dart';
import '../../utils/shared_preferences.dart';
import '../../widgets/navigators.dart';
import '../ayarlar/ayarlar.dart';
import '../cihazlar.dart';
import '../detaylar/detaylar.dart';
import '../giris_sayfasi.dart';
import '../yeni_cihaz.dart';

class CagriKayitlariSayfasi extends StatefulWidget {
  const CagriKayitlariSayfasi({super.key, required this.kullanici});

  final KullaniciAuthModel kullanici;
  @override
  State<CagriKayitlariSayfasi> createState() => _CagriKayitlariSayfasiState();
}

class _CagriKayitlariSayfasiState extends State<CagriKayitlariSayfasi> {
  List<CagriKaydiModel>? cagriKayitlari;
  ScrollController scrollController = ScrollController();

  final GlobalKey<ScaffoldState> scaffoldKey = GlobalKey<ScaffoldState>();
  @override
  void initState() {
    Future.delayed(Duration.zero, () async {
      await cagriKayitlariniGetir();
    });
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return PopScope(
      canPop: false,
      onPopInvokedWithResult: (didPop, result) async {
        if (didPop) {
          return;
        }
        bool kapat = true;

        if (kapat) {
          SystemChannels.platform.invokeMethod('SystemNavigator.pop');
          //Navigator.of(context).pop(result);
        }
      },
      child: Scaffold(
        key: scaffoldKey,
        appBar: AppBar(
          title:
              widget.kullanici.musteri
                  ? Text("Biltek Çağrı Kayıtları")
                  : Text("Çağrı Kayıtları"),

          automaticallyImplyLeading: false,
          actions: [
            PopupMenuButton(
              itemBuilder:
                  (context) => [
                    PopupMenuItem(
                      onTap: () {
                        Navigator.of(context).push(
                          MaterialPageRoute(
                            builder:
                                (context) => AyarlarSayfasi(
                                  pcYenile: () {},
                                  kullanici: widget.kullanici,
                                ),
                          ),
                        );
                      },
                      child: Row(
                        children: [
                          Icon(
                            Icons.settings,
                            color: Theme.of(context).textTheme.bodySmall?.color,
                          ),
                          SizedBox(width: 10),
                          const Text("Ayarlar"),
                        ],
                      ),
                    ),
                    PopupMenuItem(
                      onTap: () async {
                        NavigatorState navigatorState = Navigator.of(context);
                        await SharedPreference.remove(
                          SharedPreference.authString,
                        );
                        String? fcmToken = await SharedPreference.getString(
                          SharedPreference.fcmTokenString,
                        );
                        await BiltekPost.fcmTokenSifirla(fcmToken: fcmToken);
                        String? kullaniciString =
                            await SharedPreference.getString(
                              SharedPreference.kullaniciString,
                            );
                        SPKullanici spKullanici =
                            kullaniciString != null
                                ? SPKullanici.fromJson(
                                  jsonDecode(kullaniciString)
                                      as Map<String, dynamic>,
                                )
                                : SPKullanici.create(
                                  isim: "",
                                  kullaniciAdi: "",
                                  sifre: "",
                                  sifrele: false,
                                );
                        navigatorState.pushAndRemoveUntil(
                          MaterialPageRoute(
                            builder:
                                (context) =>
                                    GirisSayfasi(spKullanici: spKullanici),
                          ),
                          (route) => false,
                        );
                      },
                      child: Row(
                        children: [
                          Icon(
                            Icons.logout,
                            color: Theme.of(context).textTheme.bodySmall?.color,
                          ),
                          SizedBox(width: 10),
                          const Text("Çıkış Yap"),
                        ],
                      ),
                    ),
                  ],
            ),
          ],
        ),
        resizeToAvoidBottomInset: false,
        extendBody: true,
        drawer: biltekDrawer(
          context,
          kullanici: widget.kullanici,
          seciliSayfa: "Çağrı Kayıtları",
        ),
        /*
        floatingActionButtonLocation: FloatingActionButtonLocation.centerDocked,
        floatingActionButton: FloatingActionButton(
          shape: CircleBorder(),
          onPressed: () {},
          child: Icon(Icons.add),
        ),*/
        bottomNavigationBar: BiltekBottomNavigationBar(
          items: [
            BottomNavigationBarItem(icon: Icon(Icons.menu), label: "Menü"),
            BottomNavigationBarItem(
              icon: Icon(Icons.settings),
              label: "Ayarlar",
            ),
          ],
          onTap: (index) async {
            debugPrint("Index: $index");
            switch (index) {
              case 0:
                scaffoldKey.currentState?.openDrawer();
                break;
              case 1:
                Navigator.of(context).push(
                  MaterialPageRoute(
                    builder:
                        (context) => AyarlarSayfasi(
                          pcYenile: () {},
                          kullanici: widget.kullanici,
                        ),
                  ),
                );
                break;
            }
          },
        ),
        body:
            cagriKayitlari == null
                ? Center(child: CircularProgressIndicator())
                : RefreshIndicator(
                  onRefresh: () async {
                    await cagriKayitlariniGetir();
                  },
                  child: ListView.builder(
                    itemCount: cagriKayitlari!.length,
                    controller: scrollController,
                    physics: AlwaysScrollableScrollPhysics(),
                    itemBuilder: (context, index) {
                      CagriKaydiModel cagrikaydi = cagriKayitlari![index];
                      Cihaz? cihaz = cagrikaydi.cihazBilgileri;
                      String renk =
                          cihaz != null ? cihaz.guncelDurumRenk : "bg-warning";
                      debugPrint("Guncel Durum Renk $renk");
                      Color? renkTemp = Islemler.yaziRengi(renk);
                      return Container(
                        decoration: BoxDecoration(color: Colors.white),
                        child: Container(
                          decoration: BoxDecoration(
                            color: Islemler.arkaRenk(renk),
                            border: Border.all(color: Colors.black, width: 1),
                          ),
                          child: ListTile(
                            textColor: renkTemp,
                            title: RichText(
                              text: TextSpan(
                                children: <TextSpan>[
                                  TextSpan(
                                    text: "Çağrı Kodu: ",
                                    style: TextStyle(
                                      fontWeight: FontWeight.bold,
                                      color: renkTemp,
                                    ),
                                  ),
                                  TextSpan(
                                    text: cagrikaydi.id.toString(),
                                    style: TextStyle(color: renkTemp),
                                  ),
                                  if (!widget.kullanici.musteri)
                                    TextSpan(
                                      text: "\nMüşteri: ",
                                      style: TextStyle(
                                        fontWeight: FontWeight.bold,
                                        color: renkTemp,
                                      ),
                                    ),
                                  if (!widget.kullanici.musteri)
                                    TextSpan(
                                      text:
                                          "${cagrikaydi.bolge} ${cagrikaydi.birim}",
                                      style: TextStyle(color: renkTemp),
                                    ),
                                  if (cihaz != null)
                                    TextSpan(
                                      text: "\nServis No: ",
                                      style: TextStyle(
                                        fontWeight: FontWeight.bold,
                                        color: renkTemp,
                                      ),
                                    ),
                                  if (cihaz != null)
                                    TextSpan(
                                      text: cihaz.servisNo.toString(),
                                      style: TextStyle(color: renkTemp),
                                    ),
                                  TextSpan(
                                    text: "\nCihaz Türü: ",
                                    style: TextStyle(
                                      fontWeight: FontWeight.bold,
                                      color: renkTemp,
                                    ),
                                  ),
                                  TextSpan(
                                    text:
                                        cihaz != null
                                            ? cihaz.cihazTuru
                                            : cagrikaydi.cihazTuru,
                                    style: TextStyle(color: renkTemp),
                                  ),
                                  TextSpan(
                                    text: "\nCihaz Marka - Model: ",
                                    style: TextStyle(
                                      fontWeight: FontWeight.bold,
                                      color: renkTemp,
                                    ),
                                  ),
                                  TextSpan(
                                    text:
                                        cihaz != null
                                            ? "${cihaz.cihaz}${cihaz.cihazModeli.isNotEmpty ? " ${cihaz.cihazModeli}" : ""}"
                                            : "${cagrikaydi.cihaz}${cagrikaydi.cihazModeli.isNotEmpty ? " ${cagrikaydi.cihazModeli}" : ""}",
                                    style: TextStyle(color: renkTemp),
                                  ),
                                  TextSpan(
                                    text: "\nKayıt Tarihi: ",
                                    style: TextStyle(
                                      fontWeight: FontWeight.bold,
                                      color: renkTemp,
                                    ),
                                  ),
                                  TextSpan(
                                    text: Islemler.tarihGoruntule(
                                      cagrikaydi.tarih,
                                      Islemler.tarihSQLFormat,
                                      Islemler.tarihFormat,
                                    ),
                                    style: TextStyle(color: renkTemp),
                                  ),
                                ],
                              ),
                            ),
                            subtitle: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Text(
                                  cihaz != null
                                      ? cihaz.guncelDurumText.toString()
                                      : "İşlem Bekleniyor",
                                ),
                                if (!widget.kullanici.musteri)
                                  Wrap(
                                    children: [
                                      DefaultButton(
                                        onPressed: () {
                                          Navigator.of(context).push(
                                            MaterialPageRoute(
                                              builder:
                                                  (context) =>
                                                      CagriKaydiDetaySayfasi(
                                                        kullanici:
                                                            widget.kullanici,
                                                        id: cagrikaydi.id,
                                                      ),
                                            ),
                                          );
                                        },
                                        text: "Detaylar",
                                      ),
                                      SizedBox(width: 5),
                                      if (cihaz != null)
                                        DefaultButton(
                                          background: Islemler.arkaRenk(
                                            "bg-success",
                                            alpha: 1,
                                          ),
                                          onPressed: () {
                                            Navigator.of(context).push(
                                              MaterialPageRoute(
                                                builder:
                                                    (
                                                      context,
                                                    ) => DetaylarSayfasi(
                                                      kullanici:
                                                          widget.kullanici,
                                                      servisNo:
                                                          cagrikaydi
                                                              .cihazBilgileri!
                                                              .servisNo,
                                                      cihazlariYenile: () async {
                                                        await cagriKayitlariniGetir();
                                                      },
                                                    ),
                                              ),
                                            );
                                          },
                                          text: "Servis Kaydını Görüntüle",
                                        ),
                                      if (cihaz == null)
                                        DefaultButton(
                                          background: Islemler.arkaRenk(
                                            "bg-success",
                                            alpha: 1,
                                          ),
                                          onPressed: () {
                                            Cihaz cihaz = Cihaz.create(
                                              kullID: cagrikaydi.kullID,
                                              musteriAdi:
                                                  "${cagrikaydi.bolge}${cagrikaydi.birim.isNotEmpty ? " ${cagrikaydi.birim}" : ""}",
                                              telefonNumarasi:
                                                  cagrikaydi.telefonNumarasi,
                                              cagriID: cagrikaydi.id,
                                              cihazTuruVal:
                                                  cagrikaydi.cihazTuruVal,
                                              cihazTuru: cagrikaydi.cihazTuru,
                                              cihaz: cagrikaydi.cihaz,
                                              cihazModeli:
                                                  cagrikaydi.cihazModeli,
                                              seriNo: cagrikaydi.seriNo,
                                              arizaAciklamasi:
                                                  cagrikaydi.arizaAciklamasi,
                                            );
                                            Navigator.push(
                                              context,
                                              MaterialPageRoute(
                                                builder:
                                                    (
                                                      context,
                                                    ) => YeniCihazSayfasi(
                                                      initialCihaz: cihaz,
                                                      cihazlariYenile: () async {
                                                        await cagriKayitlariniGetir();
                                                      },
                                                    ),
                                              ),
                                            );
                                          },
                                          text: "Kayıt Aç",
                                        ),
                                      /*SizedBox(width: 5),
                                      DefaultButton(
                                        background: Islemler.arkaRenk(
                                          "bg-info",
                                          alpha: 1,
                                        ),
                                        onPressed: () {},
                                        text: "Düzenle",
                                      ),*/
                                      SizedBox(width: 5),
                                      DefaultButton(
                                        background: Islemler.arkaRenk(
                                          "bg-danger",
                                          alpha: 1,
                                        ),
                                        onPressed: () async {
                                          showDialog(
                                            context: context,
                                            builder: (context) {
                                              return AlertDialog(
                                                title: Text(
                                                  "Çağrı Kaydını Sil",
                                                ),
                                                content: Text(
                                                  "${cagrikaydi.id} kodlu çağrı kaydını silmek istediğinize emin misiniz?",
                                                ),
                                                actions: [
                                                  TextButton(
                                                    onPressed: () async {
                                                      Navigator.pop(context);
                                                      _yukleniyorGoster();
                                                      bool sonuc =
                                                          await BiltekPost.cagriKaydiSil(
                                                            id: cagrikaydi.id,
                                                          );
                                                      if (sonuc) {
                                                        await cagriKayitlariniGetir();
                                                        _yukleniyorGizle();
                                                      } else {
                                                        _yukleniyorGizle();
                                                        if (context.mounted) {
                                                          showDialog(
                                                            context: context,
                                                            builder:
                                                                (
                                                                  context,
                                                                ) => AlertDialog(
                                                                  title: Text(
                                                                    "Silinemedi",
                                                                  ),
                                                                  content: Text(
                                                                    "Çağrı kaydı silinirken bir hata oluştu",
                                                                  ),
                                                                  actions: [
                                                                    TextButton(
                                                                      onPressed: () {
                                                                        Navigator.pop(
                                                                          context,
                                                                        );
                                                                      },
                                                                      child: Text(
                                                                        "Tamam",
                                                                      ),
                                                                    ),
                                                                  ],
                                                                ),
                                                          );
                                                        }
                                                      }
                                                    },
                                                    child: Text(
                                                      "Evet",
                                                      style: TextStyle(
                                                        color: Colors.red,
                                                      ),
                                                    ),
                                                  ),
                                                  TextButton(
                                                    onPressed: () {
                                                      Navigator.pop(context);
                                                    },
                                                    child: Text("Hayır"),
                                                  ),
                                                ],
                                              );
                                            },
                                          );
                                        },
                                        text: "Sil",
                                      ),
                                    ],
                                  ),
                              ],
                            ),
                            trailing:
                                widget.kullanici.musteri
                                    ? DefaultButton(
                                      onPressed: () {
                                        Navigator.of(context).push(
                                          MaterialPageRoute(
                                            builder:
                                                (context) =>
                                                    CagriKaydiDetaySayfasi(
                                                      kullanici:
                                                          widget.kullanici,
                                                      id: cagrikaydi.id,
                                                    ),
                                          ),
                                        );
                                      },
                                      text: "Detaylar",
                                    )
                                    : null,
                          ),
                        ),
                      );
                    },
                  ),
                ),
      ),
    );
  }

  Future<void> cagriKayitlariniGetir() async {
    List<CagriKaydiModel> cagriKayitlariTemp = await BiltekPost.cagriKayitlari(
      kullaniciID: widget.kullanici.musteri ? widget.kullanici.id : 0,
    );
    setState(() {
      cagriKayitlari = cagriKayitlariTemp;
    });
  }

  bool yukleniyorAcik = false;
  void _yukleniyorGoster() {
    if (mounted && !yukleniyorAcik) {
      setState(() {
        yukleniyorAcik = true;
      });
      yukleniyor(context);
    }
  }

  void _yukleniyorGizle() {
    if (mounted && yukleniyorAcik) {
      Navigator.pop(context);
      setState(() {
        yukleniyorAcik = false;
      });
    }
  }
}
