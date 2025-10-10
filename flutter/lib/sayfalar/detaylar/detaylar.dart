import 'dart:async';

import 'package:flutter/material.dart';
import 'package:flutter_contacts/flutter_contacts.dart';
import 'package:permission_handler/permission_handler.dart';
import 'package:url_launcher/url_launcher_string.dart';

import '../../ayarlar.dart';
import '../../models/cihaz.dart';
import '../../models/cihaz_duzenleme/cihaz_duzenleme.dart';
import '../../models/kullanici.dart';
import '../../utils/alerts.dart';
import '../../utils/assets.dart';
import '../../utils/desen.dart';
import '../../utils/islemler.dart';
import '../../utils/post.dart';
import '../../widgets/navigators.dart';
import '../../widgets/overlay_notification.dart';
import '../webview.dart';
import 'duzenle.dart';
import 'galery.dart';

class DetaylarSayfasi extends StatefulWidget {
  const DetaylarSayfasi({
    super.key,
    required this.kullanici,
    required this.servisNo,
    required this.cihazlariYenile,
  });

  final KullaniciAuthModel kullanici;
  final int servisNo;
  final VoidCallback cihazlariYenile;

  @override
  State<DetaylarSayfasi> createState() => _DetaylarSayfasiState();
}

class _DetaylarSayfasiState extends State<DetaylarSayfasi> {
  Cihaz? cihaz;

  bool detaylarYukleniyor = true;

  TableBorder tableBorder = TableBorder.all(
    color: Colors.yellow.withAlpha(100),
  );

  CihazDuzenlemeModel cihazDuzenleme = CihazDuzenlemeModel.bos();

  int seciliIndex = 0;
  PageController pageController = PageController(initialPage: 0);

  @override
  void initState() {
    Future.delayed(Duration.zero, () async {
      await _cihazDuzenlemeGetir();
      await _cihaziYenile();
    });
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return PopScope(
      canPop: false,
      onPopInvokedWithResult: (didPop, result) {
        if (didPop) {
          return;
        }
        widget.cihazlariYenile.call();
        Navigator.pop(context);
      },
      child: Scaffold(
        appBar: AppBar(
          title: cihaz != null ? Text("${cihaz!.servisNo}") : null,
          actions: [],
        ),
        floatingActionButton: Builder(
          builder: (context) {
            return Stack(
              children: [
                Positioned(
                  right: 0,
                  bottom: duzenlenebilir() ? 60 : 0,
                  child: SizedBox(
                    width: 50,
                    height: 50,
                    child: FloatingActionButton(
                      heroTag: "Print",
                      shape: const CircleBorder(),
                      onPressed: () async {
                        String url = Ayarlar.teknikservisformu(
                          auth: widget.kullanici.auth,
                          cihazID: cihaz!.id,
                        );

                        Navigator.of(context).push(
                          MaterialPageRoute(
                            builder: (context) => WebviewPage(url: url),
                          ),
                        );
                      },
                      child: Icon(Icons.print),
                    ),
                  ),
                ),
                if (duzenlenebilir())
                  Positioned(
                    right: 0,
                    bottom: 0,
                    child: SizedBox(
                      width: 50,
                      height: 50,
                      child: FloatingActionButton(
                        heroTag: "Edit",
                        shape: const CircleBorder(),
                        onPressed: () async {
                          NavigatorState navigatorState = Navigator.of(context);
                          await _cihaziYenile();
                          navigatorState.push(
                            MaterialPageRoute(
                              builder:
                                  (context) => DetayDuzenle(
                                    cihaz: cihaz!,
                                    cihazlariYenile: () async {
                                      await _cihaziYenile();
                                    },
                                  ),
                            ),
                          );
                        },
                        child: Icon(Icons.edit),
                      ),
                    ),
                  ),
              ],
            );
          },
        ),
        bottomNavigationBar: BiltekBottomNavigationBar(
          items: [
            BottomNavigationBarItem(
              icon: Icon(Icons.device_hub),
              label: "Genel",
            ),
            BottomNavigationBarItem(icon: Icon(Icons.laptop), label: "Servis"),
            BottomNavigationBarItem(icon: Icon(Icons.mouse), label: "İşlemler"),
            BottomNavigationBarItem(icon: Icon(Icons.image), label: "Galeri"),
          ],
          selectedItemColor: Colors.greenAccent,
          currentIndex: seciliIndex,
          onTap: (index) {
            if (index == 3) {
              _galeriyiAc();
            } else {
              pageController.animateToPage(
                index,
                duration: Duration(milliseconds: 500),
                curve: Curves.ease,
              );
              setState(() {
                seciliIndex = index;
              });
            }
          },
        ),
        body: RefreshIndicator(
          onRefresh: () async {
            await _cihaziYenile();
          },
          child: Container(
            padding: EdgeInsets.all(8),
            child: PageView(
              controller: pageController,
              onPageChanged: (index) {
                if (index == 3) {
                  pageController.jumpToPage(2);
                  _galeriyiAc();
                } else {
                  setState(() {
                    seciliIndex = index;
                  });
                }
              },
              children: [_genel(), _cihazBilgileri(), _islemler(), SizedBox()],
            ),
          ),
        ),
      ),
    );
  }

  Future<void> _cihaziYenile() async {
    _yukleniyorGoster();
    Cihaz? cihazTemp = await BiltekPost.cihazGetir(servisNo: widget.servisNo);
    if (mounted) {
      setState(() {
        cihaz = cihazTemp;
      });
    } else {
      cihaz = cihazTemp;
    }

    if (cihaz == null) {
      if (mounted) {
        showDialog(
          context: context,
          builder: (context) {
            return AlertDialog(
              title: Text("Cihaz Bulunamadı"),
              content: Text("Cihaz bulunamadı. Silinmiş olabilir."),
              actions: [
                TextButton(
                  onPressed: () {
                    Navigator.pop(context);
                    Navigator.pop(context);
                  },
                  child: Text("Geri"),
                ),
              ],
            );
          },
        );
      }
      return;
    }

    setState(() {
      detaylarYukleniyor = false;
    });
    _yukleniyorGizle();
  }

  Future<void> _ara() async {
    String telefon = telefonNumarasi();

    if (telefonGecerli(telefon)) {
      launchUrlString("tel://$telefon");
    } else {
      _gecersizTelefonDialog();
    }
  }

  void kisiIzniUyari() {
    showDialog(
      context: context,
      builder: (context) {
        return AlertDialog(
          title: Text("Kişi İzni Reddedildi"),
          content: Text(
            "Kişiler izni reddedilmiş. Bu işleme devam edebilmek için izin Kişiler izni vermelisiniz. Ayarlardan izin verebilirsiniz. Ne yapmak istiyorsunuz?",
          ),
          actions: [
            TextButton(
              onPressed: () {
                Navigator.pop(context);
                openAppSettings();
              },
              child: Text("Ayarları Aç"),
            ),
            TextButton(
              onPressed: () {
                Navigator.pop(context);
              },
              child: Text("İptal"),
            ),
          ],
        );
      },
    );
  }

  bool yukleniyorGosterildi = false;
  void _yukleniyorGoster() {
    if (!yukleniyorGosterildi) {
      setState(() {
        yukleniyorGosterildi = true;
      });
      yukleniyor(context);
    }
  }

  void _yukleniyorGizle() {
    if (yukleniyorGosterildi) {
      setState(() {
        yukleniyorGosterildi = false;
      });
      Navigator.pop(context);
    }
  }

  Future<void> _kisiEkle() async {
    String telefon = telefonNumarasi();
    if (telefonGecerli(telefon)) {
      if (await Permission.contacts.isPermanentlyDenied) {
        kisiIzniUyari();
        return;
      }
      if (await Permission.contacts.request().isGranted) {
        Contact? contact = await FlutterContacts.openExternalInsert(
          Contact(phones: [Phone(telefon)], displayName: cihaz!.musteriAdi),
        );
        debugPrint("Kişi: $contact");
        if (contact != null) {
          showNotification(body: "Müşteri kaydedildi.");
        } else {
          showNotification(body: "Müşteri kaydetme iptal edildi.");
        }
      } else {
        kisiIzniUyari();
        return;
      }
    } else {
      _gecersizTelefonDialog();
    }
  }

  Future<void> _sms() async {
    String telefon = telefonNumarasi();

    if (telefonGecerli(telefon)) {
      launchUrlString("sms:$telefon");
    } else {
      _gecersizTelefonDialog();
    }
  }

  Future<void> _whatsapp() async {
    String telefon = telefonNumarasi();

    if (telefonGecerli(telefon)) {
      launchUrlString("https://wa.me/$telefon");
    } else {
      _gecersizTelefonDialog();
    }
  }

  void _gecersizTelefonDialog() {
    showDialog(
      context: context,
      builder: (context) {
        return AlertDialog(
          title: Text("Geçersiz Telefon"),
          content: Text("Telefon numarası geçersiz"),
          actions: [
            TextButton(
              onPressed: () {
                Navigator.pop(context);
              },
              child: Text("Kapat"),
            ),
          ],
        );
      },
    );
  }

  String telefonNumarasi() {
    if (cihaz != null) {
      String telefon = cihaz!.telefonNumarasi;
      telefon = Islemler.telNo(telefon);
      return telefon;
    }
    return "";
  }

  bool telefonGecerli(String telefon) {
    return telefon.isNotEmpty && telefon != "+90" && telefon != "+9";
  }

  Future<void> _cihazDuzenlemeGetir() async {
    CihazDuzenlemeModel cihazDuzenlemeTemp =
        await BiltekPost.cihazDuzenlemeGetir();
    setState(() {
      cihazDuzenleme = cihazDuzenlemeTemp;
    });
  }

  bool duzenlenebilir() {
    return cihaz != null &&
        cihazDuzenleme.cihazDurumlari.indexWhere(
              (e) => e.id == cihaz!.guncelDurum && e.kilitle,
            ) <
            0;
  }

  Widget _genel() {
    return SizedBox(
      child:
          cihaz != null
              ? SingleChildScrollView(
                physics: AlwaysScrollableScrollPhysics(),
                child: Table(
                  border: tableBorder,
                  children: [
                    TableRow(
                      children: [
                        Text(
                          "Servis No:",
                          style: TextStyle(fontWeight: FontWeight.bold),
                        ),
                        Text(cihaz!.servisNo.toString()),
                      ],
                    ),
                    TableRow(
                      children: [
                        Text(
                          "Takip No:",
                          style: TextStyle(fontWeight: FontWeight.bold),
                        ),
                        Text(cihaz!.takipNumarasi.toString()),
                      ],
                    ),
                    TableRow(
                      children: [
                        Text(
                          "Müşteri Adı:",
                          style: TextStyle(fontWeight: FontWeight.bold),
                        ),
                        Text(cihaz!.musteriAdi),
                      ],
                    ),
                    TableRow(
                      children: [
                        Text(
                          "Teslim Eden:",
                          style: TextStyle(fontWeight: FontWeight.bold),
                        ),
                        Text(cihaz!.teslimEden),
                      ],
                    ),
                    TableRow(
                      children: [
                        Text(
                          "Teslim Alan:",
                          style: TextStyle(fontWeight: FontWeight.bold),
                        ),
                        Text(cihaz!.teslimAlan),
                      ],
                    ),
                    TableRow(
                      children: [
                        Text(
                          "Adresi:",
                          style: TextStyle(fontWeight: FontWeight.bold),
                        ),
                        Text(cihaz!.adres),
                      ],
                    ),
                    TableRow(
                      children: [
                        Text(
                          "GSM:",
                          style: TextStyle(fontWeight: FontWeight.bold),
                        ),
                        Column(
                          children: [
                            Text(cihaz!.telefonNumarasi),
                            SizedBox(height: 2),
                            Column(
                              mainAxisSize: MainAxisSize.max,
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: [
                                Row(
                                  mainAxisSize: MainAxisSize.max,
                                  mainAxisAlignment: MainAxisAlignment.center,
                                  children: [
                                    IconButton(
                                      onPressed: () async {
                                        await _ara();
                                      },
                                      icon: Icon(Icons.phone),
                                    ),
                                    SizedBox(width: 1),
                                    IconButton(
                                      onPressed: () async {
                                        await _kisiEkle();
                                      },
                                      icon: Icon(Icons.contact_page),
                                    ),
                                  ],
                                ),
                                Row(
                                  mainAxisSize: MainAxisSize.max,
                                  mainAxisAlignment: MainAxisAlignment.center,
                                  children: [
                                    IconButton(
                                      onPressed: () async {
                                        await _sms();
                                      },
                                      icon: Image.asset(
                                        BiltekAssets.sms,
                                        width: 24,
                                        height: 24,
                                      ),
                                    ),
                                    SizedBox(width: 1),
                                    IconButton(
                                      onPressed: () async {
                                        await _whatsapp();
                                      },
                                      icon: Image.asset(
                                        BiltekAssets.whatsapp,
                                        width: 24,
                                        height: 24,
                                      ),
                                    ),
                                  ],
                                ),
                              ],
                            ),
                          ],
                        ),
                      ],
                    ),
                    TableRow(
                      children: [
                        Text(
                          "Giriş Tarihi:",
                          style: TextStyle(fontWeight: FontWeight.bold),
                        ),
                        Text(cihaz!.tarih),
                      ],
                    ),
                    TableRow(
                      children: [
                        Text(
                          "Çıkış Tarihi:",
                          style: TextStyle(fontWeight: FontWeight.bold),
                        ),
                        Text(cihaz!.cikisTarihi),
                      ],
                    ),
                    TableRow(
                      children: [
                        Text(
                          "Bildirim Tarihi:",
                          style: TextStyle(fontWeight: FontWeight.bold),
                        ),
                        Text(cihaz!.bildirimTarihi),
                      ],
                    ),
                    TableRow(
                      children: [
                        Text(
                          "Güncel Durum:",
                          style: TextStyle(fontWeight: FontWeight.bold),
                        ),
                        Text(cihaz!.guncelDurumText),
                      ],
                    ),
                  ],
                ),
              )
              : Center(child: CircularProgressIndicator()),
    );
  }

  Widget _cihazBilgileri() {
    return SizedBox(
      child:
          cihaz != null
              ? SingleChildScrollView(
                physics: AlwaysScrollableScrollPhysics(),
                child: Table(
                  border: tableBorder,
                  children: [
                    TableRow(
                      children: [
                        Text(
                          "Cihaz Türü:",
                          style: TextStyle(fontWeight: FontWeight.bold),
                        ),
                        Text(cihaz!.cihazTuru),
                      ],
                    ),
                    TableRow(
                      children: [
                        Text(
                          "Markası:",
                          style: TextStyle(fontWeight: FontWeight.bold),
                        ),
                        Text(cihaz!.cihaz),
                      ],
                    ),
                    TableRow(
                      children: [
                        Text(
                          "Modeli:",
                          style: TextStyle(fontWeight: FontWeight.bold),
                        ),
                        Text(cihaz!.cihazModeli),
                      ],
                    ),
                    TableRow(
                      children: [
                        Text(
                          "Seri No:",
                          style: TextStyle(fontWeight: FontWeight.bold),
                        ),
                        Text(cihaz!.seriNo),
                      ],
                    ),
                    TableRow(
                      children: [
                        Text(
                          "Teslim Alınanlar:",
                          style: TextStyle(fontWeight: FontWeight.bold),
                        ),
                        Text(cihaz!.teslimAlan),
                      ],
                    ),
                    TableRow(
                      children: [
                        Text(
                          "Cihaz Şifresi:",
                          style: TextStyle(fontWeight: FontWeight.bold),
                        ),
                        cihaz!.cihazDeseni.isNotEmpty
                            ? SizedBox(
                              width: MediaQuery.of(context).size.width,
                              height: 200,
                              child: Desen(
                                initDesen: Islemler.desenDonusturFlutter(
                                  cihaz!.cihazDeseni,
                                ),
                                duzenlenebilir: false,
                                pointRadius: 8,
                                showInput: true,
                                dimension: 3,
                                relativePadding: 0.7,
                                selectThreshold: 25,
                                fillPoints: true,
                                onInputComplete: (list) {},
                              ),
                            )
                            : Text(cihaz!.cihazSifresi),
                      ],
                    ),
                  ],
                ),
              )
              : Center(child: CircularProgressIndicator()),
    );
  }

  Widget _islemler() {
    return SizedBox(
      child:
          cihaz != null
              ? SingleChildScrollView(
                physics: AlwaysScrollableScrollPhysics(),
                child: Column(
                  children: [
                    Table(
                      border: tableBorder,
                      children: [
                        /*TableRow(
                                      children: [
                                        Text(
                                          "Teslim Alınmadan Önce Belirlenen Hasar Türü:",
                                          style: TextStyle(
                                            fontWeight: FontWeight.bold,
                                          ),
                                        ),
                                        Text(cihaz!.cihazdakiHasar)
                                      ],
                                    ),*/
                        TableRow(
                          children: [
                            Text(
                              "Teslim Alınmadan Önce Yapılan Hasar Tespiti:",
                              style: TextStyle(fontWeight: FontWeight.bold),
                            ),
                            Text(cihaz!.hasarTespiti),
                          ],
                        ),
                        TableRow(
                          children: [
                            Text(
                              "Arıza Açıklaması:",
                              style: TextStyle(fontWeight: FontWeight.bold),
                            ),
                            Text(cihaz!.arizaAciklamasi),
                          ],
                        ),
                        TableRow(
                          children: [
                            Text(
                              "Servis Türü:",
                              style: TextStyle(fontWeight: FontWeight.bold),
                            ),
                            Text(Islemler.servisTuru(cihaz!.servisTuru)),
                          ],
                        ),
                        TableRow(
                          children: [
                            Text(
                              "Yedek Alınacak mı?:",
                              style: TextStyle(fontWeight: FontWeight.bold),
                            ),
                            Text(
                              cihaz!.yedekDurumu == 1
                                  ? "Evet"
                                  : (cihaz!.yedekDurumu == 0
                                      ? "Hayır"
                                      : "Belirtilmemiş"),
                            ),
                          ],
                        ),
                        TableRow(
                          children: [
                            Text(
                              "Güncel Durum:",
                              style: TextStyle(fontWeight: FontWeight.bold),
                            ),
                            Text(cihaz!.guncelDurumText),
                          ],
                        ),
                        TableRow(
                          children: [
                            Text(
                              "Bildirim Tarihi:",
                              style: TextStyle(fontWeight: FontWeight.bold),
                            ),
                            Text(cihaz!.bildirimTarihi),
                          ],
                        ),
                        TableRow(
                          children: [
                            Text(
                              "Sorumlu Personel:",
                              style: TextStyle(fontWeight: FontWeight.bold),
                            ),
                            Text(cihaz!.sorumlu),
                          ],
                        ),
                        TableRow(
                          children: [
                            Text(
                              "Yapılan İşlem Açıklaması:",
                              style: TextStyle(fontWeight: FontWeight.bold),
                            ),
                            Text(cihaz!.yapilanIslemAciklamasi),
                          ],
                        ),
                        TableRow(
                          children: [
                            Text(
                              "Notlar:",
                              style: TextStyle(fontWeight: FontWeight.bold),
                            ),
                            Text(cihaz!.notlar),
                          ],
                        ),
                      ],
                    ),
                    Islemler.liste(cihaz!.islemler, maliyetGosterButon: true),
                    Table(
                      border: tableBorder,
                      children: [
                        TableRow(
                          children: [
                            Text(
                              "Tahsilat Şekli:",
                              style: TextStyle(fontWeight: FontWeight.bold),
                            ),
                            Text(cihaz!.tahsilatSekli),
                          ],
                        ),
                        TableRow(
                          children: [
                            Text(
                              "Fatura Durumu:",
                              style: TextStyle(fontWeight: FontWeight.bold),
                            ),
                            Text(Islemler.faturaDurumu(cihaz!.faturaDurumu)),
                          ],
                        ),
                        TableRow(
                          children: [
                            Text(
                              "Fiş No:",
                              style: TextStyle(fontWeight: FontWeight.bold),
                            ),
                            Text(cihaz!.fisNo),
                          ],
                        ),
                      ],
                    ),
                  ],
                ),
              )
              : Center(child: CircularProgressIndicator()),
    );
  }

  void _galeriyiAc() {
    Navigator.of(context).push(
      MaterialPageRoute(
        builder:
            (context) => DetaylarGaleri(
              duzenle: duzenlenebilir(),
              id: cihaz!.id,
              servisNo: cihaz!.servisNo,
            ),
      ),
    );
  }
}
