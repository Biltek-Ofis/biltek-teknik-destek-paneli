import 'package:flutter/material.dart';

import 'database/login.dart';
import 'home.dart';
import 'utils/asset.dart';
import 'utils/device.dart';
import 'utils/sp.dart';
import 'widgets/buttons.dart';
import 'widgets/forms.dart';

class GirisYap extends StatefulWidget {
  const GirisYap({super.key});

  @override
  State<GirisYap> createState() => _GirisYapState();
}

class _GirisYapState extends State<GirisYap> {
  final TextEditingController kullaniciAdiController = TextEditingController();
  final TextEditingController sifreController = TextEditingController();

  final FocusNode kullaniciAdiFocus = FocusNode();
  final FocusNode sifreFocus = FocusNode();

  String girisHatasi = "";
  @override
  Widget build(BuildContext context) {
    final genislik = Device.isMobile()
        ? MediaQuery.of(context).size.width - 100
        : MediaQuery.of(context).size.width / 3;
    return Scaffold(
      body: Container(
        padding: EdgeInsets.zero,
        alignment: Alignment.center,
        width: MediaQuery.of(context).size.width,
        height: MediaQuery.of(context).size.height,
        child: SingleChildScrollView(
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              Image.asset(
                Asset.of.image.logo,
                width: genislik,
              ),
              const SizedBox(
                height: 10,
              ),
              if (girisHatasi.isNotEmpty)
                Container(
                  width: genislik,
                  padding: const EdgeInsets.all(7),
                  decoration: const BoxDecoration(
                      color: Colors.red, shape: BoxShape.rectangle),
                  child: Center(
                    child: Text(
                      girisHatasi,
                      style: const TextStyle(color: Colors.white, fontSize: 15),
                    ),
                  ),
                ),
              if (girisHatasi.isNotEmpty)
                const SizedBox(
                  height: 7,
                ),
              TextFieldDef(
                width: genislik,
                height: 50,
                textController: kullaniciAdiController,
                currentFocus: kullaniciAdiFocus,
                nextFocus: sifreFocus,
                onChanged: (value) {
                  setState(() {
                    girisHatasi = "";
                  });
                },
                labelText: "Kullanıcı Adı",
              ),
              const SizedBox(
                height: 7,
              ),
              TextFieldDef(
                width: genislik,
                height: 50,
                textController: sifreController,
                currentFocus: sifreFocus,
                onChanged: (value) {
                  setState(() {
                    girisHatasi = "";
                  });
                },
                onSubmit: () async {
                  await girisYap();
                },
                labelText: "Şifre",
                isPassword: true,
              ),
              const SizedBox(
                height: 7,
              ),
              buttonDef(
                width: genislik - 30,
                height: 50,
                fontSize: 17,
                text: "Giriş Yap",
                onPressed: () async {
                  await girisYap();
                },
              ),
            ],
          ),
        ),
      ),
    );
  }

  Future<void> girisYap() async {
    await LoginSQL.girisYap(
      kullaniciAdi: kullaniciAdiController.text,
      sifre: sifreController.text,
      beforeLogin: () {
        setState(() {
          girisHatasi = "";
        });
      },
      onLoginSuccess: (kullaniciID) {
        SharedPref.girisDurumuEkle(kullaniciID).then((value) {
          if (value) {
            Navigator.pushAndRemoveUntil(
              context,
              MaterialPageRoute(
                builder: (context) => const Anasayfa(),
              ),
              (route) => false,
            );
          } else {
            setState(() {
              girisHatasi = "Bir hata oluştu! Lütfen tekrar deneyin!";
            });
          }
        });
      },
      onLoginError: (mesaj, printMsj) {
        setState(() {
          girisHatasi = mesaj;
        });
      },
    );
  }
}
