import 'package:flutter/material.dart';
import 'package:package_info_plus/package_info_plus.dart';

import '../../ayarlar.dart';
import '../../widgets/list.dart';

class HakkindaSayfasi extends StatefulWidget {
  const HakkindaSayfasi({super.key});

  @override
  State<HakkindaSayfasi> createState() => _HakkindaSayfasiState();
}

class _HakkindaSayfasiState extends State<HakkindaSayfasi> {
  String versiyon = "";

  initState() {
    super.initState();
    Future.delayed(Duration.zero, () async {
      PackageInfo packageInfo = await PackageInfo.fromPlatform();
      setState(() {
        versiyon = packageInfo.version;
      });
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("Hakkında")),
      resizeToAvoidBottomInset: false,
      body: SafeArea(
        child: SizedBox(
          width: MediaQuery.of(context).size.width,
          child: ListView(
            children: [
              BiltekListTile(title: "Versiyon", subtitle: versiyon),
              BiltekListTile(
                title: "Derleme Tarihi",
                subtitle: Ayarlar.derlemeTarihi,
              ),
            ],
          ),
        ),
      ),
    );
  }
}
