import 'package:flutter/material.dart';

import '../../models/kullanici.dart';
import '../../utils/buttons.dart';
import '../../utils/post.dart';
import '../../widgets/input.dart';
import '../../widgets/restart.dart';

class KullaniciDuzenleSayfasi extends StatefulWidget {
  const KullaniciDuzenleSayfasi({super.key, required this.kullanici});

  final KullaniciAuthModel kullanici;

  @override
  State<KullaniciDuzenleSayfasi> createState() =>
      _KullaniciDuzenleSayfasiState();
}

class _KullaniciDuzenleSayfasiState extends State<KullaniciDuzenleSayfasi> {
  bool girildi = false;
  String? error;
  String? succes;

  TextEditingController kullaniciAdiController = TextEditingController();
  FocusNode kullaniciAdiFocusNode = FocusNode();
  String? kullaniciAdiError;

  TextEditingController adSoyadController = TextEditingController();
  FocusNode adSoyadFocusNode = FocusNode();
  String? adSoyadError;

  TextEditingController eskiSifreController = TextEditingController();
  FocusNode eskiSifreFocusNode = FocusNode();
  String? eskiSifreError;

  TextEditingController yeniSifreController = TextEditingController();
  FocusNode yeniSifreFocusNode = FocusNode();
  String? yeniSifreError;

  TextEditingController yeniSifreTekrarController = TextEditingController();
  FocusNode yeniSifreTekrarFocusNode = FocusNode();
  String? yeniSifreTekrarError;

  bool eskiSifreGoster = false;
  bool yeniSifreGoster = false;

  @override
  void initState() {
    super.initState();
    adSoyadController.text = widget.kullanici.adSoyad;
    kullaniciAdiController.text = widget.kullanici.kullaniciAdi;
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
            navigatorState.pop<bool>(result);
          }
        } else {
          Navigator.pop(context);
        }
      },
      child: Scaffold(
        appBar: AppBar(title: Text("Kullanıcı Düzenle")),
        resizeToAvoidBottomInset: false,
        body: SafeArea(
          child: Container(
            padding: EdgeInsets.all(8),
            width: MediaQuery.of(context).size.width,
            height: MediaQuery.of(context).size.height,
            child: Column(
              children: [
                Expanded(
                  child: SingleChildScrollView(
                    child: Column(
                      spacing: 10,
                      children: [
                        if (error != null)
                          Text(error!, style: TextStyle(color: Colors.red)),
                        if (succes != null)
                          Text(succes!, style: TextStyle(color: Colors.green)),
                        BiltekTextField(
                          controller: kullaniciAdiController,
                          currentFocus: kullaniciAdiFocusNode,
                          nextFocus: adSoyadFocusNode,
                          label: "Kullanıcı Adı *",
                          errorText: kullaniciAdiError,
                          onChanged: (value) async {
                            setState(() {
                              error = null;
                              succes = null;
                              kullaniciAdiError = null;
                              girildi = true;
                            });
                          },
                        ),

                        BiltekTextField(
                          controller: adSoyadController,
                          currentFocus: adSoyadFocusNode,
                          nextFocus: eskiSifreFocusNode,
                          label: "Ad Soyad *",
                          errorText: adSoyadError,
                          onChanged: (value) async {
                            setState(() {
                              error = null;
                              succes = null;
                              adSoyadError = null;
                              girildi = true;
                            });
                          },
                        ),
                        BiltekSifre(
                          controller: eskiSifreController,
                          currentFocus: eskiSifreFocusNode,
                          nextFocus: yeniSifreFocusNode,
                          label: "Güncel Şifre *",
                          errorText: eskiSifreError,
                          sifreGoster: eskiSifreGoster,
                          sifreDurumu: (goster) {
                            setState(() {
                              eskiSifreGoster = goster;
                            });
                          },
                          onChanged: (value) async {
                            setState(() {
                              error = null;
                              succes = null;
                              eskiSifreError = null;
                              girildi = true;
                            });
                          },
                        ),
                        Text("Şifre Değiştirmek İstiyorsanız Yeni Şifre Girin"),
                        BiltekSifre(
                          controller: yeniSifreController,
                          currentFocus: yeniSifreFocusNode,
                          nextFocus: yeniSifreTekrarFocusNode,
                          label: "Yeni Şifre",
                          errorText: yeniSifreError,
                          sifreGoster: yeniSifreGoster,
                          sifreDurumu: (goster) {
                            setState(() {
                              yeniSifreGoster = goster;
                            });
                          },
                          onChanged: (value) async {
                            setState(() {
                              error = null;
                              succes = null;
                              yeniSifreError = null;
                              girildi = true;
                            });
                          },
                        ),
                        BiltekSifre(
                          controller: yeniSifreTekrarController,
                          currentFocus: yeniSifreTekrarFocusNode,
                          label: "Yeni Şifre Tekrar",
                          errorText: yeniSifreTekrarError,
                          sifreGoster: yeniSifreGoster,
                          sifreDurumu: (goster) {
                            setState(() {
                              yeniSifreGoster = goster;
                            });
                          },
                          onChanged: (value) async {
                            setState(() {
                              error = null;
                              succes = null;
                              yeniSifreTekrarError = null;
                              girildi = true;
                            });
                          },
                          onSubmitted: (value) async {
                            await _kaydet();
                          },
                        ),
                      ],
                    ),
                  ),
                ),
                SizedBox(
                  width: MediaQuery.of(context).size.width,
                  child: Row(
                    mainAxisSize: MainAxisSize.max,
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      SizedBox(),
                      PrimaryButton(
                        width: MediaQuery.of(context).size.width / 2,
                        onPressed: () async {
                          await _kaydet();
                        },
                        label: "Kaydet",
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Future<void> _kaydet() async {
    String kullaniciAdi = kullaniciAdiController.text;
    String adSoyad = adSoyadController.text;
    String eskiSifre = eskiSifreController.text;
    String yeniSifre = yeniSifreController.text.trim();
    String yeniSifreTekrar = yeniSifreTekrarController.text.trim();
    if (kullaniciAdi.length < 3) {
      setState(() {
        kullaniciAdiError = "Kullanıcı adı en az 3 karakter olmalıdır";
      });
      return;
    }
    if (adSoyad.length < 3) {
      setState(() {
        adSoyadError = "Ad Soyad en az 3 karakter olmalıdır";
      });
      return;
    }
    if (eskiSifre.isEmpty) {
      setState(() {
        eskiSifreError = "Güncel şifre boş olamaz";
      });
      return;
    }
    if (yeniSifre.isNotEmpty || yeniSifreTekrar.isNotEmpty) {
      if (yeniSifre.length < 6) {
        setState(() {
          yeniSifreError = "Yeni şifre en az 6 karakter olmalıdır";
        });
        return;
      }
      if (yeniSifre != yeniSifreTekrar) {
        setState(() {
          yeniSifreTekrarError = "Yeni şifreler eşleşmiyor";
        });
        return;
      }
    }
    setState(() {
      kullaniciAdiError = null;
      adSoyadError = null;
      eskiSifreError = null;
      yeniSifreError = null;
      yeniSifreTekrarError = null;
      error = null;
      succes = null;
    });
    String? duzenle = await BiltekPost.kullaniciDuzenle(
      id: widget.kullanici.id,
      adSoyad: adSoyad,
      kullaniciAdiOrjinal: widget.kullanici.kullaniciAdi,
      kullaniciAdi: kullaniciAdi,
      eskiSifre: eskiSifre,
      yeniSifre: yeniSifre,
      yeniSifreTekrar: yeniSifreTekrar,
    );
    if (duzenle != null) {
      setState(() {
        error = duzenle;
        succes = null;
      });
    } else {
      setState(() {
        error = null;
        succes = "Kullanıcı başarıyla düzenlendi";
        girildi = false;
      });
      if (mounted) {
        RestartWidget.restartApp(context);
      }
    }
  }
}
