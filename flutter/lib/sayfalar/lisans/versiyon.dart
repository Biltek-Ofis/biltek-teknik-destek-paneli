import 'package:flutter/material.dart';
import 'package:flutter/services.dart';

import '../../models/kullanici.dart';
import '../../models/lisans/versiyon.dart';
import '../../utils/post.dart';
import '../cihazlar.dart';
import 'versiyon_ekle_duzenle.dart';

class VersiyonSayfasi extends StatefulWidget {
  const VersiyonSayfasi({
    super.key,
    required this.kullanici,
  });

  final KullaniciAuthModel kullanici;

  @override
  State<VersiyonSayfasi> createState() => _VersiyonSayfasiState();
}

class _VersiyonSayfasiState extends State<VersiyonSayfasi> {
  List<Versiyon>? versiyonlar;
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
      await _versiyonlariYenile();
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
          seciliSayfa: "Versiyonlar",
        ),
        appBar: AppBar(
          title: Text("Versiyonlar"),
          actions: [
            IconButton(
              onPressed: () async {
                await _versiyonlariYenile();
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
                      builder: (context) => VersiyonDuzenlemeSayfasi(
                        versiyonlariYenile: () async {
                          await _versiyonlariYenile();
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
          child: versiyonlar == null
              ? Center(
                  child: CircularProgressIndicator(),
                )
              : RefreshIndicator(
                  onRefresh: () async {
                    await _versiyonlariYenile();
                  },
                  child: versiyonlar!.isEmpty
                      ? Center(
                          child: Text("Henüz Bir Versiyon Eklenmemiş"),
                        )
                      : ListView.builder(
                          itemCount: versiyonlar?.length,
                          controller: scrollController,
                          physics: AlwaysScrollableScrollPhysics(),
                          itemBuilder: (context, index) {
                            Versiyon versiyon = versiyonlar![index];
                            return ListTile(
                              title: Text(versiyon.versiyon),
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
                                              VersiyonDuzenlemeSayfasi(
                                            versiyon: versiyon,
                                            versiyonlariYenile: () async {
                                              await _versiyonlariYenile();
                                            },
                                          ),
                                        ),
                                      );
                                    },
                                    icon: Icon(Icons.edit),
                                  ),
                                  IconButton(
                                    onPressed: () {
                                      _versiyonSil(
                                        versiyon.id,
                                        versiyon.versiyon,
                                      );
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

  Future<void> _versiyonlariYenile() async {
    if (mounted) {
      setState(() {
        versiyonlar = null;
      });
    } else {
      versiyonlar = null;
    }
    List<Versiyon> versiyonlarTemp = await BiltekPost.versiyonlariGetir();

    if (mounted) {
      setState(() {
        versiyonlar = versiyonlarTemp;
      });
    } else {
      versiyonlar = versiyonlarTemp;
    }
  }

  void _versiyonSil(int id, String versiyon) {
    showDialog(
      context: context,
      builder: (context) {
        return AlertDialog(
          title: Text("Versiyon Sil"),
          content: Text(
              "$versiyon versiyonunu silmek istediğinize emin misiniz?  Bu versiyona atanmış lisanslar devredışı kalacak!"),
          actions: [
            TextButton(
              onPressed: () async {
                NavigatorState navigatorState = Navigator.of(context);
                navigatorState.pop();
                setState(() {
                  versiyonlar = null;
                });
                bool durum = await BiltekPost.versiyonSil(id);
                await _versiyonlariYenile();
                if (!durum && context.mounted) {
                  _hataMesaji("Versiyon silinirken bir hata oluştu.");
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
