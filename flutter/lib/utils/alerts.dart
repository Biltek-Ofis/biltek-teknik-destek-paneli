import 'package:flutter/material.dart';

class Alerts {
  final BuildContext context;

  Alerts._(this.context);

  static Alerts of(BuildContext context) {
    return Alerts._(context);
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
