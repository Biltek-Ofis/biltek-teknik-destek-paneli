import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:teknikservis/widgets/selector.dart';

import '../utils/my_notifier.dart';

class AyarlarSayfasi extends StatefulWidget {
  const AyarlarSayfasi({super.key});

  @override
  State<AyarlarSayfasi> createState() => _AyarlarSayfasiState();
}

class _AyarlarSayfasiState extends State<AyarlarSayfasi> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Ayarlar"),
      ),
      body: Consumer<MyNotifier>(
        builder: (context, MyNotifier myNotifier, child) {
          return SizedBox(
            width: MediaQuery.of(context).size.width,
            child: ListView(
              children: [
                ListTile(
                  title: Text("Tema"),
                  subtitleTextStyle: TextStyle(
                      color: Theme.of(context)
                          .textTheme
                          .bodySmall
                          ?.color
                          ?.withAlpha(200)),
                  subtitle: Container(
                    padding: EdgeInsets.only(left: 5),
                    child: myNotifier.isDark == null
                        ? Text("Sistem Varsayılanı")
                        : (myNotifier.isDark == true
                            ? Text("Karanlık")
                            : Text("Aydınlık")),
                  ),
                  onTap: () {
                    showSelector<bool?>(
                      context,
                      items: [
                        SelectorItem(text: "Sistem Varsayılanı", value: null),
                        SelectorItem(text: "Aydınlık", value: false),
                        SelectorItem(text: "Karanlık", value: true),
                      ],
                      currentValue: myNotifier.isDark,
                      onSelect: (value) {
                        myNotifier.isDark = value;
                      },
                    );
                  },
                )
              ],
            ),
          );
        },
      ),
    );
  }
}
