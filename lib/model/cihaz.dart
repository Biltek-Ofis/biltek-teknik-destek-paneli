import "package:decimal/decimal.dart";
import 'package:turkish/turkish.dart';

import '../ozellikler/cihaz_bilgileri.dart';
import "../ozellikler/degiskenler.dart";

typedef Sirala = void Function(CihazSiralama konum, bool artan);

enum CihazSiralama {
  varsayilan,
  servisNo,
  musteriAdi,
  tur,
  cihazVeModel,
  tarih,
  sorumlu,
}

class CihazModel {
  CihazModel({
    required this.id,
    required this.servisNo,
    required this.takipNumarasi,
    required this.musteriKod,
    required this.musteriAdi,
    required this.adres,
    required this.telefonNumarasi,
    required this.cihazTuru,
    required this.sorumlu,
    required this.cihaz,
    required this.cihazModeli,
    required this.seriNo,
    required this.cihazSifresi,
    required this.hasarTespiti,
    required this.cihazdakiHasar,
    required this.arizaAciklamasi,
    required this.servisTuru,
    required this.yedekDurumu,
    required this.teslimAlinanlar,
    required this.yapilanIslemAciklamasi,
    required this.teslimEdildi,
    required this.tarih,
    required this.bildirimTarihi,
    required this.cikisTarihi,
    required this.guncelDurum,
    required this.tahsilatSekli,
    required this.iStokKod1,
    required this.iAd1,
    required this.iBirimFiyat1,
    required this.iMiktar1,
    required this.iKdv1,
    required this.iStokKod2,
    required this.iAd2,
    required this.iBirimFiyat2,
    required this.iMiktar2,
    required this.iKdv2,
    required this.iStokKod3,
    required this.iAd3,
    required this.iBirimFiyat3,
    required this.iMiktar3,
    required this.iKdv3,
    required this.iStokKod4,
    required this.iAd4,
    required this.iBirimFiyat4,
    required this.iMiktar4,
    required this.iKdv4,
    required this.iStokKod5,
    required this.iAd5,
    required this.iBirimFiyat5,
    required this.iMiktar5,
    required this.iKdv5,
    required this.iStokKod6,
    required this.iAd6,
    required this.iBirimFiyat6,
    required this.iMiktar6,
    required this.iKdv6,
  });
  final int id;
  final String servisNo;
  final int takipNumarasi;
  final String musteriKod;
  final String musteriAdi;
  final String adres;
  final String telefonNumarasi;
  final String cihazTuru;
  final String sorumlu;
  final String cihaz;
  final String cihazModeli;
  final String seriNo;
  final String cihazSifresi;
  final String hasarTespiti;
  final int cihazdakiHasar;
  final String arizaAciklamasi;
  final int servisTuru;
  final int yedekDurumu;
  final String teslimAlinanlar;
  final String yapilanIslemAciklamasi;
  final int teslimEdildi;
  final String tarih;
  final String bildirimTarihi;
  final String cikisTarihi;
  final int guncelDurum;
  final int tahsilatSekli;
  final String iStokKod1;
  final String iAd1;
  final Decimal iBirimFiyat1;
  final int iMiktar1;
  final Decimal iKdv1;
  final String iStokKod2;
  final String iAd2;
  final Decimal iBirimFiyat2;
  final int iMiktar2;
  final Decimal iKdv2;
  final String iStokKod3;
  final String iAd3;
  final Decimal iBirimFiyat3;
  final int iMiktar3;
  final Decimal iKdv3;
  final String iStokKod4;
  final String iAd4;
  final Decimal iBirimFiyat4;
  final int iMiktar4;
  final Decimal iKdv4;
  final String iStokKod5;
  final String iAd5;
  final Decimal iBirimFiyat5;
  final int iMiktar5;
  final Decimal iKdv5;
  final String iStokKod6;
  final String iAd6;
  final Decimal iBirimFiyat6;
  final int iMiktar6;
  final Decimal iKdv6;

  factory CihazModel.fromJson(Map<String, dynamic> jsonData) {
    return CihazModel(
      id: Degiskenler.parseInt(sayi: jsonData[idStr]),
      servisNo: Degiskenler.parseString(yazi: jsonData[servisNoStr]),
      takipNumarasi: Degiskenler.parseInt(sayi: jsonData[takipNumarasiStr]),
      musteriKod: Degiskenler.parseString(yazi: jsonData[musteriKodStr]),
      musteriAdi: Degiskenler.parseString(yazi: jsonData[musteriAdiStr]),
      adres: Degiskenler.parseString(yazi: jsonData[adresStr]),
      telefonNumarasi:
          Degiskenler.parseString(yazi: jsonData[telefonNumarasiStr]),
      cihazTuru: Degiskenler.parseString(yazi: jsonData[cihazTuruStr]),
      sorumlu: Degiskenler.parseString(yazi: jsonData[sorumluStr]),
      cihaz: Degiskenler.parseString(yazi: jsonData[cihazStr]),
      cihazModeli: Degiskenler.parseString(yazi: jsonData[cihazModeliStr]),
      seriNo: Degiskenler.parseString(yazi: jsonData[seriNoStr]),
      cihazSifresi: Degiskenler.parseString(yazi: jsonData[cihazSifresiStr]),
      hasarTespiti: Degiskenler.parseString(yazi: jsonData[hasarTespitiStr]),
      cihazdakiHasar: Degiskenler.parseInt(sayi: jsonData[cihazdakiHasarStr]),
      arizaAciklamasi:
          Degiskenler.parseString(yazi: jsonData[arizaAciklamasiStr]),
      servisTuru: Degiskenler.parseInt(sayi: jsonData[servisTuruStr]),
      yedekDurumu: Degiskenler.parseInt(sayi: jsonData[yedekDurumuStr]),
      teslimAlinanlar:
          Degiskenler.parseString(yazi: jsonData[teslimAlinanlarStr]),
      yapilanIslemAciklamasi:
          Degiskenler.parseString(yazi: jsonData[yapilanIslemAciklamasiStr]),
      teslimEdildi: Degiskenler.parseInt(sayi: jsonData[teslimEdildiStr]),
      tarih: Degiskenler.parseString(yazi: jsonData[tarihStr]),
      bildirimTarihi:
          Degiskenler.parseString(yazi: jsonData[bildirimTarihiStr]),
      cikisTarihi: Degiskenler.parseString(yazi: jsonData[cikisTarihiStr]),
      guncelDurum: Degiskenler.parseInt(sayi: jsonData[guncelDurumStr]),
      tahsilatSekli: Degiskenler.parseInt(sayi: jsonData[tahsilatSekliStr]),
      iStokKod1: Degiskenler.parseString(yazi: jsonData[iStokKod1Str]),
      iAd1: Degiskenler.parseString(yazi: jsonData[iAd1Str]),
      iBirimFiyat1: Degiskenler.parseDecimal(sayi: jsonData[iBirimFiyat1Str]),
      iMiktar1: Degiskenler.parseInt(sayi: jsonData[iMiktar1Str]),
      iKdv1: Degiskenler.parseDecimal(sayi: jsonData[iKdv1Str]),
      iStokKod2: Degiskenler.parseString(yazi: jsonData[iStokKod2Str]),
      iAd2: Degiskenler.parseString(yazi: jsonData[iAd2Str]),
      iBirimFiyat2: Degiskenler.parseDecimal(sayi: jsonData[iBirimFiyat2Str]),
      iMiktar2: Degiskenler.parseInt(sayi: jsonData[iMiktar2Str]),
      iKdv2: Degiskenler.parseDecimal(sayi: jsonData[iKdv2Str]),
      iStokKod3: Degiskenler.parseString(yazi: jsonData[iStokKod3Str]),
      iAd3: Degiskenler.parseString(yazi: jsonData[iAd3Str]),
      iBirimFiyat3: Degiskenler.parseDecimal(sayi: jsonData[iBirimFiyat3Str]),
      iMiktar3: Degiskenler.parseInt(sayi: jsonData[iMiktar3Str]),
      iKdv3: Degiskenler.parseDecimal(sayi: jsonData[iKdv3Str]),
      iStokKod4: Degiskenler.parseString(yazi: jsonData[iStokKod4Str]),
      iAd4: Degiskenler.parseString(yazi: jsonData[iAd4Str]),
      iBirimFiyat4: Degiskenler.parseDecimal(sayi: jsonData[iBirimFiyat4Str]),
      iMiktar4: Degiskenler.parseInt(sayi: jsonData[iMiktar4Str]),
      iKdv4: Degiskenler.parseDecimal(sayi: jsonData[iKdv4Str]),
      iStokKod5: Degiskenler.parseString(yazi: jsonData[iStokKod5Str]),
      iAd5: Degiskenler.parseString(yazi: jsonData[iAd5Str]),
      iBirimFiyat5: Degiskenler.parseDecimal(sayi: jsonData[iBirimFiyat5Str]),
      iMiktar5: Degiskenler.parseInt(sayi: jsonData[iMiktar5Str]),
      iKdv5: Degiskenler.parseDecimal(sayi: jsonData[iKdv5Str]),
      iStokKod6: Degiskenler.parseString(yazi: jsonData[iStokKod6Str]),
      iAd6: Degiskenler.parseString(yazi: jsonData[iAd6Str]),
      iBirimFiyat6: Degiskenler.parseDecimal(sayi: jsonData[iBirimFiyat6Str]),
      iMiktar6: Degiskenler.parseInt(sayi: jsonData[iMiktar6Str]),
      iKdv6: Degiskenler.parseDecimal(sayi: jsonData[iKdv6Str]),
    );
  }

  factory CihazModel.bos() {
    return CihazModel(
      id: 0,
      servisNo: "",
      takipNumarasi: 0,
      musteriKod: "",
      musteriAdi: "",
      adres: "",
      telefonNumarasi: "",
      cihazTuru: "",
      sorumlu: "",
      cihaz: "",
      cihazModeli: "",
      seriNo: "",
      cihazSifresi: "",
      hasarTespiti: "",
      cihazdakiHasar: 0,
      arizaAciklamasi: "",
      servisTuru: 0,
      yedekDurumu: 0,
      teslimAlinanlar: "",
      yapilanIslemAciklamasi: "",
      teslimEdildi: 0,
      tarih: "",
      bildirimTarihi: "",
      cikisTarihi: "",
      guncelDurum: 0,
      tahsilatSekli: 0,
      iStokKod1: "",
      iAd1: "",
      iBirimFiyat1: Decimal.parse("0.00"),
      iMiktar1: 0,
      iKdv1: Decimal.parse("0.00"),
      iStokKod2: "",
      iAd2: "",
      iBirimFiyat2: Decimal.parse("0.00"),
      iMiktar2: 0,
      iKdv2: Decimal.parse("0.00"),
      iStokKod3: "",
      iAd3: "",
      iBirimFiyat3: Decimal.parse("0.00"),
      iMiktar3: 0,
      iKdv3: Decimal.parse("0.00"),
      iStokKod4: "",
      iAd4: "",
      iBirimFiyat4: Decimal.parse("0.00"),
      iMiktar4: 0,
      iKdv4: Decimal.parse("0.00"),
      iStokKod5: "",
      iAd5: "",
      iBirimFiyat5: Decimal.parse("0.00"),
      iMiktar5: 0,
      iKdv5: Decimal.parse("0.00"),
      iStokKod6: "",
      iAd6: "",
      iBirimFiyat6: Decimal.parse("0.00"),
      iMiktar6: 0,
      iKdv6: Decimal.parse("0.00"),
    );
  }
  Map<String, dynamic> toMap() => <String, dynamic>{
        idStr: id,
        servisNoStr: seriNo,
        takipNumarasiStr: takipNumarasi,
        musteriKodStr: musteriKod,
        musteriAdiStr: musteriAdi,
        adresStr: adres,
        telefonNumarasiStr: telefonNumarasi,
        cihazTuruStr: cihazTuru,
        sorumluStr: sorumlu,
        cihazStr: cihaz,
        cihazModeliStr: cihazModeli,
        seriNoStr: seriNo,
        cihazSifresiStr: cihazSifresi,
        hasarTespitiStr: hasarTespiti,
        cihazdakiHasarStr: cihazdakiHasar,
        arizaAciklamasiStr: arizaAciklamasi,
        servisTuruStr: servisTuru,
        yedekDurumuStr: yedekDurumu,
        teslimAlinanlarStr: teslimAlinanlar,
        yapilanIslemAciklamasiStr: yapilanIslemAciklamasi,
        teslimEdildiStr: teslimEdildi,
        tarihStr: tarih,
        bildirimTarihiStr: bildirimTarihi,
        cikisTarihiStr: cikisTarihi,
        guncelDurumStr: guncelDurum,
        tahsilatSekliStr: tahsilatSekli,
        iStokKod1Str: iStokKod1,
        iAd1Str: iAd1,
        iBirimFiyat1Str: iBirimFiyat2,
        iMiktar1Str: iMiktar1,
        iKdv1Str: iKdv1,
        iStokKod2Str: iStokKod2,
        iAd2Str: iAd2,
        iBirimFiyat2Str: iBirimFiyat3,
        iMiktar2Str: iMiktar2,
        iKdv2Str: iKdv2,
        iStokKod3Str: iStokKod3,
        iAd3Str: iAd3,
        iBirimFiyat3Str: iBirimFiyat3,
        iMiktar3Str: iMiktar3,
        iKdv3Str: iKdv3,
        iStokKod4Str: iStokKod4,
        iAd4Str: iAd4,
        iBirimFiyat4Str: iBirimFiyat4,
        iMiktar4Str: iMiktar4,
        iKdv4Str: iKdv4,
        iStokKod5Str: iStokKod5,
        iAd5Str: iAd5,
        iBirimFiyat5Str: iBirimFiyat5,
        iMiktar5Str: iMiktar5,
        iKdv5Str: iKdv5,
        iStokKod6Str: iStokKod6,
        iAd6Str: iAd6,
        iBirimFiyat6Str: iBirimFiyat6,
        iMiktar6Str: iMiktar6,
        iKdv6Str: iKdv6,
      };
  static String idStr = "id";
  static String servisNoStr = "servis_no";
  static String takipNumarasiStr = "takip_numarasi";
  static String musteriKodStr = "musteri_kod";
  static String musteriAdiStr = "musteri_adi";
  static String adresStr = "adres";
  static String telefonNumarasiStr = "telefon_numarasi";
  static String cihazTuruStr = "cihaz_turu";
  static String sorumluStr = "sorumlu";
  static String cihazStr = "cihaz";
  static String cihazModeliStr = "cihaz_modeli";
  static String seriNoStr = "seri_no";
  static String cihazSifresiStr = "cihaz_sifresi";
  static String hasarTespitiStr = "hasar_tespiti";
  static String cihazdakiHasarStr = "cihazdaki_hasar";
  static String arizaAciklamasiStr = "ariza_aciklamasi";
  static String servisTuruStr = "servis_turu";
  static String yedekDurumuStr = "yedek_durumu";
  static String teslimAlinanlarStr = "teslim_alinanlar";
  static String yapilanIslemAciklamasiStr = "yapilan_islem_aciklamasi";
  static String teslimEdildiStr = "teslim_edildi";
  static String tarihStr = "tarih";
  static String bildirimTarihiStr = "bildirim_tarihi";
  static String cikisTarihiStr = "cikis_tarihi";
  static String guncelDurumStr = "guncel_durum";
  static String tahsilatSekliStr = "tahsilat_sekli";
  static String iStokKod1Str = "i_stok_kod_1";
  static String iAd1Str = "i_ad_1";
  static String iBirimFiyat1Str = "i_birim_fiyat_1";
  static String iMiktar1Str = "i_miktar_1";
  static String iKdv1Str = "i_kdv_1";
  static String iStokKod2Str = "i_stok_kod_2";
  static String iAd2Str = "i_ad_2";
  static String iBirimFiyat2Str = "i_birim_fiyat_2";
  static String iMiktar2Str = "i_miktar_2";
  static String iKdv2Str = "i_kdv_2";
  static String iStokKod3Str = "i_stok_kod_3";
  static String iAd3Str = "i_ad_3";
  static String iBirimFiyat3Str = "i_birim_fiyat_3";
  static String iMiktar3Str = "i_miktar_3";
  static String iKdv3Str = "i_kdv_3";
  static String iStokKod4Str = "i_stok_kod_4";
  static String iAd4Str = "i_ad_4";
  static String iBirimFiyat4Str = "i_birim_fiyat_4";
  static String iMiktar4Str = "i_miktar_4";
  static String iKdv4Str = "i_kdv_4";
  static String iStokKod5Str = "i_stok_kod_5";
  static String iAd5Str = "i_ad_5";
  static String iBirimFiyat5Str = "i_birim_fiyat_5";
  static String iMiktar5Str = "i_miktar_5";
  static String iKdv5Str = "i_kdv_5";
  static String iStokKod6Str = "i_stok_kod_6";
  static String iAd6Str = "i_ad_6";
  static String iBirimFiyat6Str = "i_birim_fiyat_6";
  static String iMiktar6Str = "i_miktar_6";
  static String iKdv6Str = "i_kdv_6";

  static int tarihSiralama(String tarih) {
    String gun = tarih.substring(0, 2);
    String ay = tarih.substring(3, 5);
    String yil = tarih.substring(6, 10);
    String saat = tarih.substring(11, 13);
    String dakika = tarih.substring(14, 16);
    return int.tryParse("$yil$ay$gun$saat$dakika") ?? 0;
  }

  static List<CihazModel> siralaVarsayilan(
    List<CihazModel> cihazlar, {
    bool asc = false,
  }) {
    cihazlar.sort((a, b) {
      int cmp = cihazDurumuSiralamaGetir((asc ? b : a).guncelDurum)
          .compareTo(cihazDurumuSiralamaGetir((asc ? a : b).guncelDurum));
      if (cmp != 0) return cmp;
      return tarihSiralama(a.tarih).compareTo(tarihSiralama(b.tarih));
    });
    return cihazlar;
  }

  static List<CihazModel> siralaServisNo(
    List<CihazModel> cihazlar, {
    bool asc = false,
  }) {
    cihazlar.sort(
        (a, b) => (asc ? a : b).servisNo.compareToTr((asc ? b : a).servisNo));
    return cihazlar;
  }

  static List<CihazModel> siralaMusteriAdi(
    List<CihazModel> cihazlar, {
    bool asc = false,
  }) {
    cihazlar.sort((a, b) =>
        (asc ? a : b).musteriAdi.compareToTr((asc ? b : a).musteriAdi));
    return cihazlar;
  }

  static List<CihazModel> siralaTur(
    List<CihazModel> cihazlar, {
    bool asc = false,
  }) {
    cihazlar.sort(
        (a, b) => (asc ? a : b).cihazTuru.compareToTr((asc ? b : a).cihazTuru));
    return cihazlar;
  }

  static List<CihazModel> siralaCihazveModel(
    List<CihazModel> cihazlar, {
    bool asc = false,
  }) {
    cihazlar.sort((a, b) =>
        ("${(asc ? a : b).cihaz} ${(asc ? a : b).cihazModeli}").compareToTr(
            ("${(asc ? b : a).cihaz} ${(asc ? b : a).cihazModeli}")));
    return cihazlar;
  }

  static List<CihazModel> siralaTarih(
    List<CihazModel> cihazlar, {
    bool asc = false,
  }) {
    cihazlar.sort((a, b) => tarihSiralama((asc ? a : b).tarih)
        .compareTo(tarihSiralama((asc ? b : a).tarih)));
    return cihazlar;
  }

  static List<CihazModel> siralaSorumlu(
    List<CihazModel> cihazlar, {
    bool asc = false,
  }) {
    cihazlar.sort(
        (a, b) => (asc ? a : b).sorumlu.compareToTr((asc ? b : a).sorumlu));
    return cihazlar;
  }

  static List<CihazModel> sirala({
    required List<CihazModel> cihazlar,
    CihazSiralama cihazSiralama = CihazSiralama.varsayilan,
    bool asc = false,
  }) {
    switch (cihazSiralama) {
      case CihazSiralama.servisNo:
        return siralaServisNo(
          cihazlar,
          asc: asc,
        );
      case CihazSiralama.musteriAdi:
        return siralaMusteriAdi(
          cihazlar,
          asc: asc,
        );
      case CihazSiralama.tur:
        return siralaTur(
          cihazlar,
          asc: asc,
        );
      case CihazSiralama.cihazVeModel:
        return siralaCihazveModel(
          cihazlar,
          asc: asc,
        );
      case CihazSiralama.tarih:
        return siralaTarih(
          cihazlar,
          asc: asc,
        );
      case CihazSiralama.sorumlu:
        return siralaSorumlu(
          cihazlar,
          asc: asc,
        );
      default:
        return siralaVarsayilan(
          cihazlar,
          asc: asc,
        );
    }
  }
}
