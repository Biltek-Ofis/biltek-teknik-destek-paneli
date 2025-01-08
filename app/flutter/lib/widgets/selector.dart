import 'package:flutter/material.dart';

class SelectorItem<T> {
  final String text;
  T value;

  SelectorItem({required this.text, required this.value});
}

typedef OnSelect<T> = Function(T value);

void showSelector<T>(
  BuildContext context, {
  required List<SelectorItem<T>> items,
  required T currentValue,
  OnSelect<T?>? onSelect,
}) {
  showModalBottomSheet(
    context: context,
    constraints: BoxConstraints(
      minWidth: double.infinity,
    ),
    builder: (context) {
      return Padding(
        padding: const EdgeInsets.all(8.0),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.end,
          crossAxisAlignment: CrossAxisAlignment.end,
          mainAxisSize: MainAxisSize.min,
          children: [
            for (int i = 0; i < items.length; i++)
              ListTile(
                title: Text(items[i].text),
                leading: Radio(
                  value: items[i].value,
                  groupValue: currentValue,
                  onChanged: (val) {
                    onSelect?.call(val);
                  },
                ),
                onTap: () {
                  currentValue = items[i].value;
                  onSelect?.call(items[i].value);
                },
              ),
          ],
        ),
      );
    },
  );
}
