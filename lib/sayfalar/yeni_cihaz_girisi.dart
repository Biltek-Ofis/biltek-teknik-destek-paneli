import 'package:biltekbilgisayar/sayfalar/sayfa.dart';
import 'package:flutter/material.dart';

import 'statefulwidget.dart';

class YeniCihazGirisi extends VarsayilanStatefulWidget {
  const YeniCihazGirisi({
    super.key,
    required this.direktGiris,
  });

  static const String yol = "/cihazgirisi";

  final bool direktGiris;

  @override
  VarsayilanStatefulWidgetState<YeniCihazGirisi> createState() =>
      YeniCihazGirisiState();
}

class YeniCihazGirisiState
    extends VarsayilanStatefulWidgetState<YeniCihazGirisi> {
  @override
  Widget build(BuildContext context) {
    return Sayfa(
      direktGiris: widget.direktGiris,
      kapatButonuGoster: true,
      baslik: "Yeni Cihaz Girişi",
      icerik: const Center(
        child: Text("Yeni Cihaz Girişi"),
      ),
    );
  }
}
