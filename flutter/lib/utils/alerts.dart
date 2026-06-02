import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:in_app_update/in_app_update.dart';
import 'package:universal_io/universal_io.dart';
import 'package:url_launcher/url_launcher.dart';

import '../ayarlar.dart';
import 'post.dart';

class Alerts {
  final BuildContext context;

  Alerts._(this.context);

  static Alerts of(BuildContext context) {
    return Alerts._(context);
  }

  Future<void> guncelleme() async {
    AppUpdateInfo? updateInfo;
    bool guncelle;
    if (kIsWeb) {
      guncelle = false;
    } else if (Platform.isAndroid) {
      updateInfo = await InAppUpdate.checkForUpdate();
      guncelle =
          updateInfo.updateAvailability == UpdateAvailability.updateAvailable;
    } else {
      guncelle = await BiltekPost.guncellemeGerekli();
    }
    if (guncelle && context.mounted) {
      showDialog(
        context: context,
        barrierDismissible: false,
        builder: (context) {
          return AlertDialog(
            title: Text("Güncelleme Mevcut"),
            content: Text(
              "Uygulamanın güncel bir sürümü mevcut. Şimdi güncellemek ister misiniz?",
            ),
            actions: [
              TextButton(
                onPressed: () async {
                  bool didUpdate = false;
                  if (Platform.isAndroid) {
                    if (updateInfo?.immediateUpdateAllowed == true) {
                      didUpdate = true;
                      await InAppUpdate.performImmediateUpdate();
                    } else if (updateInfo?.flexibleUpdateAllowed == true) {
                      didUpdate = true;
                      await InAppUpdate.startFlexibleUpdate();
                      await InAppUpdate.completeFlexibleUpdate();
                    }
                  }
                  if (!didUpdate) {
                    Uri url = Uri.parse(Ayarlar.download);
                    if (await canLaunchUrl(url)) {
                      await launchUrl(
                        url,
                        mode: LaunchMode.externalApplication,
                      );
                    }
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
}

void yukleniyor(BuildContext context) {
  showDialog(
    context: context,
    barrierDismissible: false,
    builder: (context) {
      return AlertDialog(
        content: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          mainAxisSize: MainAxisSize.min,
          children: <Widget>[
            SizedBox(width: 40, height: 40, child: CircularProgressIndicator()),
          ],
        ),
      );
    },
  );
}
