import 'package:biltekteknikservis/ayarlar.dart';
import 'package:flutter/material.dart';
import 'package:url_launcher/url_launcher.dart';

class Alerts {
  final BuildContext context;

  Alerts._(this.context);

  static Alerts of(BuildContext context) {
    return Alerts._(context);
  }

  void guncelleme() {
    showDialog(
      context: context,
      barrierDismissible: false,
      builder: (context) {
        return AlertDialog(
          title: Text("Güncelleme Mevcut"),
          content: Text(
              "Uygulamanın güncel bir sürümü mevcut. Şimdi güncellemek ister misiniz?"),
          actions: [
            TextButton(
              onPressed: () async {
                Uri url = Uri.parse(Ayarlar.download);
                if (await canLaunchUrl(url)) {
                  await launchUrl(
                    url,
                    mode: LaunchMode.externalApplication,
                  );
                }
              },
              child: Text("Güncelle"),
            ),
            TextButton(
              onPressed: () {
                Navigator.pop(context);
              },
              child: Text("Hayır"),
            ),
          ],
        );
      },
    );
  }
}
