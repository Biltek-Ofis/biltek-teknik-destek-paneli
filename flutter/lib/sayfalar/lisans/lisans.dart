import 'package:flutter/material.dart';
import 'package:flutter/services.dart';

import '../../models/kullanici.dart';
import '../../models/lisans.dart';
import '../../utils/islemler.dart';
import '../../utils/post.dart';
import '../cihazlar.dart';
import 'lisans_ekle_duzenle.dart';

class LisansSayfasi extends StatefulWidget {
  const LisansSayfasi({
    super.key,
    required this.kullanici,
  });

  final KullaniciAuthModel kullanici;

  @override
  State<LisansSayfasi> createState() => _LisansSayfasiState();
}

class _LisansSayfasiState extends State<LisansSayfasi> {
  List<Lisans>? lisanslar;
  ScrollController scrollController = ScrollController();
  bool yukariKaydir = false;

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
    });
    Future.delayed(Duration.zero, () async {
      await _lisanslariYenile();
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
        SystemChannels.platform.invokeMethod('SystemNavigator.pop');
        //Navigator.of(context).pop(result);
      },
      child: Scaffold(
        drawer: biltekDrawer(
          context,
          kullanici: widget.kullanici,
          seciliSayfa: "Lisanslar",
        ),
        appBar: AppBar(
          title: Text("Lisanslar"),
          actions: [
            IconButton(
              onPressed: () async {
                await _lisanslariYenile();
              },
              icon: Icon(Icons.refresh),
            ),
          ],
        ),
        floatingActionButton: yukariKaydir
            ? FloatingActionButton(
                onPressed: () {
                  scrollController.animateTo(
                    0,
                    duration: Duration(seconds: 1),
                    curve: Curves.bounceIn,
                  );
                },
                child: Icon(
                  Icons.arrow_upward,
                  color: Colors.white,
                ),
              )
            : FloatingActionButton(
                onPressed: () {
                  Navigator.push(
                    context,
                    MaterialPageRoute(
                      builder: (context) => LisansDuzenlemeSayfasi(
                        lisanslariYenile: () async {
                          await _lisanslariYenile();
                        },
                      ),
                    ),
                  );
                },
                child: Icon(
                  Icons.add,
                  color: Colors.white,
                ),
              ),
        body: SizedBox(
          width: MediaQuery.of(context).size.width,
          child: lisanslar == null
              ? Center(
                  child: CircularProgressIndicator(),
                )
              : RefreshIndicator(
                  onRefresh: () async {
                    await _lisanslariYenile();
                  },
                  child: lisanslar!.isEmpty
                      ? Center(
                          child: Text("Henüz Bir Lisans Eklenmemiş"),
                        )
                      : ListView.builder(
                          itemCount: lisanslar?.length,
                          controller: scrollController,
                          physics: AlwaysScrollableScrollPhysics(),
                          itemBuilder: (context, index) {
                            Lisans lisans = lisanslar![index];
                            return ListTile(
                              title: Text(lisans.isim),
                              subtitle: Column(
                                mainAxisSize: MainAxisSize.min,
                                mainAxisAlignment: MainAxisAlignment.start,
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Text(lisans.lisans),
                                  Text(
                                    "Kayıt: ${Islemler.tarihGoruntule(lisans.kayit, Islemler.lisansSQLTarih, Islemler.lisansNormalTarih)}",
                                  ),
                                  Text(
                                    "Başlangıc: ${Islemler.tarihGoruntule(lisans.baslangic, Islemler.lisansSQLTarih, Islemler.lisansNormalTarih)}",
                                  ),
                                  Row(
                                    children: [
                                      Text(
                                        "Bitis:",
                                      ),
                                      Text(
                                        " ${lisans.suresiz ? lisans.durum["mesaj"] : Islemler.tarihGoruntule(lisans.bitis, Islemler.lisansSQLTarih, Islemler.lisansNormalTarih)}",
                                        style: lisans.suresiz
                                            ? TextStyle(color: Colors.green)
                                            : null,
                                      )
                                    ],
                                  ),
                                  if (!lisans.suresiz)
                                    Text(
                                      "(${lisans.durum["mesaj"]})",
                                      style: TextStyle(
                                        color: (lisans.durum["aktif"] as bool)
                                            ? Colors.green
                                            : Colors.red,
                                      ),
                                    ),
                                ],
                              ),
                              trailing: Row(
                                mainAxisSize: MainAxisSize.min,
                                mainAxisAlignment: MainAxisAlignment.end,
                                children: [
                                  IconButton(
                                    onPressed: () {
                                      Navigator.push(
                                        context,
                                        MaterialPageRoute(
                                          builder: (context) =>
                                              LisansDuzenlemeSayfasi(
                                            lisans: lisans,
                                            lisanslariYenile: () async {
                                              await _lisanslariYenile();
                                            },
                                          ),
                                        ),
                                      );
                                    },
                                    icon: Icon(Icons.edit),
                                  ),
                                  IconButton(
                                    onPressed: () {
                                      _lisansSil(lisans.id, lisans.isim);
                                    },
                                    icon: Icon(Icons.delete),
                                  ),
                                ],
                              ),
                            );
                          },
                        ),
                ),
        ),
      ),
    );
  }

  void _hataMesaji(String hata) {
    showDialog(
      context: context,
      builder: (context) {
        return AlertDialog(
          title: Text("Hata"),
          content: Text(hata),
          actions: [
            TextButton(
              onPressed: () {
                Navigator.pop(context);
              },
              child: Text("Tamam"),
            ),
          ],
        );
      },
    );
  }

  Future<void> _lisanslariYenile() async {
    if (mounted) {
      setState(() {
        lisanslar = null;
      });
    } else {
      lisanslar = null;
    }
    List<Lisans> lisanslarTemp = await BiltekPost.lisanslariGetir();

    if (mounted) {
      setState(() {
        lisanslar = lisanslarTemp;
      });
    } else {
      lisanslar = lisanslarTemp;
    }
  }

  void _lisansSil(int id, String isim) {
    showDialog(
      context: context,
      builder: (context) {
        return AlertDialog(
          title: Text("Lisans Sil"),
          content: Text("$isim adlı lisansı silmek istediğinize emin misiniz?"),
          actions: [
            TextButton(
              onPressed: () async {
                NavigatorState navigatorState = Navigator.of(context);
                navigatorState.pop();
                setState(() {
                  lisanslar = null;
                });
                bool durum = await BiltekPost.lisansSil(id);
                await _lisanslariYenile();
                if (!durum && context.mounted) {
                  _hataMesaji("Lisans silinirken bir hata oluştu.");
                }
              },
              child: Text(
                "Evet",
                style: TextStyle(color: Colors.red),
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
  }
}
