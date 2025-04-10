import 'dart:async';
import 'dart:typed_data';

import 'package:biltekteknikservis/widgets/navigators.dart';
import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import 'package:photo_view/photo_view.dart';
import 'package:photo_view/photo_view_gallery.dart';

import '../../ayarlar.dart';
import '../../models/medya.dart';
import '../../utils/post.dart';
import '../../utils/resim_secici.dart';
import 'resim_duzenle.dart';

class DetaylarGaleri extends StatefulWidget {
  const DetaylarGaleri({
    super.key,
    required this.duzenle,
    required this.id,
    required this.servisNo,
  });

  final bool duzenle;
  final int id;
  final int servisNo;

  @override
  State<DetaylarGaleri> createState() => _DetaylarGaleriState();
}

class _DetaylarGaleriState extends State<DetaylarGaleri> {
  final ImagePicker picker = ImagePicker();
  PageController pageController = PageController();
  List<MedyaModel> medyalar = [];
  int suankiResimIndex = 0;

  bool yukleniyor = true;

  Timer? timer;

  bool firstInitialization = true;

  @override
  void initState() {
    Future.delayed(Duration.zero, () async {
      await _medyalariYenile();
    });
    /*timer = Timer.periodic(Duration(seconds: 5), (timer) async {
      await _medyalariYenile();
    });*/
    super.initState();
  }

  @override
  void dispose() {
    timer?.cancel();
    pageController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("${widget.servisNo} Galeri"),
      ),
      bottomNavigationBar: BiltekBottomNavigationBar(
          items: [
            BottomNavigationBarItem(
              icon: Icon(
                Icons.add,
              ),
              label: "Ekle",
            ),
            BottomNavigationBarItem(
              icon: Icon(
                Icons.refresh,
              ),
              label: "Resimleri Yenile",
            ),
            if (medyalar.isNotEmpty)
              BottomNavigationBarItem(
                icon: Icon(
                  Icons.delete,
                ),
                label: "Sil",
              ),
          ],
          currentIndex: 0,
          selectedItemColor: Theme.of(context).appBarTheme.iconTheme?.color,
          onTap: (index) async {
            switch (index) {
              case 0:
                if (widget.duzenle && medyalar.isNotEmpty) {
                  await _medyaYukle();
                } else {
                  islemYapilamazDialog(
                    title: "Eklenemez",
                    content:
                        "Cihaz düzenleme tamamlandığı için resim eklenemez!",
                  );
                }
                break;
              case 1:
                await _medyalariYenile();
                break;
              case 2:
                if (widget.duzenle) {
                  _medyaSilDialog();
                } else {
                  islemYapilamazDialog(
                    title: "Silinemez",
                    content:
                        "Cihaz düzenleme tamamlandığı için resimler silinemez!",
                  );
                }
                break;
            }
            if (widget.duzenle) {}
          }),
      body: SizedBox(
        height: MediaQuery.of(context).size.height,
        child: yukleniyor
            ? Center(
                child: CircularProgressIndicator(),
              )
            : (medyalar.isNotEmpty
                ? PhotoViewGallery.builder(
                    itemCount: medyalar.length,
                    builder: (context, index) {
                      return PhotoViewGalleryPageOptions(
                        imageProvider: NetworkImage(
                          medyalar[index].yerel
                              ? "${Ayarlar.url}${medyalar[index].konum}"
                              : medyalar[index].konum,
                        ),
                        minScale: PhotoViewComputedScale.contained * 1,
                        maxScale: PhotoViewComputedScale.contained * 4,
                        onTapDown: (context, details, value) {},
                      );
                    },
                    scrollDirection: Axis.horizontal,
                    pageController: pageController,
                    onPageChanged: (index) {
                      setState(() {
                        suankiResimIndex = index;
                      });
                    },
                    scrollPhysics: const BouncingScrollPhysics(),
                    backgroundDecoration: BoxDecoration(
                      color: Theme.of(context).canvasColor,
                    ),
                  )
                : Center(
                    child: Text("Henüz resim yüklenmemiş"),
                  )),
      ),
    );
  }

  void islemYapilamazDialog({
    required String title,
    required String content,
  }) {
    showDialog(
      context: context,
      barrierDismissible: true,
      builder: (context) {
        return AlertDialog(
          title: Text(title),
          content: Text(content),
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

  Future<void> _medyalariYenile() async {
    if (mounted) {
      yukleniyor = true;
    } else {
      setState(() {
        yukleniyor = true;
      });
    }
    List<MedyaModel> medyalarTemp =
        await BiltekPost.medyalariGetir(id: widget.id);
    if (mounted) {
      setState(() {
        medyalar = medyalarTemp.where((m) => m.tur == "resim").toList();
        suankiResimIndex = 0;
        yukleniyor = false;
      });
    } else {
      medyalar = medyalarTemp.where((m) => m.tur == "resim").toList();
      suankiResimIndex = 0;
      yukleniyor = false;
    }
    if (medyalar.isNotEmpty &&
        !firstInitialization &&
        pageController.positions.isNotEmpty) {
      pageController.jumpToPage(0);
    }
    if (firstInitialization) {
      if (mounted) {
        setState(() {
          firstInitialization = false;
        });
      } else {
        firstInitialization = false;
      }
    }
  }

  Future<void> _medyaYukle() async {
    ResimSecici.of(context).sec(resimSecildi: (resim) {
      if (resim != null) {
        _resimDuzenle(resim);
      }
    });

    //await _medyalariYenile();
  }

  void _yukleniyorDialog() {
    showDialog(
      context: context,
      barrierDismissible: false,
      builder: (context) {
        return AlertDialog(
          title: Text("Yükleniyor"),
          content: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            mainAxisSize: MainAxisSize.min,
            children: [
              SizedBox(
                width: 20,
                height: 20,
                child: CircularProgressIndicator(),
              ),
            ],
          ),
        );
      },
    );
  }

  Future<void> _resimDuzenle(XFile resim) async {
    NavigatorState navigatorState = Navigator.of(context);
    Uint8List bytes = await resim.readAsBytes();
    navigatorState.push(
      MaterialPageRoute(
        builder: (context) => ResimDuzenle(
          resim: bytes,
          onEditComplete: (bytes) async {
            NavigatorState navigatorState = Navigator.of(context);
            _yukleniyorDialog();

            bool resimYuklendi = await BiltekPost.medyaYukle(
              id: widget.id,
              medya: bytes,
            );
            navigatorState.pop();
            if (resimYuklendi) {
              navigatorState.pop();
              await _medyalariYenile();
            } else {
              if (context.mounted) {
                showDialog(
                  context: context,
                  builder: (context) {
                    return AlertDialog(
                      title: Text("Başarısız"),
                      content: Text(
                          "Medya yüklenemedi lütfen daha sonra tekrar deneyin."),
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
          },
        ),
      ),
    );
  }

  void _medyaSilDialog() {
    showDialog(
      context: context,
      builder: (context) {
        return AlertDialog(
          title: Text("Medya Sil"),
          content: Text("Bu medyayı silmek istediğinize emin misiniz?"),
          actions: [
            TextButton(
              onPressed: () async {
                Navigator.pop(context);
                await _medyaSil();
              },
              child: Text("Evet"),
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

  Future<void> _medyaSil() async {
    if (medyalar.isNotEmpty) {
      NavigatorState navigatorState = Navigator.of(context);
      _yukleniyorDialog();
      bool silindi =
          await BiltekPost.medyaSil(id: medyalar[suankiResimIndex].id);
      navigatorState.pop();
      if (silindi) {
        await _medyalariYenile();
      } else {
        if (context.mounted) {
          BuildContext context1 = context;
          showDialog(
            context: context1,
            builder: (context) {
              return AlertDialog(
                title: Text("Başarısız"),
                content:
                    Text("Medya silinemedi lütfen daha sonra tekrar deneyin."),
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
    }
  }
}
