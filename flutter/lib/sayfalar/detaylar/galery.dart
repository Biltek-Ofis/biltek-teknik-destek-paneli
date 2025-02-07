import 'dart:async';

import 'package:carousel_slider/carousel_slider.dart';
import 'package:biltekteknikservis/models/medya.dart';
import 'package:biltekteknikservis/utils/post.dart';
import 'package:flutter/material.dart';

import '../../ayarlar.dart';

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
  List<MedyaModel> medyalar = [];

  bool yukleniyor = true;

  Timer? timer;

  @override
  void initState() {
    Future.delayed(Duration.zero, () async {
      await _medyalariYenile();
    });
    timer = Timer.periodic(Duration(seconds: 5), (timer) async {
      await _medyalariYenile();
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
        child: medyalar.where((m) => m.tur == "resim").isNotEmpty
            ? CarouselSlider(
                options: CarouselOptions(
                  height: MediaQuery.of(context).size.height,
                  viewportFraction: 1.0,
                  enlargeCenterPage: false,
                  autoPlay: false,
                ),
                items: medyalar
                    .where((m) => m.tur == "resim")
                    .map(
                      (item) => SizedBox(
                        child: Center(
                          child: Image.network(
                            item.yerel
                                ? "${Ayarlar.url}${item.konum}"
                                : item.konum,
                            fit: BoxFit.fitWidth,
                            height: MediaQuery.of(context).size.height,
                          ),
                        ),
                      ),
                    )
                    .toList(),
              )
            : Center(
                child: Text("Henüz resim yüklenmemiş"),
              ),
      ),
    );
  }

  Future<void> _medyalariYenile() async {
    List<MedyaModel> medyalarTemp =
        await BiltekPost.medyalariGetir(id: widget.id);
    if (mounted) {
      setState(() {
        medyalar = medyalarTemp;
        yukleniyor = false;
      });
    } else {
      medyalar = medyalarTemp;
      yukleniyor = false;
    }
  }

  Future<void> _medyaYukle() async {
    //await _medyalariYenile();
  }
}
