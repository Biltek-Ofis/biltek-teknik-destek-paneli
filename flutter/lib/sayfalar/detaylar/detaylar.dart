import 'dart:async';

import 'package:flutter/material.dart';
import 'package:flutter_contacts/flutter_contacts.dart';
import 'package:permission_handler/permission_handler.dart';
import 'package:share_plus/share_plus.dart';
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

  Timer? timer;

  TableBorder tableBorder = TableBorder.all(
    color: Colors.yellow.withAlpha(100),
  );

  double kdvsizToplam = 0;
  double kdvToplam = 0;

  List<TableRow> fiyatlar = [];

  CihazDuzenlemeModel cihazDuzenleme = CihazDuzenlemeModel.bos();

  int seciliIndex = 0;
  PageController pageController = PageController(initialPage: 0);

  @override
  void initState() {
    Future.delayed(Duration.zero, () async {
      await _cihazDuzenlemeGetir();
      await _cihaziYenile();
    });
    timer = Timer.periodic(Duration(seconds: 5), (timer) async {
      await _cihaziYenile();
    });
    super.initState();
  }

  @override
  void dispose() {
    timer?.cancel();
    super.dispose();
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
          actions: [
            /*if (cihaz != null)
                  IconButton(
                    onPressed: () async {
                      String url = Ayarlar.teknikservisformu(
                        auth: widget.kullanici.auth,
                        cihazID: cihaz!.id,
                      );

                      Navigator.of(context).push(
                        MaterialPageRoute(
                          builder: (context) => WebviewPage(
                            url: url,
                          ),
                        ),
                      );
                    },
                    icon: Icon(Icons.print),
                  ),*/
            /*if (cihaz != null)
                PopupMenuButton<String>(
                  onSelected: (value) async {
                    switch (value) {
                      case "bilgisayardaAc":
                        await BiltekPost.bilgisayardaAc(
                          kullaniciID: widget.kullanici.id,
                          servisNo: cihaz!.servisNo,
                        );
                        BarkodOkuyucu? barkodOkuyucu =
                            await BarkodOkuyucu.getir();
                        await barkodOkuyucu?.servisNo(cihaz!.servisNo);
                        break;
                      case "fiyatPaylas":
                        await _fiyatBilgisiPaylas();
                        break;
                      case "ara":
                        await _ara();
                        break;
                      case "mesajGonder":
                        await _whatsapp();
                        break;
                      case "kisilereEkle":
                        await _kisiEkle();
                        break;
                    }
                  },
                  itemBuilder: (context) {
                    return [
                      PopupMenuItem<String>(
                        value: "bilgisayardaAc",
                        child: ListTile(
                          leading: Icon(Icons.desktop_windows),
                          title: Text("Bilgisayarda Aç"),
                        ),
                      ),
                      PopupMenuItem<String>(
                        value: "fiyatPaylas",
                        child: ListTile(
                          leading: Icon(Icons.share),
                          title: Text("Fiyat Bilgisi Paylaş"),
                        ),
                      ),
                      PopupMenuItem<String>(
                        value: "ara",
                        child: ListTile(
                          leading: Icon(Icons.phone),
                          title: Text("Ara"),
                        ),
                      ),
                      PopupMenuItem<String>(
                        value: "mesajGonder",
                        child: ListTile(
                          leading: Image.asset(
                            BiltekAssets.whatsapp,
                            width: 24,
                            height: 24,
                          ),
                          title: Text("Mesaj Gönder"),
                        ),
                      ),
                      PopupMenuItem<String>(
                        value: "kisilereEkle",
                        child: ListTile(
                          leading: Icon(Icons.contact_page),
                          title: Text("Rehbere Ekle"),
                        ),
                      ),
                    ];
                  },
                ),*/
          ],
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
                          Navigator.of(context).push(
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
            }
          },
        ),
        body: Container(
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
    );
  }

  Future<void> _cihaziYenile() async {
    Cihaz? cihazTemp = await BiltekPost.cihazGetir(servisNo: widget.servisNo);
    if (mounted) {
      setState(() {
        cihaz = cihazTemp;
      });
    } else {
      cihaz = cihazTemp;
    }
    EdgeInsetsGeometry padding = EdgeInsets.all(1);
    List<TableRow> fiyatlarTemp = [];
    double kdvsizToplamTemp = 0;
    double kdvToplamTemp = 0;
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
    for (int i = 0; i < cihaz!.islemler.length; i++) {
      YapilanIslem islem = cihaz!.islemler[i];
      if (islem.ad.isNotEmpty) {
        double kdvsiz = islem.miktar * islem.birimFiyati;
        double kdv = (kdvsiz / 100) * islem.kdv;
        double kdvli = kdvsiz + kdv;
        kdvsizToplamTemp += kdvsiz;
        kdvToplamTemp += kdv;
        fiyatlarTemp.add(
          TableRow(
            children: [
              Container(padding: padding, child: Text(islem.ad)),
              Container(padding: padding, child: Text(islem.miktar.toString())),
              Container(
                padding: padding,
                child: Text("${islem.birimFiyati} TL"),
              ),
              Container(
                padding: padding,
                child: Text("${islem.kdv} ($kdv TL)"),
              ),
              Container(padding: padding, child: Text("$kdvsiz TL")),
              Container(padding: padding, child: Text("$kdvli TL")),
            ],
          ),
        );
      }
    }

    if (mounted) {
      setState(() {
        kdvsizToplam = kdvsizToplamTemp;
        kdvToplam = kdvToplamTemp;
        fiyatlar = fiyatlarTemp;
        detaylarYukleniyor = false;
      });
    } else {
      kdvsizToplam = kdvsizToplamTemp;
      kdvToplam = kdvToplamTemp;
      fiyatlar = fiyatlarTemp;
      detaylarYukleniyor = false;
    }
  }

  Future<void> _fiyatBilgisiPaylas() async {
    if (kdvsizToplam > 0) {
      double yeniKDV = kdvToplam > 0 ? kdvToplam : (kdvsizToplam / 100) * 20;
      double genelToplam = kdvsizToplam + yeniKDV;
      ShareResult shareResult = await Share.share(
        "Fiyat ${_fiyatDuzelt(kdvsizToplam)} TL. Fatura istiyorsanız + ${_fiyatDuzelt(yeniKDV)} TL KDV. Toplam ${_fiyatDuzelt(genelToplam)} TL",
      );
      if (shareResult.status == ShareResultStatus.success) {
        debugPrint("Paylaşıldı");
      }
    } else {
      showDialog(
        context: context,
        builder: (context) {
          return AlertDialog(
            title: Text("Fiyat Bilgisi Girilmemiş"),
            content: Text("Fiyat bilgisi girilmediği için paylaşamazsınız."),
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
  }

  String _fiyatDuzelt(double n) {
    return n.toStringAsFixed(n.truncateToDouble() == n ? 0 : 2);
  }

  Future<void> _ara() async {
    String telefon = telefonNumarasi();

    if (telefonGecerli(telefon)) {
      launchUrlString("tel://$telefon");
    } else {
      _gecersizTelefonDialog();
    }
  }

  Future<void> _kisiEkle() async {
    await _kisiKontrol();
  }

  Future<void> _kisiDuzenle() async {
    await _kisiKontrol(duzenle: true);
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
  _yukleniyorGoster() {
    if (!yukleniyorGosterildi) {
      setState(() {
        yukleniyorGosterildi = true;
      });
      yukleniyor(context);
    }
  }

  _yukleniyorGizle() {
    if (yukleniyorGosterildi) {
      setState(() {
        yukleniyorGosterildi = false;
      });
      Navigator.pop(context);
    }
  }

  Future<void> _kisiKontrol({bool duzenle = false}) async {
    String telefon = telefonNumarasi();
    if (telefonGecerli(telefon)) {
      _yukleniyorGoster();
      if (await Permission.contacts.isPermanentlyDenied) {
        _yukleniyorGizle();
        kisiIzniUyari();
        return;
      }
      if (await Permission.contacts.request().isGranted) {
        Phone phone = Phone(telefon);
        List<Contact> contacts = await FlutterContacts.getContacts(
          sorted: false,
          deduplicateProperties: false,
          withProperties: true,
        );
        contacts =
            contacts.where((c) {
              List<Phone> p =
                  c.phones.where((p) => p.number == phone.number).toList();
              return p.isNotEmpty;
            }).toList();
        Contact? contact;
        if (contacts.isEmpty) {
          Contact contactTemp = Contact(
            displayName: cihaz!.musteriAdi.trim(),
            name: Name(first: cihaz!.musteriAdi.trim()),
            phones: [phone],
          );
          contact = await contactTemp.insert();
          if (!duzenle) {
            _yukleniyorGizle();
            showNotification(body: "Müşteri rehbere kaydedildi");
          }
        }
        if (contacts.isNotEmpty) {
          if (duzenle) {
            contact = contacts.first;
          } else {
            _yukleniyorGizle();
            showNotification(body: "Müşteri kaydı zaten mevcut");
          }
        }
        if (duzenle && contact != null) {
          _yukleniyorGizle();
          await FlutterContacts.openExternalEdit(contact.id);
          showNotification(body: "Müşteri düzenleme tamamlandı");
        }
      } else {
        _yukleniyorGizle();
        kisiIzniUyari();
        return;
      }
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
                                Row(
                                  mainAxisSize: MainAxisSize.max,
                                  mainAxisAlignment: MainAxisAlignment.center,
                                  children: [
                                    IconButton(
                                      onPressed: () async {
                                        await _kisiDuzenle();
                                      },
                                      icon: Icon(Icons.edit),
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
                    Builder(
                      builder: (context) {
                        EdgeInsetsGeometry padding = EdgeInsets.all(1);
                        double genelToplam = kdvsizToplam + kdvToplam;
                        return Column(
                          children: [
                            Table(
                              border: tableBorder,
                              children: [
                                TableRow(
                                  children: [
                                    Container(
                                      padding: padding,
                                      child: Text(
                                        "Malzeme/İşçilik",
                                        style: TextStyle(
                                          fontWeight: FontWeight.bold,
                                        ),
                                      ),
                                    ),
                                    Container(
                                      padding: padding,
                                      child: Text(
                                        "Miktar",
                                        style: TextStyle(
                                          fontWeight: FontWeight.bold,
                                        ),
                                      ),
                                    ),
                                    Container(
                                      padding: padding,
                                      child: Text(
                                        "Birim Fiyatı",
                                        style: TextStyle(
                                          fontWeight: FontWeight.bold,
                                        ),
                                      ),
                                    ),
                                    Container(
                                      padding: padding,
                                      child: Text(
                                        "KDV",
                                        style: TextStyle(
                                          fontWeight: FontWeight.bold,
                                        ),
                                      ),
                                    ),
                                    Container(
                                      padding: padding,
                                      child: Text(
                                        "Tutar (KDV'siz)",
                                        style: TextStyle(
                                          fontWeight: FontWeight.bold,
                                        ),
                                      ),
                                    ),
                                    Container(
                                      padding: padding,
                                      child: Text(
                                        "Toplam",
                                        style: TextStyle(
                                          fontWeight: FontWeight.bold,
                                        ),
                                      ),
                                    ),
                                  ],
                                ),
                                ...fiyatlar,
                              ],
                            ),
                            if (fiyatlar.isEmpty)
                              Container(
                                padding: EdgeInsets.only(top: 5),
                                width: MediaQuery.of(context).size.width,
                                child: Text(
                                  "Şuanda yapılmış bir işlem yok.",
                                  textAlign: TextAlign.center,
                                ),
                              ),
                            Container(
                              padding: EdgeInsets.only(top: 10),
                              child: Table(
                                border: tableBorder,
                                children: [
                                  TableRow(
                                    children: [
                                      Text(
                                        "Toplam:",
                                        style: TextStyle(
                                          fontWeight: FontWeight.bold,
                                        ),
                                      ),
                                      Text("$kdvsizToplam TL"),
                                    ],
                                  ),
                                  TableRow(
                                    children: [
                                      Text(
                                        "KDV:",
                                        style: TextStyle(
                                          fontWeight: FontWeight.bold,
                                        ),
                                      ),
                                      Text("$kdvToplam TL"),
                                    ],
                                  ),
                                  TableRow(
                                    children: [
                                      Text(
                                        "Genel Toplam:",
                                        style: TextStyle(
                                          fontWeight: FontWeight.bold,
                                        ),
                                      ),
                                      Row(
                                        children: [
                                          Text("$genelToplam TL"),
                                          SizedBox(width: 2),
                                          IconButton(
                                            onPressed: () async {
                                              await _fiyatBilgisiPaylas();
                                            },
                                            icon: Icon(Icons.share),
                                          ),
                                        ],
                                      ),
                                    ],
                                  ),
                                ],
                              ),
                            ),
                          ],
                        );
                      },
                    ),
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
