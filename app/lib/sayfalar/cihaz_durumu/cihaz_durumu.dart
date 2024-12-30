import 'package:biltekteknikservis/utils/islemler.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../../models/cihaz.dart';
import '../../utils/my_notifier.dart';

class CihazDurumu extends StatelessWidget {
  const CihazDurumu({
    super.key,
    required this.cihaz,
  });

  final Cihaz cihaz;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Cihaz Durumu"),
      ),
      body: Consumer<MyNotifier>(
          builder: (context, MyNotifier myNotifier, child) {
        var brightness = MediaQuery.of(context).platformBrightness;
        Color renk = myNotifier.isDark != null
            ? (myNotifier.isDark! ? Colors.white : Colors.black)
            : (brightness == Brightness.dark ? Colors.white : Colors.black);
        return Container(
          width: MediaQuery.of(context).size.width,
          padding: EdgeInsets.all(10),
          child: Card(
            surfaceTintColor: renk,
            shadowColor: renk,
            child: SingleChildScrollView(
              scrollDirection: Axis.vertical,
              child: Column(
                mainAxisSize: MainAxisSize.min,
                children: [
                  ListTile(
                    title: Text("Servis No"),
                    subtitle: Text(cihaz.servisNo.toString()),
                  ),
                  ListTile(
                    title: Text("Takip No"),
                    subtitle: Text(cihaz.takipNumarasi.toString()),
                  ),
                  ListTile(
                    title: Text("Güncel Durum"),
                    subtitle: Text(cihaz.guncelDurumText),
                  ),
                  ListTile(
                    title: Text("Arıza Açıklaması"),
                    subtitle: Text(cihaz.arizaAciklamasi),
                  ),
                  ListTile(
                    title: Text(
                      "Servis Türü",
                    ),
                    subtitle: Text(Islemler.servisTuru(cihaz.servisTuru)),
                  ),
                  ListTile(
                    title: Text("Müşteri Bilgileri"),
                    subtitle: Text(cihaz.musteriAdi),
                  ),
                  ListTile(
                    title: Text("Teslim Eden"),
                    subtitle: Text(cihaz.teslimEden),
                  ),
                  ListTile(
                    title: Text("Teslim Alan"),
                    subtitle: Text(cihaz.teslimAlan),
                  ),
                  ListTile(
                    title: Text("Cihaz Türü"),
                    subtitle: Text(cihaz.cihazTuru),
                  ),
                  ListTile(
                    title: Text("Cihaz Marka / Model"),
                    subtitle: Text(
                        "${cihaz.cihaz}${(cihaz.cihazModeli.trim().isNotEmpty ? " - ${cihaz.cihazModeli}" : "")}"),
                  ),
                  ListTile(
                    title: Text("Seri No"),
                    subtitle: Text(cihaz.seriNo),
                  ),
                  ListTile(
                    title: Text("Teslim Alınanlar"),
                    subtitle: Text(cihaz.teslimAlinanlar),
                  ),
                ],
              ),
            ),
          ),
        );
      }),
    );
  }
}
