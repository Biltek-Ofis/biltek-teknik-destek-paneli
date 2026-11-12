import 'dart:async';

import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:provider/provider.dart';

import '../../models/kullanici.dart';
import '../../models/malzeme_teslimi_model.dart';
import '../../utils/buttons.dart';
import '../../utils/common.dart';
import '../../utils/islemler.dart';
import '../../utils/my_notifier.dart';
import '../../utils/post.dart';
import '../../widgets/dizayn.dart';
import '../../widgets/navigators.dart';
import '../ayarlar/ayarlar.dart';
import '../cihazlar.dart';

typedef AramaDurumu = Function(bool durum);
typedef AramaText = Function(String value);

class MalzemeTeslimiSayfasi extends StatefulWidget {
  const MalzemeTeslimiSayfasi({
    super.key,
    required this.kullanici,
    required this.seciliSayfa,
  });
  final KullaniciAuthModel kullanici;
  final String seciliSayfa;

  @override
  State<MalzemeTeslimiSayfasi> createState() => _MalzemeTeslimiSayfasiState();
}

class _MalzemeTeslimiSayfasiState extends State<MalzemeTeslimiSayfasi> {
  List<MalzemeTeslimiModel>? malzemeTeslimleri;

  ScrollController scrollController = ScrollController();
  bool malzemeTeslimleriYukleniyor = false;
  int suankiIndex = 0;
  int suankiIndexTemp = 0;

  bool yukariKaydir = false;

  final GlobalKey<ScaffoldState> scaffoldKey = GlobalKey<ScaffoldState>();
  @override
  void initState() {
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
      if (!malzemeTeslimleriYukleniyor &&
          scrollController.position.pixels ==
              scrollController.position.maxScrollExtent) {
        try {
          biltekPrint("Max scroll");
          setState(() {
            malzemeTeslimleriYukleniyor = true;
            suankiIndex += 1;
          });
          await _malzemeTeslimleriiYenile(sifirla: false);
          setState(() {
            malzemeTeslimleriYukleniyor = false;
            suankiIndexTemp = suankiIndex;
          });
        } on Exception catch (e) {
          if (suankiIndex != suankiIndexTemp) {
            suankiIndex = suankiIndexTemp;
          }
          setState(() {
            malzemeTeslimleriYukleniyor = false;
          });
          biltekPrint(e.toString());
        }
      }
    });
    Future.delayed(Duration.zero, () async {
      await _malzemeTeslimleriiYenile();
    });
    super.initState();
  }

  @override
  void dispose() {
    scrollController.dispose();
    super.dispose();
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
      child: Consumer<MyNotifier>(
        builder: (context, MyNotifier myNotifier, child) {
          return Scaffold(
            key: scaffoldKey,
            drawer: biltekDrawer(
              context,
              kullanici: widget.kullanici,
              seciliSayfa: widget.seciliSayfa,
            ),
            appBar: AppBar(
              automaticallyImplyLeading: false,
              title: Text("Malzeme Teslimi"),
            ),
            resizeToAvoidBottomInset: false,
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
              selectedItemColor: Theme.of(context).appBarTheme.iconTheme?.color,
              onTap: (index) async {
                biltekPrint("Index: $index");
                switch (index) {
                  case 0:
                    scaffoldKey.currentState?.openDrawer();
                    break;
                  case 3:
                    Navigator.of(context).push(
                      MaterialPageRoute(
                        builder: (context) => AyarlarSayfasi(
                          pcYenile: () {},
                          kullanici: widget.kullanici,
                        ),
                      ),
                    );
                    break;
                }
              },
            ),
            floatingActionButtonLocation:
                FloatingActionButtonLocation.centerDocked,
            extendBody: true,
            floatingActionButton: FloatingActionButton(
              shape: const CircleBorder(),
              onPressed: () {
                if (yukariKaydir) {
                  scrollController.animateTo(
                    0,
                    duration: Duration(seconds: 1),
                    curve: Curves.bounceIn,
                  );
                } else {
                  // TODO: Yeni Malzeme Teslimi Sayfası
                  /*Navigator.push(
                    context,
                    MaterialPageRoute(
                      builder:
                          (context) => YeniCihazSayfasi(
                            malzemeTeslimleriiYenile: () async {
                              await _malzemeTeslimleriiYenile();
                            },
                          ),
                    ),
                  );*/
                }
              },
              backgroundColor: Theme.of(context).appBarTheme.backgroundColor,
              child: Icon(
                yukariKaydir ? CupertinoIcons.arrow_up : CupertinoIcons.add,
                color:
                    Theme.of(context).appBarTheme.iconTheme?.color ??
                    Colors.white,
              ),
            ),
            body: SafeArea(
              child: Container(
                decoration: BoxDecoration(color: Colors.white),
                width: MediaQuery.of(context).size.width,
                child: malzemeTeslimleri == null
                    ? Center(child: CircularProgressIndicator())
                    : RefreshIndicator(
                        onRefresh: () async {
                          await _malzemeTeslimleriiYenile();
                        },
                        child: ListView.builder(
                          itemCount: malzemeTeslimleri!.length,
                          controller: scrollController,
                          physics: AlwaysScrollableScrollPhysics(),
                          itemBuilder: (context, index) {
                            MalzemeTeslimiModel malzemeTeslimi =
                                malzemeTeslimleri![index];
                            String renkStr = malzemeTeslimi.odendi
                                ? "bg-success"
                                : "bg-danger";
                            Color? renkTemp = Islemler.yaziRengi(renkStr);
                            return SectionCard(
                              darkTheme: false,
                              backgroundColor: Islemler.arkaRenk(renkStr),
                              padding: EdgeInsets.symmetric(
                                vertical: 0,
                                horizontal: 0,
                              ),
                              children: [
                                ListTile(
                                  title: Column(
                                    crossAxisAlignment:
                                        CrossAxisAlignment.start,
                                    mainAxisAlignment: MainAxisAlignment.start,
                                    children: [
                                      InfoTileList(
                                        label: "No",
                                        value: malzemeTeslimi.teslimNo
                                            .toString(),
                                        textColor: renkTemp,
                                      ),
                                      InfoTileList(
                                        label: "Firma",
                                        value: malzemeTeslimi.firma,
                                        textColor: renkTemp,
                                      ),
                                      InfoTileList(
                                        label: "Sipariş Tarihi",
                                        value: malzemeTeslimi.siparisTarihi,
                                        textColor: renkTemp,
                                      ),
                                      InfoTileList(
                                        label: "Teslim Tarihi",
                                        value: malzemeTeslimi.teslimTarihi,
                                        textColor: renkTemp,
                                      ),
                                      InfoTileList(
                                        label: "Vade Tarihi",
                                        value: malzemeTeslimi.vadeTarihi,
                                        textColor: renkTemp,
                                      ),
                                      InfoTileList(
                                        label: "Ödeme Durumu",
                                        value: malzemeTeslimi.vadeStr,
                                        textColor: renkTemp,
                                      ),
                                    ],
                                  ),
                                  trailing: PrimaryButton(
                                    width: 40,
                                    height: 40,
                                    onPressed: () {
                                      // TODO: Detaylar sayfası
                                      /*
                                        Navigator.of(context).push(
                                          MaterialPageRoute(
                                            builder:
                                                (context) => DetaylarSayfasi(
                                                  kullanici: widget.kullanici,
                                                  no: cihaz.servisNo,
                                                  malzemeTeslimleriiYenile:
                                                      () async {
                                                        await _malzemeTeslimleriiYenile();
                                                      },
                                                ),
                                          ),
                                        );
                                        */
                                    },
                                    icon: Icons.list_alt,
                                  ),
                                ),
                              ],
                            );
                          },
                        ),
                      ),
              ),
            ),
          );
        },
      ),
    );
  }

  Future<void> _malzemeTeslimleriiYenile({bool sifirla = true}) async {
    if (sifirla) {
      setState(() {
        suankiIndex = 0;
        suankiIndexTemp = 0;
      });
    }
    List<MalzemeTeslimiModel> malzemeTeslimleriTemp = await BiltekPost.of(
      widget.kullanici.auth,
    ).malzemeTeslimleriGetir(arama: null, offset: suankiIndex * 50);
    if (mounted) {
      setState(() {
        if (sifirla) {
          malzemeTeslimleri = malzemeTeslimleriTemp;
        } else {
          malzemeTeslimleri ??= [];
          malzemeTeslimleri?.addAll(malzemeTeslimleriTemp);
        }
      });
    } else {
      if (sifirla) {
        malzemeTeslimleri = malzemeTeslimleriTemp;
      } else {
        malzemeTeslimleri ??= [];
        malzemeTeslimleri?.addAll(malzemeTeslimleriTemp);
      }
    }
  }
}
