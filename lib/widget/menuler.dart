import 'package:flutter/material.dart';

import '../model/menu.dart';
import '../ozellikler/yonlendirme.dart';
import '../sayfalar/anasayfa.dart';
import '../sayfalar/cihazlarim.dart';
import '../sayfalar/statefulwidget.dart';

List<AnaMenuModel> anaMenuOgeler(BuildContext context) {
  return [
    AnaMenuModel(
      icon: Icons.home,
      baslik: "Anasayfa",
      onPressed: () {
        Yonlendirme.git(
          context,
          Anasayfa.yol,
          clearStack: true,
        );
      },
    ),
    AnaMenuModel(
      icon: Icons.device_hub,
      baslik: "Cihazlarım",
      onPressed: () {
        Yonlendirme.git(
          context,
          Cihazlarim.yol,
          clearStack: true,
        );
      },
    ),
  ];
}

class AnaMenu extends StatelessWidget {
  const AnaMenu({
    super.key,
    this.seciliSayfa,
  });

  final String? seciliSayfa;

  @override
  Widget build(BuildContext context) {
    return Container(
      color: const Color(0xFF343A40),
      child: ListView(
        padding: EdgeInsets.zero,
        children: [
          for (var sayfa in anaMenuOgeler(context))
            AnaMenuListTile(
              sayfa: sayfa,
              seciliSayfa: seciliSayfa,
            ),
        ],
      ),
    );
  }
}

class AnaMenuListTile extends VarsayilanStatefulWidget {
  const AnaMenuListTile({
    super.key,
    required this.sayfa,
    this.seciliSayfa,
  });

  final AnaMenuModel sayfa;
  final String? seciliSayfa;
  @override
  State<AnaMenuListTile> createState() => _AnaMenuListTileState();
}

class _AnaMenuListTileState
    extends VarsayilanStatefulWidgetState<AnaMenuListTile> {
  Color? varsayilanArkaplanRengi;
  Color? varsayilanYaziRengi = const Color(0xFFC2C7d0);

  Color? hoverArkaplanRengi = const Color.fromRGBO(255, 255, 255, 0.1);
  Color? hoverYaziRengi = const Color(0xFFFFFFFF);

  Color? seciliArkaplanRengi = const Color(0xFF007Bff);
  Color? seciliYaziRengi = const Color(0xFFFFFFFF);

  Color? guncelArkaplanRengi;
  Color? guncelYaziRengi;

  @override
  void initState() {
    Future.delayed(Duration.zero, () {
      if (widget.sayfa.baslik == widget.seciliSayfa) {
        setState(() {
          guncelArkaplanRengi = seciliArkaplanRengi;
          guncelYaziRengi = seciliYaziRengi;
        });
      } else {
        setState(() {
          guncelArkaplanRengi = varsayilanArkaplanRengi;
          guncelYaziRengi = varsayilanYaziRengi;
        });
      }
    });
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return ListTile(
      title: InkWell(
        onHover: (hover) {
          if (hover) {
            setState(() {
              guncelArkaplanRengi = hoverArkaplanRengi;
              guncelYaziRengi = hoverYaziRengi;
            });
          } else {
            setState(() {
              guncelArkaplanRengi = varsayilanArkaplanRengi;
              guncelYaziRengi = varsayilanYaziRengi;
            });
          }
        },
        onTap: widget.sayfa.baslik != widget.seciliSayfa
            ? widget.sayfa.onPressed
            : null,
        child: Container(
          width: MediaQuery.of(context).size.width,
          padding: const EdgeInsets.all(5),
          decoration: BoxDecoration(
            color: widget.sayfa.baslik == widget.seciliSayfa
                ? seciliArkaplanRengi
                : guncelArkaplanRengi,
            shape: BoxShape.rectangle,
            borderRadius: BorderRadius.circular(7),
          ),
          child: Row(
            children: [
              Icon(
                widget.sayfa.icon,
                color: widget.sayfa.baslik == widget.seciliSayfa
                    ? seciliYaziRengi
                    : guncelYaziRengi,
              ),
              const SizedBox(
                width: 5,
              ),
              Text(
                widget.sayfa.baslik,
                style: TextStyle(
                  color: widget.sayfa.baslik == widget.seciliSayfa
                      ? seciliYaziRengi
                      : guncelYaziRengi,
                  fontSize: 15,
                ),
              )
            ],
          ),
        ),
      ),
    );
  }
}
