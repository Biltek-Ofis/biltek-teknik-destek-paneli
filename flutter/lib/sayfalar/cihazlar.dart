import 'dart:async';

import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutter_keyboard_visibility/flutter_keyboard_visibility.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:provider/provider.dart';
import 'package:simple_barcode_scanner/simple_barcode_scanner.dart';

import '../ayarlar.dart';
import '../models/cihaz.dart';
import '../models/kullanici.dart';
import '../sayfalar/detaylar/detaylar.dart';
import '../utils/assets.dart';
import '../utils/barkod_okuyucu.dart';
import '../utils/buttons.dart';
import '../utils/islemler.dart';
import '../utils/my_notifier.dart';
import '../utils/post.dart';
import '../utils/shared_preferences.dart';
import 'anasayfa.dart';
import 'ayarlar/ayarlar.dart';
import 'cihazlarim.dart';
import 'lisans/lisans.dart';
import 'lisans/versiyon.dart';
import 'yeni_cihaz.dart';

typedef AramaDurumu = Function(bool durum);
typedef AramaText = Function(String value);

class CihazlarSayfasi extends StatefulWidget {
  const CihazlarSayfasi({
    super.key,
    required this.kullanici,
    required this.seciliSayfa,
    this.sorumlu,
  });
  final KullaniciAuthModel kullanici;
  final String seciliSayfa;
  final int? sorumlu;

  @override
  State<CihazlarSayfasi> createState() => _CihazlarSayfasiState();
}

class _CihazlarSayfasiState extends State<CihazlarSayfasi> {
  FocusNode searchbarFocus = FocusNode();

  String arama = "";

  List<Cihaz>? cihazlar;

  ScrollController scrollController = ScrollController();
  int suankiIndex = 0;

  bool aramaEtkin = false;

  AramaAppBar? aramaAppBar;

  bool yukariKaydir = false;

  StreamSubscription<String>? fcmStream;

  BarkodOkuyucu? barkodOkuyucu;

  StreamSubscription<bool>? keyboardSubscription;
  bool klavyeAcik = false;

  @override
  void initState() {
    Future.delayed(Duration.zero, () async {
      await FirebaseMessaging.instance.requestPermission(provisional: true);
      fcmStream =
          FirebaseMessaging.instance.onTokenRefresh.listen((fcmToken) async {
        BiltekPost.fcmTokenGuncelle(widget.kullanici.auth, fcmToken);
      });
      fcmStream?.onError((err) {
        debugPrint("Failed to get fcm token");
      });
      String? token = await FirebaseMessaging.instance.getToken();

      BiltekPost.fcmTokenGuncelle(widget.kullanici.auth, token);

      await pcYenile();
    });
    scrollController.addListener(() async {
      if (scrollController.position.pixels > 50) {
        setState(() {
          yukariKaydir = true;
        });
      } else {
        setState(() {
          yukariKaydir = false;
        });
      }
      if (scrollController.position.pixels ==
          scrollController.position.maxScrollExtent) {
        debugPrint("Max scroll");
        setState(() {
          suankiIndex += 1;
        });
        await _cihazlariYenile(
          sifirla: false,
        );
      }
    });
    Future.delayed(Duration.zero, () async {
      await _cihazlariYenile();
    });
    super.initState();
    var keyboardVisibilityController = KeyboardVisibilityController();

    keyboardSubscription =
        keyboardVisibilityController.onChange.listen((bool visible) {
      setState(() {
        klavyeAcik = visible;
      });
      debugPrint("Klavye Durumu: $visible");
      if (!visible) {
        _aramaDurumuDuzenle(false);
      }
    });
  }

  @override
  void dispose() {
    keyboardSubscription?.cancel();
    scrollController.dispose();
    fcmStream?.cancel();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    aramaAppBar = AramaAppBar(
      searchbarFocus: searchbarFocus,
      aramaText: (value) async {
        setState(() {
          arama = value;
        });
        await _cihazlariYenile();
      },
      aramaDurumu: (durum) {
        _aramaDurumuDuzenle(durum);
      },
    );
    return PopScope(
      canPop: false,
      onPopInvokedWithResult: (didPop, result) async {
        if (didPop) {
          return;
        }
        bool kapat = true;
        if (aramaEtkin) {
          _aramaDurumuDuzenle(false);
          kapat = false;
          await _cihazlariYenile();
        }

        if (kapat) {
          SystemChannels.platform.invokeMethod('SystemNavigator.pop');
          //Navigator.of(context).pop(result);
        }
      },
      child: Consumer<MyNotifier>(
          builder: (context, MyNotifier myNotifier, child) {
        return Scaffold(
          drawer: aramaEtkin
              ? null
              : biltekDrawer(
                  context,
                  kullanici: widget.kullanici,
                  seciliSayfa: widget.seciliSayfa,
                ),
          appBar: aramaEtkin
              ? AppBar(
                  flexibleSpace: aramaAppBar,
                )
              : AppBar(
                  automaticallyImplyLeading: false,
                  title: Text(
                      "Biltek Teknik Servis${(widget.seciliSayfa != "Anasayfa" ? " - ${widget.seciliSayfa}" : "")}"),
                ),
          resizeToAvoidBottomInset: false,
          bottomNavigationBar: klavyeAcik
              ? null
              : biltekBottomNavigationBar(
                  context,
                  kullanici: widget.kullanici,
                  seciliSayfa: widget.seciliSayfa,
                  cihazlariYenile: () async {
                    await _cihazlariYenile();
                  },
                  pcYenile: () async {
                    await pcYenile();
                  },
                  aramaDurumu: (durum) {
                    _aramaDurumuDuzenle(durum);
                  },
                ),
          floatingActionButtonLocation:
              FloatingActionButtonLocation.centerDocked,
          extendBody: true,
          floatingActionButton: klavyeAcik
              ? null
              : FloatingActionButton(
                  shape: const CircleBorder(),
                  onPressed: () {
                    if (yukariKaydir) {
                      scrollController.animateTo(
                        0,
                        duration: Duration(seconds: 1),
                        curve: Curves.bounceIn,
                      );
                    } else {
                      Navigator.push(
                        context,
                        MaterialPageRoute(
                          builder: (context) => YeniCihazSayfasi(
                            cihazlariYenile: () async {
                              await _cihazlariYenile();
                            },
                          ),
                        ),
                      );
                    }
                  },
                  child: Icon(
                    yukariKaydir ? Icons.arrow_upward : Icons.add,
                    color: Colors.white,
                  ),
                ),
          body: Container(
            decoration: BoxDecoration(
              color: Colors.white,
            ),
            width: MediaQuery.of(context).size.width,
            child: cihazlar == null
                ? Center(
                    child: CircularProgressIndicator(),
                  )
                : RefreshIndicator(
                    onRefresh: () async {
                      setState(() {
                        arama = "";
                      });
                      await _cihazlariYenile();
                    },
                    child: ListView.builder(
                      itemCount: cihazlar!.length,
                      controller: scrollController,
                      physics: AlwaysScrollableScrollPhysics(),
                      itemBuilder: (context, index) {
                        Cihaz cihaz = cihazlar![index];
                        Color? renkTemp =
                            Islemler.yaziRengi(cihaz.guncelDurumRenk);
                        return Container(
                          decoration: BoxDecoration(
                            color: Islemler.arkaRenk(cihaz.guncelDurumRenk),
                            border: Border.all(color: Colors.black, width: 1),
                          ),
                          child: ListTile(
                            textColor: renkTemp,
                            title: RichText(
                              text: TextSpan(
                                children: <TextSpan>[
                                  TextSpan(
                                    text: "\nServis No: ",
                                    style: TextStyle(
                                      fontWeight: FontWeight.bold,
                                      color: renkTemp,
                                    ),
                                  ),
                                  TextSpan(
                                    text: cihaz.servisNo.toString(),
                                    style: TextStyle(
                                      color: renkTemp,
                                    ),
                                  ),
                                  TextSpan(
                                    text: "\nMüşteri Adı: ",
                                    style: TextStyle(
                                      fontWeight: FontWeight.bold,
                                      color: renkTemp,
                                    ),
                                  ),
                                  TextSpan(
                                    text: cihaz.musteriAdi,
                                    style: TextStyle(
                                      color: renkTemp,
                                    ),
                                  ),
                                  TextSpan(
                                    text: "\nCihaz Tür: ",
                                    style: TextStyle(
                                      fontWeight: FontWeight.bold,
                                      color: renkTemp,
                                    ),
                                  ),
                                  TextSpan(
                                    text: cihaz.cihazTuru,
                                    style: TextStyle(
                                      color: renkTemp,
                                    ),
                                  ),
                                  if (widget.sorumlu == null)
                                    TextSpan(
                                      text: "\nSorumlu: ",
                                      style: TextStyle(
                                        fontWeight: FontWeight.bold,
                                        color: renkTemp,
                                      ),
                                    ),
                                  if (widget.sorumlu == null)
                                    TextSpan(
                                      text: cihaz.sorumlu,
                                      style: TextStyle(
                                        color: renkTemp,
                                      ),
                                    ),
                                  TextSpan(
                                    text: "\nCihaz: ",
                                    style: TextStyle(
                                      fontWeight: FontWeight.bold,
                                      color: renkTemp,
                                    ),
                                  ),
                                  TextSpan(
                                    text:
                                        "${cihaz.cihaz}${(cihaz.cihazModeli.isNotEmpty ? " ${cihaz.cihazModeli}" : "")}",
                                    style: TextStyle(
                                      color: renkTemp,
                                    ),
                                  ),
                                  TextSpan(
                                    text: "\nGiriş Tarihi: ",
                                    style: TextStyle(
                                      fontWeight: FontWeight.bold,
                                      color: renkTemp,
                                    ),
                                  ),
                                  TextSpan(
                                    text: cihaz.tarih,
                                    style: TextStyle(
                                      color: renkTemp,
                                    ),
                                  ),
                                ],
                              ),
                            ),
                            subtitle: Text(cihaz.guncelDurumText.toString()),
                            trailing: DefaultButton(
                              onPressed: () {
                                Navigator.of(context).push(MaterialPageRoute(
                                  builder: (context) => DetaylarSayfasi(
                                    kullanici: widget.kullanici,
                                    servisNo: cihaz.servisNo,
                                    cihazlariYenile: () async {
                                      await _cihazlariYenile();
                                    },
                                  ),
                                ));
                              },
                              text: "Detaylar",
                            ),
                          ),
                        );
                      },
                    ),
                  ),
          ),
        );
      }),
    );
  }

  Future<void> _cihazlariYenile({
    bool sifirla = true,
  }) async {
    if (sifirla) {
      setState(() {
        suankiIndex = 0;
      });
    }
    List<Cihaz> cihazlarTemp = await BiltekPost.cihazlariGetir(
      sorumlu: widget.sorumlu,
      arama: arama.isNotEmpty ? arama : null,
      offset: suankiIndex * 50,
    );
    if (mounted) {
      setState(() {
        if (sifirla) {
          cihazlar = cihazlarTemp;
        } else {
          cihazlar ??= [];
          cihazlar?.addAll(cihazlarTemp);
        }
      });
    } else {
      if (sifirla) {
        cihazlar = cihazlarTemp;
      } else {
        cihazlar ??= [];
        cihazlar?.addAll(cihazlarTemp);
      }
    }
  }

  Future<void> pcYenile() async {
    BarkodOkuyucu? barkodOkuyucuTemp = await BarkodOkuyucu.getir();
    if (mounted) {
      setState(() {
        barkodOkuyucu = barkodOkuyucuTemp;
      });
    } else {
      barkodOkuyucu = barkodOkuyucuTemp;
    }
  }

  void _aramaDurumuDuzenle(bool durum) async {
    setState(() {
      aramaEtkin = durum;
    });
    if (durum) {
      Future.delayed(Duration(milliseconds: 100), () {
        if (mounted) {
          FocusScopeNode focusScopeNode = FocusScope.of(context);
          if (focusScopeNode.hasFocus) {
            SystemChannels.textInput.invokeMethod("TextInput.show");
          }
          focusScopeNode.requestFocus(aramaAppBar?.searchbarFocus);
        }
      });
    } else {
      setState(() {
        arama = "";
      });
      await _cihazlariYenile();
    }
  }
}

class ServisNo {
  BuildContext context;
  ServisNo._(this.context);

  factory ServisNo.of(BuildContext context) {
    return ServisNo._(context);
  }

  Future<void> ac({
    required int servisNo,
    required KullaniciAuthModel kullanici,
    required VoidCallback cihazlariYenile,
    bool bilgisayardaAc = true,
  }) async {
    NavigatorState navigatorState = Navigator.of(context);

    if (bilgisayardaAc) {
      await BiltekPost.bilgisayardaAc(
        kullaniciID: kullanici.id,
        servisNo: servisNo,
      );
    }
    navigatorState.push(
      MaterialPageRoute(
        builder: (context) => DetaylarSayfasi(
          kullanici: kullanici,
          servisNo: servisNo,
          cihazlariYenile: () {
            cihazlariYenile.call();
          },
        ),
      ),
    );
    if (bilgisayardaAc) {
      BarkodOkuyucu? barkodOkuyucu = await BarkodOkuyucu.getir();
      await barkodOkuyucu?.servisNo(servisNo);
    }
  }
}

void barkodGecersiz(BuildContext context) {
  showDialog(
    context: context,
    builder: (context) {
      return AlertDialog(
        title: Text("QR/Barkod Geçersiz"),
        content: Text("Taranan QR/Barkod geçersiz."),
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

class AramaAppBar extends StatefulWidget {
  const AramaAppBar({
    super.key,
    required this.searchbarFocus,
    required this.aramaText,
    required this.aramaDurumu,
  });

  final FocusNode searchbarFocus;
  final AramaText aramaText;
  final AramaDurumu aramaDurumu;

  @override
  State<AramaAppBar> createState() => _AramaAppBarState();
}

class _AramaAppBarState extends State<AramaAppBar> {
  @override
  Widget build(BuildContext context) {
    return SafeArea(
      child: Builder(
        builder: (context) {
          WidgetStateProperty<Color?>? color =
              WidgetStateProperty.resolveWith<Color?>(
            (Set<WidgetState> states) {
              return Colors.transparent; // Use the component's default.
            },
          );
          Color textColor = Colors.white;
          return SearchBar(
            focusNode: widget.searchbarFocus,
            textInputAction: TextInputAction.search,
            padding: const WidgetStatePropertyAll<EdgeInsets>(
                EdgeInsets.symmetric(horizontal: 16.0)),
            backgroundColor: color,
            shadowColor: color,
            overlayColor: color,
            surfaceTintColor: color,
            hintText: "Cihaz Ara...",
            hintStyle: WidgetStateProperty.resolveWith<TextStyle?>(
              (Set<WidgetState> states) {
                return TextStyle(
                  color: textColor.withAlpha(150),
                );
              },
            ),
            textStyle: WidgetStateProperty.resolveWith<TextStyle?>(
              (Set<WidgetState> states) {
                return TextStyle(
                  color: textColor,
                );
              },
            ),
            onTap: () {
              ////controller.openView();
            },
            onChanged: (value) {
              widget.aramaText.call(value);
            },
            leading: IconButton(
              onPressed: () {
                widget.aramaDurumu.call(false);
              },
              color: Colors.white,
              icon: Icon(Icons.arrow_back),
            ),
            trailing: <Widget>[],
          );
        },
      ),
    );
  }
}

Drawer biltekDrawer(
  BuildContext context, {
  required KullaniciAuthModel kullanici,
  String seciliSayfa = "",
}) {
  EdgeInsetsGeometry titlePadding =
      EdgeInsets.symmetric(vertical: 0, horizontal: 8);
  EdgeInsetsGeometry linkPadding =
      EdgeInsets.symmetric(vertical: 0, horizontal: 6);
  return Drawer(
    child: ListView(
      padding: EdgeInsets.zero,
      children: [
        DrawerHeader(
          child: Image.asset(BiltekAssets.logo),
        ),
        SizedBox(
          height: 5,
        ),
        SizedBox(
          width: MediaQuery.of(context).size.width,
          child: Container(
            alignment: Alignment.topCenter,
            child: Text(kullanici.adSoyad),
          ),
        ),
        SizedBox(
          height: 5,
        ),
        if (kullanici.yonetici && Ayarlar.lisansEtkin)
          ListTile(
            contentPadding: titlePadding,
            title: const Text(
              "Teknik Servis",
              style: TextStyle(fontWeight: FontWeight.bold),
            ),
          ),
        ListTile(
          contentPadding: linkPadding,
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
            contentPadding: linkPadding,
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
        if (kullanici.yonetici && Ayarlar.lisansEtkin)
          ListTile(
            contentPadding: titlePadding,
            title: const Text(
              "Lisanslar",
              style: TextStyle(fontWeight: FontWeight.bold),
            ),
          ),
        if (kullanici.yonetici && Ayarlar.lisansEtkin)
          ListTile(
            contentPadding: linkPadding,
            title: const Text("Lisansları Yönet"),
            selected: seciliSayfa == "Lisanslar",
            onTap: seciliSayfa != "Lisanslar"
                ? () {
                    Navigator.pop(context);
                    Navigator.of(context).pushAndRemoveUntil(
                      MaterialPageRoute(
                        builder: (context) => LisansSayfasi(
                          kullanici: kullanici,
                        ),
                      ),
                      (route) => false,
                    );
                  }
                : null,
          ),
        if (kullanici.yonetici && Ayarlar.lisansEtkin)
          ListTile(
            contentPadding: linkPadding,
            title: const Text("Versiyonları Yönet"),
            selected: seciliSayfa == "Versiyonlar",
            onTap: seciliSayfa != "Versiyonlar"
                ? () {
                    Navigator.pop(context);
                    Navigator.of(context).pushAndRemoveUntil(
                      MaterialPageRoute(
                        builder: (context) => VersiyonSayfasi(
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

BottomAppBar biltekBottomNavigationBar(
  BuildContext context, {
  required KullaniciAuthModel kullanici,
  required VoidCallback cihazlariYenile,
  required VoidCallback pcYenile,
  required AramaDurumu aramaDurumu,
  String seciliSayfa = "",
}) {
  double iconSize = 20;
  double textSize = 10;
  return BottomAppBar(
    padding: const EdgeInsets.symmetric(horizontal: 10),
    height: 50,
    color: Theme.of(context).appBarTheme.backgroundColor,
    shape: const CircularNotchedRectangle(),
    notchMargin: 5,
    child: Builder(
      builder: (context) {
        return Row(
          mainAxisSize: MainAxisSize.max,
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          children: [
            InkWell(
              child: Padding(
                padding: const EdgeInsets.all(8.0),
                child: Column(
                  children: [
                    Icon(
                      Icons.menu,
                      color: Colors.white,
                      size: iconSize,
                    ),
                    Text(
                      "Menü",
                      style: GoogleFonts.dynaPuff(
                        color: Colors.white,
                        fontSize: textSize,
                      ),
                    ),
                  ],
                ),
              ),
              onTap: () {
                Scaffold.of(context).openDrawer();
              },
            ),
            InkWell(
              child: Padding(
                padding: const EdgeInsets.all(8.0),
                child: Column(
                  children: [
                    Icon(
                      Icons.qr_code,
                      color: Colors.white,
                      size: iconSize,
                    ),
                    Text(
                      "Barkod Tara",
                      style: GoogleFonts.dynaPuff(
                        color: Colors.white,
                        fontSize: textSize,
                      ),
                    ),
                  ],
                ),
              ),
              onTap: () async {
                await barkodTara(
                  context,
                  kullanici: kullanici,
                  cihazlariYenile: cihazlariYenile,
                  pcYenile: pcYenile,
                );
              },
            ),
            InkWell(
              child: Padding(
                padding: const EdgeInsets.all(8.0),
                child: Column(
                  children: [
                    Icon(
                      Icons.search,
                      color: Colors.white,
                      size: iconSize,
                    ),
                    Text(
                      "Cihaz Ara",
                      style: GoogleFonts.dynaPuff(
                        color: Colors.white,
                        fontSize: textSize,
                      ),
                    ),
                  ],
                ),
              ),
              onTap: () {
                aramaDurumu.call(true);
              },
            ),
            InkWell(
              child: Padding(
                padding: const EdgeInsets.all(8.0),
                child: Column(
                  children: [
                    Icon(
                      Icons.settings,
                      color: Colors.white,
                      size: iconSize,
                    ),
                    Text(
                      "Ayarlar",
                      style: GoogleFonts.dynaPuff(
                        color: Colors.white,
                        fontSize: textSize,
                      ),
                    ),
                  ],
                ),
              ),
              onTap: () {
                Navigator.of(context).push(
                  MaterialPageRoute(
                    builder: (context) => AyarlarSayfasi(pcYenile: pcYenile),
                  ),
                );
              },
            ),
          ],
        );
      },
    ),
  );
}

Future<void> barkodTara(
  BuildContext context, {
  required KullaniciAuthModel kullanici,
  required VoidCallback cihazlariYenile,
  required VoidCallback pcYenile,
}) async {
  ServisNo servisNoCls = ServisNo.of(context);
  String? res = await SimpleBarcodeScanner.scanBarcode(
    context,
    barcodeAppBar: const BarcodeAppBar(
      appBarTitle: 'Barkod Tara',
      centerTitle: false,
      enableBackButton: true,
      backButtonIcon: Icon(Icons.arrow_back_ios),
    ),
    cancelButtonText: "İptal",
    isShowFlashIcon: true,
    delayMillis: 2000,
    cameraFace: CameraFace.back,
  );
  if (res != null && res.isNotEmpty && res != "-1" && res.startsWith("20")) {
    try {
      int servisNo = int.parse(res);
      await servisNoCls.ac(
        servisNo: servisNo,
        kullanici: kullanici,
        cihazlariYenile: cihazlariYenile,
      );
    } on Exception catch (e) {
      debugPrint(e.toString());
      if (context.mounted) {
        barkodGecersiz(context);
      }
    }
  } else if (res != null &&
      res.isNotEmpty &&
      res != "-1" &&
      res.split(":").length == 2) {
    var splt = res.split(":");
    switch (splt[0]) {
      case "servisNo":
        try {
          int servisNo = int.parse(splt[1]);
          await servisNoCls.ac(
            servisNo: servisNo,
            kullanici: kullanici,
            cihazlariYenile: cihazlariYenile,
            bilgisayardaAc: false,
          );
        } on Exception catch (e) {
          debugPrint(e.toString());
          if (context.mounted) {
            barkodGecersiz(context);
          }
        }
        break;
      default:
        if ('.'.allMatches(splt[0]).length == 3) {
          try {
            await SharedPreference.setString(
                SharedPreference.barkodIP, splt[0]);
            await SharedPreference.setInt(
                SharedPreference.barkodPort, int.parse(splt[1]));
            pcYenile.call();
            if (context.mounted) {
              showDialog(
                context: context,
                builder: (context) {
                  return AlertDialog(
                    title: Text("Eşleştirme"),
                    content: Text(
                        "Windows uygulamasında yeşil onay resmi görüyorsanız işlem başarılı demektir."),
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
            BarkodOkuyucu? barkodOkuyucu = await BarkodOkuyucu.getir();
            await barkodOkuyucu?.eslestir();
          } on Exception catch (e) {
            debugPrint(e.toString());
            if (context.mounted) {
              barkodGecersiz(context);
            }
          }
        } else {
          if (context.mounted) {
            barkodGecersiz(context);
          }
        }
        break;
    }
  } else {
    if (context.mounted) {
      barkodGecersiz(context);
    }
  }
  /*if (kDebugMode) {
            int servisNo2 = 2025000007;
            await BiltekPost.bilgisayardaAc(
              kullaniciID: kullanici.id,
              servisNo: servisNo2,
            );
            await Islemler.barkodOkuyucuAc(servisNo2.toString());
          }*/
}
