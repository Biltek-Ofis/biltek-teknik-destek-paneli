import 'package:biltekteknikservis/widgets/list.dart';
import 'package:flutter/material.dart';

class BildirimAyarlari extends StatefulWidget {
  const BildirimAyarlari({super.key});

  @override
  State<BildirimAyarlari> createState() => _BildirimAyarlariState();
}

class _BildirimAyarlariState extends State<BildirimAyarlari> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("Bildirim Ayarları")),
      body: SizedBox(
        width: MediaQuery.of(context).size.width,
        child: ListView(
          children: [
            BiltekListTile(
              title: "Cihaz Bildirimleri",
              subtitle:
                  "Sorumlu personel olarak seçildiğiniz cihazlarla ilgili bildirimler.",
              trailing: Text("Açık"),
              onTap: () {},
            ),
          ],
        ),
      ),
    );
  }
}
