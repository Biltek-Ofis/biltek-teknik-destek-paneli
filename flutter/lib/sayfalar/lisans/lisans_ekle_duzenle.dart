import 'package:biltekteknikservis/utils/post.dart';
import 'package:biltekteknikservis/widgets/input.dart';
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';

import '../../models/lisans.dart';
import '../../utils/alerts.dart';
import '../../utils/buttons.dart';
import '../../utils/islemler.dart';

class LisansDuzenlemeSayfasi extends StatefulWidget {
  const LisansDuzenlemeSayfasi({
    super.key,
    required this.lisanslariYenile,
    this.lisans,
  });

  final VoidCallback lisanslariYenile;
  final Lisans? lisans;

  @override
  State<LisansDuzenlemeSayfasi> createState() => _LisansDuzenlemeSayfasiState();
}

class _LisansDuzenlemeSayfasiState extends State<LisansDuzenlemeSayfasi> {
  bool girildi = false;
  ScrollController scrollController = ScrollController();

  TextEditingController isimController = TextEditingController();
  String? isimHata;

  int sureDurumu = 0;

  TextEditingController baslangicController = TextEditingController();
  String? baslangicHata;

  TextEditingController bitisController = TextEditingController();
  String? bitisHata;

  int aktifDurumu = 1;

  @override
  void initState() {
    if (widget.lisans != null) {
      isimController.text = widget.lisans!.isim;
      sureDurumu = widget.lisans!.suresiz ? 1 : 0;
      aktifDurumu = widget.lisans!.aktif ? 1 : 0;
    }
    DateTime baslangicTarihi = widget.lisans != null
        ? DateFormat(Islemler.lisansSQLTarih).parse(widget.lisans!.baslangic)
        : DateTime.now().toLocal();
    baslangicController.text =
        DateFormat(Islemler.lisansNormalTarih).format(baslangicTarihi);
    DateTime bitisTarihi = widget.lisans != null
        ? DateFormat(Islemler.lisansSQLTarih).parse(widget.lisans!.bitis)
        : baslangicTarihi.add(
            Duration(
              days: 365,
            ),
          );
    bitisController.text =
        DateFormat(Islemler.lisansNormalTarih).format(bitisTarihi);
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
          title: Text("Lisans Ekle"),
        ),
        body: SizedBox(
          width: MediaQuery.of(context).size.width,
          child: SingleChildScrollView(
            controller: scrollController,
            child: Column(
              children: [
                BiltekTextField(
                  controller: isimController,
                  label: "İsim *",
                  errorText: isimHata,
                  onChanged: (value) {
                    setState(() {
                      girildi = true;
                      isimHata = null;
                    });
                  },
                ),
                BiltekSelect<int>(
                  title: "Süre Durumu",
                  value: sureDurumu,
                  items: [
                    DropdownMenuItem(
                      value: 0,
                      child: Text("Süreli"),
                    ),
                    DropdownMenuItem(
                      value: 1,
                      child: Text("Süresiz"),
                    ),
                  ],
                  onChanged: (value) {
                    setState(() {
                      girildi = true;
                      sureDurumu = value!;
                    });
                  },
                ),
                BiltekTarih(
                  controller: baslangicController,
                  format: Islemler.lisansNormalTarih,
                  saatiGoster: false,
                  label: "Başlangıç Tarihi",
                  errorText: baslangicHata,
                  onConfirm: (date) {
                    baslangicTarihiGuncelle(date!);
                  },
                  onChanged: (value) {
                    setState(() {
                      girildi = true;
                      baslangicHata = "";
                    });
                  },
                ),
                if (sureDurumu == 0)
                  BiltekTarih(
                    controller: bitisController,
                    format: Islemler.lisansNormalTarih,
                    saatiGoster: false,
                    label: "Bitiş Tarihi",
                    errorText: bitisHata,
                    onConfirm: (date) {
                      bitisTarihiGuncelle(date!);
                    },
                    onChanged: (value) {
                      setState(() {
                        girildi = true;
                        bitisHata = "";
                      });
                    },
                  ),
                if (widget.lisans != null)
                  BiltekSelect<int>(
                    title: "Aktif",
                    value: aktifDurumu,
                    items: [
                      DropdownMenuItem(
                        value: 1,
                        child: Text("Evet"),
                      ),
                      DropdownMenuItem(
                        value: 0,
                        child: Text("Hayır"),
                      ),
                    ],
                    onChanged: (value) {
                      setState(() {
                        girildi = true;
                        aktifDurumu = value!;
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
                            text: widget.lisans == null ? "Ekle" : "Kaydet",
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
    widget.lisanslariYenile.call();
  }

  void baslangicTarihiGuncelle(DateTime tarih) {
    baslangicController.text =
        DateFormat(Islemler.lisansNormalTarih).format(tarih);
  }

  void bitisTarihiGuncelle(DateTime tarih) {
    bitisController.text = DateFormat(Islemler.lisansNormalTarih).format(tarih);
  }

  Future<void> _duzenle() async {
    NavigatorState navigatorState = Navigator.of(context);
    String isim = isimController.text;
    String baslangic = baslangicController.text;
    String bitis = bitisController.text;
    if (isim.isNotEmpty) {
      if (baslangic.isNotEmpty) {
        if (sureDurumu == 1 || (sureDurumu == 0 && bitis.isNotEmpty)) {
          yukleniyor(context);

          DateTime baslangicTarihi =
              DateFormat(Islemler.lisansNormalTarih).parse(baslangic);
          baslangic =
              DateFormat(Islemler.lisansSQLTarih).format(baslangicTarihi);

          DateTime bitisTarihi =
              DateFormat(Islemler.lisansNormalTarih).parse(bitis);
          bitis = DateFormat(Islemler.lisansSQLTarih).format(bitisTarihi);
          Map<String, String> postData = {
            "isim": isim,
            "sure_durumu": sureDurumu.toString(),
            "baslangic": baslangic,
          };
          if (sureDurumu == 0) {
            postData.addAll({
              "bitis": bitis,
            });
          }
          bool? duzenle;
          if (widget.lisans != null) {
            if (sureDurumu == 0) {
              postData.addAll({
                "aktif": aktifDurumu.toString(),
              });
            }
            duzenle = await BiltekPost.lisansDuzenle(
              id: widget.lisans!.id,
              postData: postData,
            );
          } else {
            duzenle = await BiltekPost.lisansEkle(
              postData: postData,
            );
          }
          if (duzenle) {
            widget.lisanslariYenile.call();
            navigatorState.pop();
          } else {
            _hataMesaji("Bir hata oluştu!");
          }
          navigatorState.pop();
        } else {
          setState(() {
            bitisHata = "Bitiş Tarihi Boş Olamaz";
          });
        }
      } else {
        setState(() {
          baslangicHata = "Başlangıc Tarihi Boş Olamaz";
        });
      }
    } else {
      setState(() {
        isimHata = "İsim Boş Olamaz";
      });
    }
  }
}
