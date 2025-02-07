import 'dart:async';
import 'dart:typed_data';

import 'package:biltekteknikservis/models/medya.dart';
import 'package:biltekteknikservis/utils/post.dart';
import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import 'package:photo_view/photo_view.dart';
import 'package:photo_view/photo_view_gallery.dart';

import '../../ayarlar.dart';
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

  bool yukleniyor = true;

  Timer? timer;

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
                    onPageChanged: (index) {},
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
        yukleniyor = false;
      });
    } else {
      medyalar = medyalarTemp.where((m) => m.tur == "resim").toList();
      yukleniyor = false;
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

  Future<void> _resimDuzenle(XFile resim) async {
    NavigatorState navigatorState = Navigator.of(context);

    Uint8List bytes = await resim.readAsBytes();
    navigatorState.push(
      MaterialPageRoute(
        builder: (context) => ResimDuzenle(
          resim: bytes,
          onEditComplete: (bytes) async {
            NavigatorState navigatorState = Navigator.of(context);
            showDialog(
              context: context,
              builder: (context) {
                return AlertDialog(
                  title: Text("Yükleniyor"),
                  content: CircularProgressIndicator(),
                );
              },
            );

            bool resimYuklendi = await BiltekPost.medyaYukle(
              id: widget.id,
              medya: bytes,
            );
            if (resimYuklendi) {
              navigatorState.pop();
              navigatorState.pop();
              await _medyalariYenile();
            } else {
              navigatorState.pop();
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
}
