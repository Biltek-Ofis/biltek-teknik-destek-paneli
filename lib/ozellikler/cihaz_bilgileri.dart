import 'package:flutter/material.dart';

arrayGetir(List array, int index) {
  return index > array.length - 1 ? array[0] : array[index];
}

String servisTuru(int index) {
  switch (index) {
    case 1:
      return "GARANTİ KAPSAMINDA BAKIM/ONARIM";
    case 2:
      return "ANLAŞMALI BAKIM/ONARIM";
    case 3:
      return "ÜCRETLİ BAKIM/ONARIM";
    case 4:
      return "ÜCRETLİ ARIZA TESPİTİ";
    default:
      return "Belirtilmemiş";
  }
}

final hasarDurumu = ["Yok", "Hasarlı", "Hasarsız"];

String hasarDurumuGetir(int index) {
  return arrayGetir(hasarDurumu, index);
}

final evetHayir = ["Belirtilmemiş", "Evet", "Hayır"];

String evetHayirGetir(int index) {
  return arrayGetir(evetHayir, index);
}

final cihazdakiHasar = ["Belirtilmemiş", "Çizik", "Kırık", "Çatlak", "Diğer"];

String cihazdakiHasarGetir(int index) {
  return arrayGetir(cihazdakiHasar, index);
}

final cihazDurumu = [
  "Sırada Bekliyor",
  "Arıza Tespiti Yapılıyor",
  "Yedek Parça Bekleniyor",
  "Merkez Servise Gönderildi",
  "Fiyat Onayı Bekleniyor",
  "Fiyat Onaylandı",
  "Fiyat Onaylanmadı",
  "Teslim Edilmeye Hazır",
  "Teslim Edildi / Ödeme Alınmadı",
  "Teslim Edildi"
];
final cihazDurumuSiralama = [1, 2, 3, 5, 4, 6, 7, 8, 9, 10];
int cihazDurumuSiralamaGetir(int index) {
  return arrayGetir(cihazDurumuSiralama, index);
}

double transparan = .3;
double transparanKirmizi = .4;
Color turuncu = Color.fromRGBO(255, 193, 7, transparan);
Color pembe = Color.fromRGBO(232, 62, 140, transparan);
Color mavi = Color.fromRGBO(0, 123, 255, transparan);
Color kirmizi = Color.fromRGBO(220, 53, 69, transparanKirmizi);
Color yesil = Color.fromRGBO(40, 167, 69, transparan);
List<Color> cihazDurumuColor = [
  turuncu,
  turuncu,
  turuncu,
  pembe,
  turuncu,
  mavi,
  kirmizi,
  mavi,
  kirmizi,
  yesil
];
String cihazDurumuGetir(int index) {
  return arrayGetir(cihazDurumu, index);
}

Color cihazDurumuColorGetir(int index) {
  return arrayGetir(cihazDurumuColor, index);
}

final tahsilatSekli = ["", "Nakit", "Kredi Kartı", "Mail Order", "Açık Hesap"];
String tahsilatSekliGetir(int index) {
  return arrayGetir(tahsilatSekli, index);
}
