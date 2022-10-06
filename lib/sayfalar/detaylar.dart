import 'package:flutter/material.dart';

import 'sayfa.dart';
import 'statefulwidget.dart';

class CihazDetaylari extends VarsayilanStatefulWidget {
  const CihazDetaylari({
    super.key,
    required this.direktGiris,
    required this.servisNo,
  });

  final bool direktGiris;
  final String servisNo;

  static const String yol = "/detaylar";
  static String argumanlar({
    String servisNo = "",
  }) {
    if (servisNo.isEmpty) {
      return "/:servisNo";
    } else {
      return "/$servisNo";
    }
  }

  @override
  VarsayilanStatefulWidgetState<CihazDetaylari> createState() =>
      CihazDetaylariState();
}

class CihazDetaylariState
    extends VarsayilanStatefulWidgetState<CihazDetaylari> {
  @override
  Widget build(BuildContext context) {
    return Sayfa(
      direktGiris: widget.direktGiris,
      kapatButonuGoster: true,
      baslik: "Cihaz ${widget.servisNo} Detayları",
      icerik: Center(
        child: Text("ID: ${widget.servisNo}"),
      ),
    );
  }
}
