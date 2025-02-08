import 'dart:async';
import 'dart:typed_data';

import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import 'package:photo_view/photo_view.dart';
import 'package:photo_view/photo_view_gallery.dart';

import '../../ayarlar.dart';
import '../../models/medya.dart';
import '../../utils/post.dart';
import 'resim_duzenle.dart';

class DetaylarGaleri extends StatefulWidget {
  const DetaylarGaleri({
    super.key,
    required this.id,
    required this.servisNo,
  });

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
        actions: [
          IconButton(
            onPressed: () async {
              await _medyalariYenile();
            },
            icon: Icon(
              Icons.refresh,
            ),
          ),
          IconButton(
            onPressed: () async {
              await _medyaYukle();
            },
            icon: Icon(
              Icons.add,
            ),
          ),
          if (medyalar.isNotEmpty)
            IconButton(
              onPressed: () {
                _medyaSilDialog();
              },
              icon: Icon(
                Icons.delete,
              ),
            ),
        ],
      ),
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
    if (medyalar.isNotEmpty && !firstInitialization) {
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
    showModalBottomSheet<void>(
      context: context,
      builder: (BuildContext context) {
        return SizedBox(
          height: 100,
          child: Center(
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              mainAxisSize: MainAxisSize.min,
              children: <Widget>[
                TextButton(
                  onPressed: () async {
                    Navigator.pop(context);
                    final resim = await picker.pickImage(
                      source: ImageSource.camera,
                      preferredCameraDevice: CameraDevice.rear,
                      maxWidth: 1000,
                      maxHeight: 1000,
                    );
                    if (resim != null) {
                      _resimDuzenle(resim);
                    }
                  },
                  child: Text("Kamera"),
                ),
                TextButton(
                  onPressed: () async {
                    Navigator.pop(context);
                    final resim = await picker.pickImage(
                      source: ImageSource.gallery,
                      maxWidth: 1000,
                      maxHeight: 1000,
                    );
                    if (resim != null) {
                      _resimDuzenle(resim);
                    }
                  },
                  child: Text("Galeri"),
                ),
              ],
            ),
          ),
        );
      },
    );

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
