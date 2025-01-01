import 'dart:convert';

import 'package:biltekteknikservis/sayfalar/cihaz_durumu/cihaz_durumu_giris.dart';
import 'package:biltekteknikservis/sayfalar/cihazlarim.dart';
import 'package:biltekteknikservis/utils/alerts.dart';
import 'package:biltekteknikservis/utils/islemler.dart';
import 'package:biltekteknikservis/widgets/input.dart';
import 'package:flutter/material.dart';

import '../ayarlar.dart';
import '../models/giris.dart';
import '../models/kullanici.dart';
import '../utils/assets.dart';
import '../utils/buttons.dart';
import '../utils/post.dart';
import '../utils/shared_preferences.dart';
import 'anasayfa.dart';

class GirisSayfasi extends StatefulWidget {
  const GirisSayfasi({super.key});

  @override
  State<GirisSayfasi> createState() => _GirisSayfasiState();
}

class _GirisSayfasiState extends State<GirisSayfasi> {
  TextEditingController kullaniciAdiController = TextEditingController();
  FocusNode kullaniciAdiFocus = FocusNode();
  TextEditingController sifreController = TextEditingController();
  FocusNode sifreFocus = FocusNode();
  bool sifreyiGoster = false;

  String hataMesaji = "";
  String? kullaniciAdiError;
  String? sifreError;

  @override
  void initState() {
    super.initState();
    Future.delayed(Duration.zero, () async {
      if (mounted) {
        FocusScope.of(context).requestFocus(kullaniciAdiFocus);
        Alerts alerts = Alerts.of(context);
        bool guncelleme = await BiltekPost.guncellemeGerekli();
        if (guncelleme) {
          alerts.guncelleme();
        }
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        alignment: Alignment.center,
        padding: EdgeInsets.all(10),
        child: SizedBox(
          width: MediaQuery.of(context).size.width > 400
              ? 400
              : MediaQuery.of(context).size.width,
          child: Column(
            mainAxisAlignment: MainAxisAlignment.end,
            children: [
              Image.asset(BiltekAssets.logo),
              Text(
                hataMesaji,
                style: TextStyle(color: Colors.red),
              ),
              SizedBox(
                height: 10,
              ),
              BiltekTextField(
                controller: kullaniciAdiController,
                currentFocus: kullaniciAdiFocus,
                nextFocus: sifreFocus,
                label: "Kullanıcı Adı",
                errorText: kullaniciAdiError,
                onChanged: (value) {
                  setState(() {
                    kullaniciAdiError = null;
                    hataMesaji = "";
                  });
                },
              ),
              SizedBox(
                height: 10,
              ),
              BiltekSifre(
                controller: sifreController,
                currentFocus: sifreFocus,
                label: "Şifre",
                errorText: sifreError,
                onChanged: (value) {
                  setState(() {
                    sifreError = null;
                    hataMesaji = "";
                  });
                },
                onSubmitted: (val) async {
                  await _girisYap();
                },
              ),
              SizedBox(
                height: 10,
              ),
              SizedBox(
                width: MediaQuery.of(context).size.width,
                height: 50,
                child: DefaultButton(
                  onPressed: () async {
                    await _girisYap();
                  },
                  text: "Giriş Yap",
                ),
              ),
              SizedBox(
                height: 10,
              ),
              SizedBox(
                width: MediaQuery.of(context).size.width,
                height: 50,
                child: DefaultButton(
                  background: Islemler.arkaRenk(
                    "bg-info",
                    alpha: 255,
                  ),
                  onPressed: () {
                    Navigator.of(context).push(
                      MaterialPageRoute(
                        builder: (context) => CihazDurumuGiris(),
                      ),
                    );
                  },
                  text: "Cihaz Durumunu Görüntüle",
                ),
              ),
              SizedBox(
                height: 10,
              ),
            ],
          ),
        ),
      ),
    );
  }

  Future<void> _girisYap() async {
    setState(() {
      kullaniciAdiError = null;
      sifreError = null;
      hataMesaji = "";
    });
    NavigatorState navigatorState = Navigator.of(context);
    yukleniyor(context);
    bool kapatildi = false;
    String kullaniciAdi = kullaniciAdiController.text;
    String sifre = sifreController.text;
    if (kullaniciAdi.isEmpty && sifre.isEmpty) {
      setState(() {
        kullaniciAdiError = "Kullanıcı Adı boş olamaz!";
        sifreError = "Şifre boş olamaz!";
      });
      return;
    }
    if (kullaniciAdi.isNotEmpty) {
      if (sifre.isNotEmpty) {
        Map<String, String> postData = {
          "kullaniciAdi": kullaniciAdi,
          "sifre": sifre,
        };
        String? cihazID = await Islemler.getId();
        if (cihazID == null) {
          setState(() {
            hataMesaji = "Uygulama şuanda bu platforda desteklenmiyor.";
          });
          return;
        }

        postData["cihazID"] = cihazID;

        String? fcmToken =
            await SharedPreference.getString(SharedPreference.fcmTokenString);
        if (fcmToken != null) {
          postData["fcmToken"];
        }
        var response = await BiltekPost.post(
          Ayarlar.girisYap,
          postData,
        );
        if (response.statusCode == 201) {
          var resp = await response.stream.bytesToString();
          try {
            GirisDurumu girisDurumu =
                GirisDurumu.fromJson(jsonDecode(resp) as Map<String, dynamic>);
            if (girisDurumu.durum && girisDurumu.auth.isNotEmpty) {
              await SharedPreference.setString(
                  SharedPreference.authString, girisDurumu.auth);
              KullaniciModel? kullaniciModel =
                  await BiltekPost.kullaniciGetir(girisDurumu.auth);
              if (kullaniciModel != null) {
                kapatildi = true;
                navigatorState.pop();
                navigatorState.pushAndRemoveUntil(
                  MaterialPageRoute(
                    builder: (context) => kullaniciModel.teknikservis
                        ? CihazlarimSayfasi(
                            kullanici: kullaniciModel,
                          )
                        : Anasayfa(
                            kullanici: kullaniciModel,
                          ),
                  ),
                  (Route<dynamic> route) => false,
                );
              } else {
                setState(() {
                  hataMesaji =
                      "Bir hata oluştu. Lütfen daha sonra tekrar deneyin.";
                });
              }
            } else {
              setState(() {
                hataMesaji = "Kullanıcı adı veya şifre yanlış";
              });
            }
          } on Exception {
            try {
              HataDurumu hataDurumu =
                  HataDurumu.fromJson(jsonDecode(resp) as Map<String, dynamic>);
              setState(() {
                hataMesaji = hataDurumu.mesaj;
              });
            } on Exception {
              setState(() {
                hataMesaji =
                    "Bir hata oluştu. Lütfen daha sonra tekrar deneyin.";
              });
            }
          }
        } else {
          // If the server did not return a 201 CREATED response,
          // then throw an exception.
          setState(() {
            hataMesaji = "Bir hata oluştu. Lütfen daha sonra tekrar deneyin.";
          });
        }
      } else {
        setState(() {
          sifreError = "Şifre boş olamaz!";
        });
      }
    } else {
      setState(() {
        kullaniciAdiError = "Kullanıcı Adı boş olamaz!";
      });
    }
    if (!kapatildi) {
      navigatorState.pop();
    }
  }
}
