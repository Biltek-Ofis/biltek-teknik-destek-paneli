import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

import 'widget.dart';

Future<T?> showTakvim<T>(
  context, {
  required DateTime initialDate,
  Function(DateTime?)? onSelection,
  Function(DateTime?)? onConfirm,
}) {
  return showDialog(
    context: context,
    builder: (context) {
      return TakvimSecici(
        initialDate: initialDate,
        minYear: DateTime.now()
            .subtract(
              Duration(days: 365 * 5),
            )
            .year,
        maxYear: DateTime.now()
            .add(
              Duration(days: 365 * 5),
            )
            .year,
        onSelection: onSelection,
        onConfirm: onConfirm,
        use24hFormat: true,
        monthYearMode: CupertinoDatePickerMode.date,
        barColor: Theme.of(context).scaffoldBackgroundColor,
        fontColor: Theme.of(context).textTheme.bodyLarge?.color,
        action: true,
      );
    },
  );
}
