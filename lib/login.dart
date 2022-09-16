import 'package:flutter/material.dart';

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
              TextFieldDef(
                width: genislik,
                height: 50,
                textController: kullaniciAdiController,
                currentFocus: kullaniciAdiFocus,
                nextFocus: sifreFocus,
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
                onSubmit: () {
                  SharedPref.girisYap(
                    kullaniciAdi: kullaniciAdiController.text,
                    sifre: sifreController.text,
                  );
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
                onPressed: () {
                  SharedPref.girisYap(
                    kullaniciAdi: kullaniciAdiController.text,
                    sifre: sifreController.text,
                  );
                },
              ),
            ],
          ),
        ),
      ),
    );
  }
}
