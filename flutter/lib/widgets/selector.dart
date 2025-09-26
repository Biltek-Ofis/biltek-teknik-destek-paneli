import 'package:flutter/material.dart';

class SelectorItem<T> {
  final String text;
  final String? key;
  T value;

  SelectorItem({required this.text, required this.value, this.key});
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
    constraints: BoxConstraints(minWidth: double.infinity),
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
                leading: RadioGroup(
                  groupValue: currentValue,
                  onChanged: (val) {
                    onSelect?.call(val);
                  },
                  child: Radio(value: items[i].value),
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

void showCheckSelector<T>(
  BuildContext context, {
  required List<SelectorItem<bool>> items,
  OnSelect<List<SelectorItem<bool>>>? onSaveItems,
}) {
  showModalBottomSheet(
    context: context,
    constraints: BoxConstraints(minWidth: double.infinity),
    builder: (context) {
      return SelectorCheck(items: items, onSaveItems: onSaveItems);
    },
  );
}

class SelectorCheck extends StatefulWidget {
  const SelectorCheck({super.key, required this.items, this.onSaveItems});

  final List<SelectorItem<bool>> items;
  final OnSelect<List<SelectorItem<bool>>>? onSaveItems;
  @override
  State<SelectorCheck> createState() => _SelectorCheckState();
}

class _SelectorCheckState<T> extends State<SelectorCheck> {
  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(8.0),
      child: Column(
        children: [
          Expanded(
            child: SingleChildScrollView(
              scrollDirection: Axis.vertical,
              child: Column(
                mainAxisAlignment: MainAxisAlignment.end,
                crossAxisAlignment: CrossAxisAlignment.end,
                mainAxisSize: MainAxisSize.min,
                children: [
                  for (int i = 0; i < widget.items.length; i++)
                    ListTile(
                      title: Text(widget.items[i].text),
                      leading: Checkbox(
                        value: widget.items[i].value,
                        onChanged: (val) {
                          if (val == null) {
                            return;
                          }
                          setState(() {
                            widget.items[i].value = val;
                          });
                        },
                      ),
                      onTap: () {
                        setState(() {
                          widget.items[i].value = !widget.items[i].value;
                        });
                      },
                    ),
                ],
              ),
            ),
          ),
          Row(
            mainAxisAlignment: MainAxisAlignment.end,
            children: [
              TextButton(
                onPressed: () {
                  Navigator.of(context).pop();
                },
                child: Text("İptal"),
              ),
              TextButton(
                onPressed: () {
                  Navigator.pop(context);
                  widget.onSaveItems?.call(widget.items);
                },
                child: Text("Kaydet"),
              ),
            ],
          ),
        ],
      ),
    );
  }
}
