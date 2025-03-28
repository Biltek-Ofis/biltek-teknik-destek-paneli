import 'package:flutter/material.dart';

import '../../models/lisans/versiyon.dart';
import '../../utils/alerts.dart';
import '../../utils/buttons.dart';
import '../../utils/islemler.dart';
import '../../utils/post.dart';
import '../../widgets/input.dart';

class VersiyonDuzenlemeSayfasi extends StatefulWidget {
  const VersiyonDuzenlemeSayfasi({
    super.key,
    required this.versiyonlariYenile,
    this.versiyon,
  });

  final VoidCallback versiyonlariYenile;
  final Versiyon? versiyon;

  @override
  State<VersiyonDuzenlemeSayfasi> createState() =>
      _VersiyonDuzenlemeSayfasiState();
}

class _VersiyonDuzenlemeSayfasiState extends State<VersiyonDuzenlemeSayfasi> {
  bool girildi = false;
  ScrollController scrollController = ScrollController();

  TextEditingController versiyonController = TextEditingController();
  String? versiyonHata;

  @override
  void initState() {
    if (widget.versiyon != null) {
      versiyonController.text = widget.versiyon!.versiyon;
    }
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
        cikisKontrol();
      },
      child: Scaffold(
        appBar: AppBar(
          title: Text(
              widget.versiyon == null ? "Versiyon Ekle" : "Versiyonu Düzenle"),
        ),
        body: SizedBox(
          width: MediaQuery.of(context).size.width,
          child: SingleChildScrollView(
            controller: scrollController,
            child: Column(
              children: [
                BiltekTextField(
                  controller: versiyonController,
                  label: "Versiyon *",
                  errorText: versiyonHata,
                  onChanged: (value) {
                    setState(() {
                      girildi = true;
                      versiyonHata = null;
                    });
                  },
                ),
                Row(
                  children: [
                    SizedBox(
                      width: MediaQuery.of(context).size.width,
                      child: Row(
                        mainAxisSize: MainAxisSize.max,
                        mainAxisAlignment: MainAxisAlignment.end,
                        children: [
                          SizedBox(),
                          DefaultButton(
                            width: MediaQuery.of(context).size.width / 3,
                            background: Islemler.arkaRenk("bg-primary"),
                            onPressed: () async {
                              await _duzenle();
                            },
                            text: widget.versiyon == null ? "Ekle" : "Kaydet",
                          ),
                          SizedBox(
                            width: 10,
                          ),
                          DefaultButton(
                            width: MediaQuery.of(context).size.width / 3,
                            background: Islemler.arkaRenk("bg-secondary"),
                            onPressed: () {
                              cikisKontrol();
                            },
                            text: "Kapat",
                          ),
                        ],
                      ),
                    )
                  ],
                )
              ],
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

  Future<void> cikisKontrol() async {
    if (girildi) {
      NavigatorState navigatorState = Navigator.of(context);
      bool? result = await showDialog<bool>(
        context: context,
        builder: (context) {
          return AlertDialog(
            title: Text("Değişiklikler Kaydedilmedi"),
            content: Text(
                "Kaydedilmeyen değişiklikleriniz var. Çıkmak istediğinize emin misiniz?"),
            actions: [
              TextButton(
                onPressed: () {
                  navigatorState.pop(true);
                },
                child: Text(
                  "İptal Et ve Çık",
                  style: TextStyle(
                    color: Colors.red,
                  ),
                ),
              ),
              TextButton(
                onPressed: () {
                  navigatorState.pop(false);
                },
                child: Text("Kal"),
              ),
            ],
          );
        },
      );
      if (result == true) {
        cik();
        navigatorState.pop<bool>(result);
      }
    } else {
      cik();
      Navigator.pop(context);
    }
  }

  void cik() {
    widget.versiyonlariYenile.call();
  }

  Future<void> _duzenle() async {
    NavigatorState navigatorState = Navigator.of(context);
    String versiyon = versiyonController.text;
    if (versiyon.isNotEmpty) {
      yukleniyor(context);

      Map<String, String> postData = {
        "versiyon": versiyon,
      };
      bool? duzenle;
      if (widget.versiyon != null) {
        duzenle = await BiltekPost.versiyonDuzenle(
          id: widget.versiyon!.id,
          postData: postData,
        );
      } else {
        duzenle = await BiltekPost.versiyonEkle(
          postData: postData,
        );
      }
      if (duzenle) {
        widget.versiyonlariYenile.call();
        navigatorState.pop();
      } else {
        _hataMesaji("Bir hata oluştu!");
      }
      navigatorState.pop();
    } else {
      setState(() {
        versiyonHata = "Versiyon Boş Olamaz";
      });
    }
  }
}
