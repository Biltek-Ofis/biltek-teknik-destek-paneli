import 'package:flutter/material.dart';

class IslemlerModel {
  String islem;
  final TextEditingController islemController;
  final FocusNode islemFocusNode;
  int miktar;
  final TextEditingController miktarController;
  final FocusNode miktarFocusNode;
  String birimFiyati;
  final TextEditingController birimFiyatiController;
  final FocusNode birimFiyatiFocusNode;
  String kdv;
  final TextEditingController kdvController;
  final FocusNode kdvFocusNode;
  String? islemHata;
  String? miktarHata;
  String? birimFiyatiHata;

  String kdvStr = "";
  String kdvsizStr = "";
  String toplamStr = "";

  IslemlerModel._({
    required this.islem,
    required this.islemController,
    required this.islemFocusNode,
    required this.miktar,
    required this.miktarController,
    required this.miktarFocusNode,
    required this.birimFiyati,
    required this.birimFiyatiController,
    required this.birimFiyatiFocusNode,
    required this.kdv,
    required this.kdvController,
    required this.kdvFocusNode,
  });
  factory IslemlerModel.of({
    required String islem,
    required int miktar,
    required String birimFiyati,
    required String kdv,
  }) {
    return IslemlerModel._(
      islem: islem,
      islemController: TextEditingController(),
      islemFocusNode: FocusNode(),
      miktar: miktar,
      miktarController: TextEditingController(),
      miktarFocusNode: FocusNode(),
      birimFiyati: birimFiyati,
      birimFiyatiController: TextEditingController(),
      birimFiyatiFocusNode: FocusNode(),
      kdv: kdv,
      kdvController: TextEditingController(),
      kdvFocusNode: FocusNode(),
    );
  }
}
