import 'package:flutter/cupertino.dart';
import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:flutter_ringtone_player/flutter_ringtone_player.dart';
import 'package:overlay_support/overlay_support.dart';
import 'package:universal_io/io.dart';

void showNotification({String? title, String? body, Duration? duration}) {
  if (!kIsWeb && (Platform.isAndroid || Platform.isIOS)) {
    FlutterRingtonePlayer().playNotification();
  }
  showOverlayNotification(
    (context) {
      return Card(
        margin: const EdgeInsets.symmetric(horizontal: 4),
        child: SafeArea(
          child: ListTile(
            leading: SizedBox.fromSize(
              size: Size(title != null ? 40 : 20, title != null ? 40 : 20),
              child: ClipOval(child: Container(color: Colors.black)),
            ),
            title: Text(title ?? (body ?? "")),
            subtitle: title != null ? (body != null ? Text(body) : null) : null,
            trailing: IconButton(
              icon: Icon(CupertinoIcons.xmark),
              onPressed: () {
                OverlaySupportEntry.of(context)?.dismiss();
              },
            ),
          ),
        ),
      );
    },

    position: NotificationPosition.top,
    duration: duration ?? Duration(milliseconds: 4000),
  );
}

void toast(
  String message, {
  BuildContext? context,
  ScaffoldMessengerState? scaffoldMessenger,
}) {
  SnackBar snackBar = SnackBar(content: Text(message));
  if (context != null) {
    ScaffoldMessenger.of(context).showSnackBar(snackBar);
  } else if (scaffoldMessenger != null) {
    scaffoldMessenger.showSnackBar(snackBar);
  }
}
