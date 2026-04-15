import 'dart:convert';

import 'package:biltekteknikservis/widgets/dizayn.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';

import '../../models/cagri_kaydi.dart';
import '../../models/cihaz.dart';
import '../../models/kullanici.dart';
import '../../utils/alerts.dart';
import '../../utils/buttons.dart';
import '../../utils/extensions.dart';
import '../../utils/islemler.dart';
import '../../utils/post.dart';
import '../../utils/shared_preferences.dart';
import '../../widgets/navigators.dart';
import '../ayarlar/ayarlar.dart';
import '../cihazlar.dart';
import '../detaylar/detaylar.dart';
import '../giris_sayfasi.dart';
import '../yeni_cihaz.dart';
import 'cagri_kaydi_detay.dart';

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
                            CupertinoIcons.gear,
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
                            CupertinoIcons.square_arrow_left,
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
          child: Icon(CupertinoIcons.add),
        ),*/
        bottomNavigationBar: BiltekBottomNavigationBar(
          items: [
            BottomNavigationBarItem(
              icon: Icon(CupertinoIcons.line_horizontal_3),
              label: "Menü",
            ),
            BottomNavigationBarItem(
              icon: Icon(CupertinoIcons.gear),
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
        body: SafeArea(
          child: Container(
            decoration: BoxDecoration(color: Colors.white),
            child:
                cagriKayitlari == null
                    ? Center(child: CircularProgressIndicator())
                    : Column(
                      children: [
                        if (!widget.kullanici.musteri &&
                            cagriKayitlari != null &&
                            cagriKayitlari!
                                    .where(
                                      (c) =>
                                          c.cihazBilgileri != null &&
                                          c.cihazBilgileri!.guncelDurumText
                                                  .toString() ==
                                              "Teslim Edildi / Ödeme Alınmadı",
                                    )
                                    .fold(
                                      0.0,
                                      (toplam, c) => toplam + c.toplamUcret,
                                    ) >
                                0)
                          Container(
                            width: double.infinity,
                            padding: EdgeInsets.all(15),
                            decoration: BoxDecoration(
                              color: Colors.red.shade400,
                            ),
                            child: Text(
                              "Teslim Edilip Ödeme Alınmayan Toplam Ücret: ${cagriKayitlari!.where((c) => c.cihazBilgileri != null && c.cihazBilgileri!.guncelDurumText.toString() == "Teslim Edildi / Ödeme Alınmadı").fold(0.0, (toplam, c) => toplam + c.toplamUcret).toUcret()} TL",
                              style: TextStyle(
                                color: Colors.white,
                                fontWeight: FontWeight.bold,
                              ),
                            ),
                          ),
                        Expanded(
                          child: RefreshIndicator(
                            onRefresh: () async {
                              await cagriKayitlariniGetir();
                            },
                            child: ListView.builder(
                              itemCount: cagriKayitlari!.length,
                              controller: scrollController,
                              physics: AlwaysScrollableScrollPhysics(),
                              itemBuilder: (context, index) {
                                CagriKaydiModel cagrikaydi =
                                    cagriKayitlari![index];
                                Cihaz? cihaz = cagrikaydi.cihazBilgileri;
                                String renk =
                                    cihaz != null
                                        ? cihaz.guncelDurumRenk
                                        : "bg-warning";
                                debugPrint("Guncel Durum Renk $renk");
                                Color? renkTemp = Islemler.yaziRengi(renk);
                                return SectionCard(
                                  backgroundColor: Islemler.arkaRenk(renk),
                                  darkTheme: false,
                                  children: [
                                    InfoTileList(
                                      label: "Çağrı Kodu",
                                      value: cagrikaydi.id.toString(),
                                      textColor: renkTemp,
                                    ),
                                    if (!widget.kullanici.musteri)
                                      InfoTileList(
                                        label: "Müşteri",
                                        value:
                                            "${cagrikaydi.bolge} ${cagrikaydi.birim}",
                                        textColor: renkTemp,
                                      ),
                                    if (cihaz != null)
                                      InfoTileList(
                                        label: "Servis No",
                                        value: cihaz.servisNo.toString(),
                                        textColor: renkTemp,
                                      ),
                                    InfoTileList(
                                      label: "Cihaz Türü",
                                      value:
                                          cihaz != null
                                              ? cihaz.cihazTuru
                                              : cagrikaydi.cihazTuru,
                                      textColor: renkTemp,
                                    ),
                                    InfoTileList(
                                      label: "Cihaz Marka - Model",
                                      value:
                                          cihaz != null
                                              ? "${cihaz.cihaz}${cihaz.cihazModeli.isNotEmpty ? " ${cihaz.cihazModeli}" : ""}"
                                              : "${cagrikaydi.cihaz}${cagrikaydi.cihazModeli.isNotEmpty ? " ${cagrikaydi.cihazModeli}" : ""}",
                                      textColor: renkTemp,
                                    ),
                                    InfoTileList(
                                      label: "Kayıt Tarihi",
                                      value: Islemler.tarihGoruntule(
                                        cagrikaydi.tarih,
                                        Islemler.tarihSQLFormat,
                                        Islemler.tarihFormat,
                                      ),
                                      textColor: renkTemp,
                                    ),
                                    InfoTileList(
                                      label: "Durum",
                                      value:
                                          cihaz != null
                                              ? cihaz.guncelDurumText.toString()
                                              : "İşlem Bekleniyor",
                                      textColor: renkTemp,
                                    ),

                                    if (!widget.kullanici.musteri)
                                      InfoTileList(
                                        label: "Toplam Ücret",
                                        value:
                                            cagrikaydi.toplamUcret > 0
                                                ? "${cagrikaydi.toplamUcret.toUcret()} TL"
                                                : "-",
                                        textColor: renkTemp,
                                      ),

                                    Wrap(
                                      crossAxisAlignment:
                                          WrapCrossAlignment.start,
                                      alignment: WrapAlignment.start,
                                      children: [
                                        if (widget.kullanici.musteri)
                                          Wrap(
                                            crossAxisAlignment:
                                                WrapCrossAlignment.end,
                                            children: [
                                              PrimaryButton(
                                                onPressed: () {
                                                  Navigator.of(context).push(
                                                    MaterialPageRoute(
                                                      builder:
                                                          (
                                                            context,
                                                          ) => CagriKaydiDetaySayfasi(
                                                            kullanici:
                                                                widget
                                                                    .kullanici,
                                                            id: cagrikaydi.id,
                                                          ),
                                                    ),
                                                  );
                                                },
                                                label: "Detaylar",
                                              ),
                                            ],
                                          ),
                                        if (!widget.kullanici.musteri)
                                          PrimaryButton(
                                            onPressed: () {
                                              Navigator.of(context).push(
                                                MaterialPageRoute(
                                                  builder:
                                                      (context) =>
                                                          CagriKaydiDetaySayfasi(
                                                            kullanici:
                                                                widget
                                                                    .kullanici,
                                                            id: cagrikaydi.id,
                                                          ),
                                                ),
                                              );
                                            },
                                            label: "Detaylar",
                                          ),
                                        if (!widget.kullanici.musteri)
                                          SizedBox(width: 5),
                                        if (cihaz != null &&
                                            !widget.kullanici.musteri)
                                          PrimaryButton(
                                            backgroundColor: Islemler.arkaRenk(
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
                                                        no:
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
                                            label: "Servis Kaydını Görüntüle",
                                          ),
                                        if (cihaz == null &&
                                            !widget.kullanici.musteri)
                                          PrimaryButton(
                                            backgroundColor: Islemler.arkaRenk(
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
                                            label: "Kayıt Aç",
                                          ),
                                        /*SizedBox(width: 5),
                                                PrimaryButton(
                                                  backgroundColor: Islemler.arkaRenk(
                                                    "bg-info",
                                                    alpha: 1,
                                                  ),
                                                  onPressed: () {},
                                                  label: "Düzenle",
                                                ),*/
                                        if (!widget.kullanici.musteri)
                                          SizedBox(width: 5),
                                        if (!widget.kullanici.musteri)
                                          PrimaryButton(
                                            backgroundColor: Islemler.arkaRenk(
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
                                                          Navigator.pop(
                                                            context,
                                                          );
                                                          _yukleniyorGoster();
                                                          bool sonuc =
                                                              await BiltekPost.cagriKaydiSil(
                                                                id:
                                                                    cagrikaydi
                                                                        .id,
                                                              );
                                                          if (sonuc) {
                                                            await cagriKayitlariniGetir();
                                                            _yukleniyorGizle();
                                                          } else {
                                                            _yukleniyorGizle();
                                                            if (context
                                                                .mounted) {
                                                              showDialog(
                                                                context:
                                                                    context,
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
                                                          Navigator.pop(
                                                            context,
                                                          );
                                                        },
                                                        child: Text("Hayır"),
                                                      ),
                                                    ],
                                                  );
                                                },
                                              );
                                            },
                                            label: "Sil",
                                          ),
                                      ],
                                    ),
                                  ],
                                );
                              },
                            ),
                          ),
                        ),
                      ],
                    ),
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
