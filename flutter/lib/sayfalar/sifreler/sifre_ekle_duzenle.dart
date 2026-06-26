import 'package:flutter/material.dart';

import '../../models/kullanici.dart';
import '../../models/sifre.dart';
import '../../utils/buttons.dart';
import '../../utils/islemler.dart';
import '../../utils/post.dart';
import '../../widgets/input.dart';

class SifreEkleDuzenleSayfasi extends StatefulWidget {
  const SifreEkleDuzenleSayfasi({
    super.key,
    required this.kullanici,
    this.sifre,
    this.sifreleriYenile,
  });

  final KullaniciAuthModel kullanici;
  final SifreModel? sifre;
  final VoidCallback? sifreleriYenile;

  @override
  State<SifreEkleDuzenleSayfasi> createState() =>
      _SifreEkleDuzenleSayfasiState();
}

class _SifreEkleDuzenleSayfasiState extends State<SifreEkleDuzenleSayfasi> {
  bool girildi = false;
  TextEditingController musteriAdiTextEditingController =
      TextEditingController();
  String? musteriAdierror;
  FocusNode musteriAdiFocusNode = FocusNode();
  TextEditingController aciklamaTextEditingController = TextEditingController();
  String? aciklamaError;
  FocusNode aciklamaFocusNode = FocusNode();
  TextEditingController kAdiTextEditingController = TextEditingController();
  String? kAdiError;
  FocusNode kAdiFocusNode = FocusNode();
  TextEditingController sifreTextEditingController = TextEditingController();
  String? sifreError;
  FocusNode sifreFocusNode = FocusNode();

  @override
  void initState() {
    super.initState();
    if (widget.sifre != null) {
      musteriAdiTextEditingController.text = widget.sifre!.musteriAdi;
      aciklamaTextEditingController.text = widget.sifre!.aciklama;
      kAdiTextEditingController.text = widget.sifre!.kAdi;
      sifreTextEditingController.text = widget.sifre!.sifre;
    }
  }

  @override
  Widget build(BuildContext context) {
    return PopScope(
      canPop: false,
      onPopInvokedWithResult: (didPop, result) async {
        if (didPop) {
          return;
        }
        if (girildi) {
          NavigatorState navigatorState = Navigator.of(context);
          bool? result = await showDialog<bool>(
            context: context,
            builder: (context) {
              return AlertDialog(
                title: Text("Değişiklikler Kaydedilmedi"),
                content: Text(
                  "Kaydedilmeyen değişiklikleriniz var. Çıkmak istediğinize emin misiniz?",
                ),
                actions: [
                  TextButton(
                    onPressed: () {
                      navigatorState.pop(true);
                    },
                    child: Text(
                      "İptal Et ve Çık",
                      style: TextStyle(color: Colors.red),
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
      },
      child: Scaffold(
        appBar: AppBar(
          title: Text(widget.sifre != null ? "Şifre Düzenle" : "Şifre Ekle"),
        ),
        resizeToAvoidBottomInset: false,
        body: SafeArea(
          child: Column(
            children: [
              Expanded(
                child: Column(
                  children: [
                    BiltekTextField(
                      label: "Müşteri İsmi",
                      controller: musteriAdiTextEditingController,
                      currentFocus: musteriAdiFocusNode,
                      textInputAction: TextInputAction.next,
                      nextFocus: aciklamaFocusNode,
                      errorText: musteriAdierror,
                      onChanged: (v) {
                        setState(() {
                          musteriAdierror = null;
                          girildi = true;
                        });
                      },
                    ),
                    BiltekTextField(
                      label: "Açıklama",
                      controller: aciklamaTextEditingController,
                      currentFocus: aciklamaFocusNode,
                      textInputAction: TextInputAction.next,
                      nextFocus: kAdiFocusNode,
                      errorText: aciklamaError,
                      onChanged: (v) {
                        setState(() {
                          aciklamaError = null;
                          girildi = true;
                        });
                      },
                    ),
                    BiltekTextField(
                      label: "Kullanıcı Adı",
                      controller: kAdiTextEditingController,
                      currentFocus: kAdiFocusNode,
                      textInputAction: TextInputAction.next,
                      nextFocus: sifreFocusNode,
                      errorText: kAdiError,
                      onChanged: (v) {
                        setState(() {
                          kAdiError = null;
                          girildi = true;
                        });
                      },
                    ),
                    BiltekSifre(
                      label: "Şifre",
                      controller: sifreTextEditingController,
                      currentFocus: sifreFocusNode,
                      textInputAction: TextInputAction.done,
                      errorText: sifreError,
                      onChanged: (v) {
                        setState(() {
                          sifreError = null;
                          girildi = true;
                        });
                      },
                      onSubmitted: (v) {
                        _kaydet();
                      },
                    ),
                  ],
                ),
              ),
              SizedBox(
                height: 80,
                width: MediaQuery.of(context).size.width,
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.end,
                  crossAxisAlignment: CrossAxisAlignment.end,
                  children: [
                    PrimaryButton(
                      onPressed: () {
                        _kaydet();
                      },
                      backgroundColor: Islemler.arkaRenk(
                        "bg-success",
                        alpha: 1,
                      ),
                      label: "Kaydet",
                    ),
                    SizedBox(width: 8),
                    PrimaryButton(
                      onPressed: () {
                        Navigator.pop(context);
                      },
                      backgroundColor: Islemler.arkaRenk("bg-danger", alpha: 1),
                      label: "İptal",
                    ),
                    SizedBox(width: 8),
                  ],
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  Future<void> _kaydet() async {
    String musteriAdi = musteriAdiTextEditingController.text;
    String aciklama = aciklamaTextEditingController.text;
    String kAdi = kAdiTextEditingController.text;
    String sifre = sifreTextEditingController.text;
    bool devamEdebilir = true;
    if (musteriAdi.isEmpty) {
      devamEdebilir = false;
      setState(() {
        musteriAdierror = "Bu alan gerekli";
      });
    }
    if (aciklama.isEmpty) {
      devamEdebilir = false;
      setState(() {
        aciklamaError = "Bu alan gerekli";
      });
    }
    if (kAdi.isEmpty) {
      devamEdebilir = false;
      setState(() {
        kAdiError = "Bu alan gerekli";
      });
    }
    if (sifre.isEmpty) {
      devamEdebilir = false;
      setState(() {
        sifreError = "Bu alan gerekli";
      });
    }
    if (!devamEdebilir) {
      return;
    }
    setState(() {
      girildi = false;
    });
    NavigatorState navigatorState = Navigator.of(context);
    bool duzenle = false;
    if (widget.sifre != null) {
      debugPrint("11");
      duzenle = await BiltekPost.of(widget.kullanici.auth).sifreDuzenle(
        id: widget.sifre!.id,
        musteriAdi: musteriAdi,
        aciklama: aciklama,
        kAdi: kAdi,
        sifre: sifre,
        kullaniciID: widget.kullanici.id,
      );
    } else {
      duzenle = await BiltekPost.of(widget.kullanici.auth).sifreEkle(
        musteriAdi: musteriAdi,
        aciklama: aciklama,
        kAdi: kAdi,
        sifre: sifre,
        kullaniciID: widget.kullanici.id,
      );
    }
    if (duzenle) {
      widget.sifreleriYenile?.call();
      navigatorState.pop();
    } else {
      if (mounted) {
        showDialog(
          context: context,
          builder:
              (context) => AlertDialog(
                title: Text(
                  widget.sifre != null
                      ? "Şifre Düzenlenemedi"
                      : "Şifre Eklenemedi",
                ),
                content: Text(
                  "Şifre ${widget.sifre != null ? "düzenlenirken" : "eklenirken"} bir hata oluştu. Lütfen daha sonra tekrar deneyin!",
                ),
                actions: [
                  TextButton(
                    onPressed: () {
                      Navigator.pop(context);
                    },
                    child: Text("Kapat"),
                  ),
                ],
              ),
        );
      }
    }
  }

  void cik() {
    widget.sifreleriYenile?.call();
  }
}
