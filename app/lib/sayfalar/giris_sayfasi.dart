import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:teknikservis/utils/assets.dart';

import '../ayarlar.dart';
import '../models/giris.dart';
import '../models/kullanici.dart';
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
  TextEditingController sifreController = TextEditingController();
  bool sifreyiGoster = false;

  String hataMesaji = "";
  String? kullaniciAdiError;
  String? sifreError;

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
              TextField(
                controller: kullaniciAdiController,
                onChanged: (value) {
                  setState(() {
                    kullaniciAdiError = null;
                    hataMesaji = "";
                  });
                },
                decoration: InputDecoration(
                  label: Text("Kullanıcı Adı"),
                  errorText: kullaniciAdiError,
                ),
              ),
              SizedBox(
                height: 10,
              ),
              TextField(
                controller: sifreController,
                onChanged: (value) {
                  setState(() {
                    sifreError = null;
                    hataMesaji = "";
                  });
                },
                decoration: InputDecoration(
                  label: Text("Şifre"),
                  errorText: sifreError,
                  suffix: IconButton(
                    onPressed: () {
                      setState(() {
                        sifreyiGoster = !sifreyiGoster;
                      });
                    },
                    icon: Icon(
                      sifreyiGoster ? Icons.visibility_off : Icons.visibility,
                    ),
                  ),
                ),
                obscureText: !sifreyiGoster,
                enableSuggestions: sifreyiGoster,
                autocorrect: sifreyiGoster,
              ),
              SizedBox(
                height: 10,
              ),
              SizedBox(
                width: MediaQuery.of(context).size.width,
                height: 50,
                child: ElevatedButton(
                  onPressed: () async {
                    setState(() {
                      kullaniciAdiError = null;
                      sifreError = null;
                      hataMesaji = "";
                    });
                    await _girisYap();
                  },
                  style: ButtonStyle(
                    backgroundColor: WidgetStateProperty.resolveWith<Color?>(
                      (Set<WidgetState> states) {
                        if (states.contains(WidgetState.pressed)) {
                          return Theme.of(context)
                              .colorScheme
                              .primary
                              .withAlpha(1);
                        }
                        return Theme.of(context)
                            .colorScheme
                            .primary; // Use the component's default.
                      },
                    ),
                  ),
                  child: Text(
                    "Giriş Yap",
                    style: TextStyle(
                      color: Colors.white,
                    ),
                  ),
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
    NavigatorState navigatorState = Navigator.of(context);
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
        var response = await BiltekPost.post(
          Ayarlar.girisYap,
          {
            "kullaniciAdi": kullaniciAdi,
            "sifre": sifre,
          },
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
                navigatorState.pushAndRemoveUntil(
                  MaterialPageRoute(
                    builder: (context) => Anasayfa(
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
          } on Exception catch (e) {
            debugPrint(e.toString());
            debugPrint(resp.toString());
            try {
              HataDurumu hataDurumu =
                  HataDurumu.fromJson(jsonDecode(resp) as Map<String, dynamic>);
              setState(() {
                hataMesaji = hataDurumu.mesaj;
              });
            } on Exception catch (e) {
              debugPrint(e.toString());
              setState(() {
                hataMesaji =
                    "Bir hata oluştu. Lütfen daha sonra tekrar deneyin.";
              });
            }
          }
        } else {
          // If the server did not return a 201 CREATED response,
          // then throw an exception.
          debugPrint("Bir hata oluştu. Response Code: ${response.statusCode}");
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
  }
}
