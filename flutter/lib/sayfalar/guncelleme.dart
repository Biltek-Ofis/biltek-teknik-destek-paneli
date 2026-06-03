import 'package:flutter/material.dart';
import 'package:in_app_update/in_app_update.dart';
import 'package:universal_io/universal_io.dart';
import 'package:url_launcher/url_launcher.dart';

import '../ayarlar.dart';
import '../utils/buttons.dart';

class GuncellemeSayfasi extends StatelessWidget {
  const GuncellemeSayfasi({super.key});

  @override
  Widget build(BuildContext context) {
    return SafeArea(
      child: Scaffold(
        body: Center(
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Text("Yeni sürüm mevcut. Lütfen güncelleyin."),
              SizedBox(height: 20),
              PrimaryButton(
                onPressed: () async {
                  bool canApiUpdate = true;
                  if (Platform.isAndroid) {
                    AppUpdateInfo updateInfo =
                        await InAppUpdate.checkForUpdate();
                    if (updateInfo.updateAvailability ==
                        UpdateAvailability.updateAvailable) {
                      canApiUpdate = false;
                      if (updateInfo.immediateUpdateAllowed == true) {
                        final result =
                            await InAppUpdate.performImmediateUpdate();
                        if (result == AppUpdateResult.success) {}
                      } else if (updateInfo.flexibleUpdateAllowed == true) {
                        final result = await InAppUpdate.startFlexibleUpdate();
                        if (result == AppUpdateResult.success) {
                          await InAppUpdate.completeFlexibleUpdate();
                        }
                      }
                    }
                  }
                  if (canApiUpdate) {
                    Uri url = Uri.parse(Ayarlar.download);
                    if (await canLaunchUrl(url)) {
                      await launchUrl(
                        url,
                        mode: LaunchMode.externalApplication,
                      );
                    }
                  }
                },
                label: "Güncelle",
              ),
            ],
          ),
        ),
      ),
    );
  }
}
