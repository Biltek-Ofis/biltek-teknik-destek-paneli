class Cihaz {
  final int id;
  final int servisNo;
  final int takipNumarasi;
  final int cagriID;
  final int kullID;
  final int musterKod;
  final String musteriAdi;
  final String teslimEden;
  final String teslimAlan;
  final String adres;
  final String telefonNumarasi;
  final String cihazTuru;
  final String sorumlu;
  final String cihaz;
  final String cihazModeli;
  final String seriNo;
  final String cihazSifresi;
  final String cihazDeseni;
  final String cihazDeseniActives;
  final String cihazDeseniLines;
  final String hasarTespiti;
  final int cihazdakiHasar;
  final String arizaAciklamasi;
  final int servisTuru;
  final int yedekDurumu;
  final String teslimAlinanlar;
  final String yapilanIslemAciklamasi;
  final String notlar;
  final String teslimEdildi;
  final String tarih;
  final String bildirimTarihi;
  final String cikisTarihi;
  final int guncelDurum;
  final String guncelDurumText;
  final String guncelDurumRenk;
  final String tahsilatSekli;
  final int faturaDurumu;
  final String fisNo;
  final String iStokKod1;
  final String iAd1;
  final double iBirimFiyat1;
  final int iMiktar1;
  final double iKDV1;
  final String iStokKod2;
  final String iAd2;
  final double iBirimFiyat2;
  final int iMiktar2;
  final double iKDV2;
  final String iStokKod3;
  final String iAd3;
  final double iBirimFiyat3;
  final int iMiktar3;
  final double iKDV3;
  final String iStokKod4;
  final String iAd4;
  final double iBirimFiyat4;
  final int iMiktar4;
  final double iKDV4;
  final String iStokKod5;
  final String iAd5;
  final double iBirimFiyat5;
  final int iMiktar5;
  final double iKDV5;
  final String iStokKod6;
  final String iAd6;
  final double iBirimFiyat6;
  final int iMiktar6;
  final double iKDV6;
  final int cihazDurumuID;
  final int siralama;
  final int cihazTuruVal;
  final int tahsilatSekliVal;
  final int sorumluVal;
  final List<YapilanIslem> islemler;
  static Cihaz create({
    int id = 0,
    int servisNo = 0,

    int takipNumarasi = 0,

    int cagriID = 0,
    int kullID = 0,
    int musterKod = 0,
    String musteriAdi = "",
    String teslimEden = "",
    String teslimAlan = "",
    String adres = "",
    String telefonNumarasi = "",
    int cihazTuruVal = 0,
    String cihazTuru = "",
    String sorumlu = "",
    String cihaz = "",
    String cihazModeli = "",
    String seriNo = "",
    String cihazSifresi = "",
    String cihazDeseni = "",
    String cihazDeseniActives = "",
    String cihazDeseniLines = "",
    String hasarTespiti = "",
    int cihazdakiHasar = 0,
    String arizaAciklamasi = "",
    int servisTuru = 0,
    int yedekDurumu = 0,
    String teslimAlinanlar = "",
    String yapilanIslemAciklamasi = "",
    String notlar = "",
    String teslimEdildi = "",
    String tarih = "",
    String bildirimTarihi = "",
    String cikisTarihi = "",
    int guncelDurum = 0,
    String guncelDurumText = "",
    String guncelDurumRenk = "",
    String tahsilatSekli = "",
    int faturaDurumu = 0,
    String fisNo = "",
    String iStokKod1 = "",
    String iAd1 = "",
    double iBirimFiyat1 = 0,
    int iMiktar1 = 0,
    double iKDV1 = 0.0,
    String iStokKod2 = "",
    String iAd2 = "",
    double iBirimFiyat2 = 0.0,
    int iMiktar2 = 0,
    double iKDV2 = 0.0,
    String iStokKod3 = "",
    String iAd3 = "",
    double iBirimFiyat3 = 0.0,
    int iMiktar3 = 0,
    double iKDV3 = 0.0,
    String iStokKod4 = "",
    String iAd4 = "",
    double iBirimFiyat4 = 0.0,
    int iMiktar4 = 0,
    double iKDV4 = 0.0,
    String iStokKod5 = "",
    String iAd5 = "",
    double iBirimFiyat5 = 0.0,
    int iMiktar5 = 0,
    double iKDV5 = 0.0,
    String iStokKod6 = "",
    String iAd6 = "",
    double iBirimFiyat6 = 0.0,
    int iMiktar6 = 0,
    double iKDV6 = 0.0,
    int cihazDurumuID = 0,
    int siralama = 0,
    int tahsilatSekliVal = 0,
    int sorumluVal = 0,
    List<YapilanIslem> islemler = const [],
  }) {
    return Cihaz(
      id: id,
      servisNo: servisNo,
      takipNumarasi: takipNumarasi,
      cagriID: cagriID,
      kullID: kullID,
      musterKod: musterKod,
      musteriAdi: musteriAdi,
      teslimEden: teslimEden,
      teslimAlan: teslimAlan,
      adres: adres,
      telefonNumarasi: telefonNumarasi,
      cihazTuru: cihazTuru,
      sorumlu: sorumlu,
      cihaz: cihaz,
      cihazModeli: cihazModeli,
      seriNo: seriNo,
      cihazSifresi: cihazSifresi,
      cihazDeseni: cihazDeseni,
      cihazDeseniActives: cihazDeseniActives,
      cihazDeseniLines: cihazDeseniLines,
      hasarTespiti: hasarTespiti,
      cihazdakiHasar: cihazdakiHasar,
      arizaAciklamasi: arizaAciklamasi,
      servisTuru: servisTuru,
      yedekDurumu: yedekDurumu,
      teslimAlinanlar: teslimAlinanlar,
      yapilanIslemAciklamasi: yapilanIslemAciklamasi,
      notlar: notlar,
      teslimEdildi: teslimEdildi,
      tarih: tarih,
      bildirimTarihi: bildirimTarihi,
      cikisTarihi: cikisTarihi,
      guncelDurum: guncelDurum,
      guncelDurumText: guncelDurumText,
      guncelDurumRenk: guncelDurumRenk,
      tahsilatSekli: tahsilatSekli,
      faturaDurumu: faturaDurumu,
      fisNo: fisNo,
      iStokKod1: iStokKod1,
      iAd1: iAd1,
      iBirimFiyat1: iBirimFiyat1,
      iMiktar1: iMiktar1,
      iKDV1: iKDV1,
      iStokKod2: iStokKod2,
      iAd2: iAd2,
      iBirimFiyat2: iBirimFiyat2,
      iMiktar2: iMiktar2,
      iKDV2: iKDV2,
      iStokKod3: iStokKod3,
      iAd3: iAd3,
      iBirimFiyat3: iBirimFiyat3,
      iMiktar3: iMiktar3,
      iKDV3: iKDV3,
      iStokKod4: iStokKod4,
      iAd4: iAd4,
      iBirimFiyat4: iBirimFiyat4,
      iMiktar4: iMiktar4,
      iKDV4: iKDV4,
      iStokKod5: iStokKod5,
      iAd5: iAd5,
      iBirimFiyat5: iBirimFiyat5,
      iMiktar5: iMiktar5,
      iKDV5: iKDV5,
      iStokKod6: iStokKod6,
      iAd6: iAd6,
      iBirimFiyat6: iBirimFiyat6,
      iMiktar6: iMiktar6,
      iKDV6: iKDV6,
      cihazDurumuID: 0,
      siralama: 0,
      cihazTuruVal: cihazTuruVal,
      tahsilatSekliVal: 0,
      sorumluVal: 0,
      islemler: islemler,
    );
  }

  const Cihaz({
    required this.id,
    required this.servisNo,
    required this.takipNumarasi,
    required this.cagriID,
    required this.kullID,
    required this.musterKod,
    required this.musteriAdi,
    required this.teslimEden,
    required this.teslimAlan,
    required this.adres,
    required this.telefonNumarasi,
    required this.cihazTuru,
    required this.sorumlu,
    required this.cihaz,
    required this.cihazModeli,
    required this.seriNo,
    required this.cihazSifresi,
    required this.cihazDeseni,
    required this.cihazDeseniActives,
    required this.cihazDeseniLines,
    required this.hasarTespiti,
    required this.cihazdakiHasar,
    required this.arizaAciklamasi,
    required this.servisTuru,
    required this.yedekDurumu,
    required this.teslimAlinanlar,
    required this.yapilanIslemAciklamasi,
    required this.notlar,
    required this.teslimEdildi,
    required this.tarih,
    required this.bildirimTarihi,
    required this.cikisTarihi,
    required this.guncelDurum,
    required this.guncelDurumText,
    required this.guncelDurumRenk,
    required this.tahsilatSekli,
    required this.faturaDurumu,
    required this.fisNo,
    required this.iStokKod1,
    required this.iAd1,
    required this.iBirimFiyat1,
    required this.iMiktar1,
    required this.iKDV1,
    required this.iStokKod2,
    required this.iAd2,
    required this.iBirimFiyat2,
    required this.iMiktar2,
    required this.iKDV2,
    required this.iStokKod3,
    required this.iAd3,
    required this.iBirimFiyat3,
    required this.iMiktar3,
    required this.iKDV3,
    required this.iStokKod4,
    required this.iAd4,
    required this.iBirimFiyat4,
    required this.iMiktar4,
    required this.iKDV4,
    required this.iStokKod5,
    required this.iAd5,
    required this.iBirimFiyat5,
    required this.iMiktar5,
    required this.iKDV5,
    required this.iStokKod6,
    required this.iAd6,
    required this.iBirimFiyat6,
    required this.iMiktar6,
    required this.iKDV6,
    required this.cihazDurumuID,
    required this.siralama,
    required this.cihazTuruVal,
    required this.tahsilatSekliVal,
    required this.sorumluVal,
    required this.islemler,
  });
  factory Cihaz.fromJson(Map<String, dynamic> json) {
    return switch (json) {
      {
        "id": String id,
        "servis_no": String servisNo,
        "takip_numarasi": String takipNumarasi,
        "cagri_id": String cagriID,
        "kull_id": String kullID,
        "musteri_kod": String musterKod,
        "musteri_adi": String musteriAdi,
        "teslim_eden": String teslimEden,
        "teslim_alan": String teslimAlan,
        "adres": String adres,
        "telefon_numarasi": String telefonNumarasi,
        "cihaz_turu": String cihazTuru,
        "sorumlu": String sorumlu,
        "cihaz": String cihaz,
        "cihaz_modeli": String cihazModeli,
        "seri_no": String seriNo,
        "cihaz_sifresi": String cihazSifresi,
        "cihaz_deseni": String cihazDeseni,
        "cihaz_deseni_actives": String cihazDeseniActives,
        "cihaz_deseni_lines": String cihazDeseniLines,
        "hasar_tespiti": String hasarTespiti,
        "cihazdaki_hasar": String cihazdakiHasar,
        "ariza_aciklamasi": String arizaAciklamasi,
        "servis_turu": String servisTuru,
        "yedek_durumu": String yedekDurumu,
        "teslim_alinanlar": String teslimAlinanlar,
        "yapilan_islem_aciklamasi": String yapilanIslemAciklamasi,
        "notlar": String notlar,
        "teslim_edildi": String teslimEdildi,
        "tarih": String tarih,
        "bildirim_tarihi": String bildirimTarihi,
        "cikis_tarihi": String cikisTarihi,
        "guncel_durum": String guncelDurum,
        "guncel_durum_text": String guncelDurumText,
        "guncel_durum_renk": String guncelDurumRenk,
        "tahsilat_sekli": String tahsilatSekli,
        "fatura_durumu": String faturaDurumu,
        "fis_no": String fisNo,
        "i_stok_kod_1": String iStokKod1,
        "i_ad_1": String iAd1,
        "i_birim_fiyat_1": String iBirimFiyat1,
        "i_miktar_1": String iMiktar1,
        "i_kdv_1": String iKDV1,
        "i_stok_kod_2": String iStokKod2,
        "i_ad_2": String iAd2,
        "i_birim_fiyat_2": String iBirimFiyat2,
        "i_miktar_2": String iMiktar2,
        "i_kdv_2": String iKDV2,
        "i_stok_kod_3": String iStokKod3,
        "i_ad_3": String iAd3,
        "i_birim_fiyat_3": String iBirimFiyat3,
        "i_miktar_3": String iMiktar3,
        "i_kdv_3": String iKDV3,
        "i_stok_kod_4": String iStokKod4,
        "i_ad_4": String iAd4,
        "i_birim_fiyat_4": String iBirimFiyat4,
        "i_miktar_4": String iMiktar4,
        "i_kdv_4": String iKDV4,
        "i_stok_kod_5": String iStokKod5,
        "i_ad_5": String iAd5,
        "i_birim_fiyat_5": String iBirimFiyat5,
        "i_miktar_5": String iMiktar5,
        "i_kdv_5": String iKDV5,
        "i_stok_kod_6": String iStokKod6,
        "i_ad_6": String iAd6,
        "i_birim_fiyat_6": String iBirimFiyat6,
        "i_miktar_6": String iMiktar6,
        "i_kdv_6": String iKDV6,
        "cihazDurumuID": String cihazDurumuID,
        "siralama": String siralama,
        "cihaz_turu_val": String cihazTuruVal,
        "tahsilat_sekli_val": String tahsilatSekliVal,
        "sorumlu_val": String sorumluVal,
        "islemler": List<dynamic> islemler,
      } =>
        Cihaz(
          id: int.tryParse(id) ?? 0,
          servisNo: int.tryParse(servisNo) ?? 0,
          takipNumarasi: int.tryParse(takipNumarasi) ?? 0,
          cagriID: int.tryParse(cagriID) ?? 0,
          kullID: int.tryParse(kullID) ?? 0,
          musterKod: int.tryParse(musterKod) ?? 0,
          musteriAdi: musteriAdi,
          teslimEden: teslimEden,
          teslimAlan: teslimAlan,
          adres: adres,
          telefonNumarasi: telefonNumarasi,
          cihazTuru: cihazTuru,
          sorumlu: sorumlu,
          cihaz: cihaz,
          cihazModeli: cihazModeli,
          seriNo: seriNo,
          cihazSifresi: cihazSifresi,
          cihazDeseni: cihazDeseni,
          cihazDeseniActives: cihazDeseniActives,
          cihazDeseniLines: cihazDeseniLines,
          hasarTespiti: hasarTespiti,
          cihazdakiHasar: int.parse(cihazdakiHasar),
          arizaAciklamasi: arizaAciklamasi,
          servisTuru: int.tryParse(servisTuru) ?? 99,
          yedekDurumu: int.tryParse(yedekDurumu) ?? -1,
          teslimAlinanlar: teslimAlinanlar,
          yapilanIslemAciklamasi: yapilanIslemAciklamasi,
          notlar: notlar,
          teslimEdildi: teslimEdildi,
          tarih: tarih,
          bildirimTarihi: bildirimTarihi,
          cikisTarihi: cikisTarihi,
          guncelDurum: int.tryParse(guncelDurum) ?? -1,
          guncelDurumText: guncelDurumText,
          guncelDurumRenk: guncelDurumRenk,
          tahsilatSekli: tahsilatSekli,
          faturaDurumu: int.tryParse(faturaDurumu) ?? 0,
          fisNo: fisNo,
          iStokKod1: iStokKod1,
          iAd1: iAd1,
          iBirimFiyat1: double.tryParse(iBirimFiyat1) ?? 0.00,
          iMiktar1: int.tryParse(iMiktar1) ?? 0,
          iKDV1: double.tryParse(iKDV1) ?? 0.00,
          iStokKod2: iStokKod2,
          iAd2: iAd2,
          iBirimFiyat2: double.tryParse(iBirimFiyat2) ?? 0.00,
          iMiktar2: int.tryParse(iMiktar2) ?? 0,
          iKDV2: double.tryParse(iKDV2) ?? 0.00,
          iStokKod3: iStokKod3,
          iAd3: iAd3,
          iBirimFiyat3: double.tryParse(iBirimFiyat3) ?? 0.00,
          iMiktar3: int.tryParse(iMiktar3) ?? 0,
          iKDV3: double.tryParse(iKDV3) ?? 0.00,
          iStokKod4: iStokKod4,
          iAd4: iAd4,
          iBirimFiyat4: double.tryParse(iBirimFiyat4) ?? 0.00,
          iMiktar4: int.tryParse(iMiktar4) ?? 0,
          iKDV4: double.tryParse(iKDV4) ?? 0.00,
          iStokKod5: iStokKod5,
          iAd5: iAd5,
          iBirimFiyat5: double.tryParse(iBirimFiyat5) ?? 0.00,
          iMiktar5: int.tryParse(iMiktar5) ?? 0,
          iKDV5: double.tryParse(iKDV5) ?? 0.00,
          iStokKod6: iStokKod6,
          iAd6: iAd6,
          iBirimFiyat6: double.tryParse(iBirimFiyat6) ?? 0.00,
          iMiktar6: int.tryParse(iMiktar6) ?? 0,
          iKDV6: double.tryParse(iKDV6) ?? 0.00,
          cihazDurumuID: int.tryParse(cihazDurumuID) ?? -1,
          siralama: int.tryParse(siralama) ?? -1,
          cihazTuruVal: int.tryParse(cihazTuruVal) ?? -1,
          tahsilatSekliVal: int.tryParse(tahsilatSekliVal) ?? -1,
          sorumluVal: int.tryParse(sorumluVal) ?? -1,
          islemler:
              islemler
                  .map(
                    (islem) =>
                        YapilanIslem.fromJson(islem as Map<String, dynamic>),
                  )
                  .toList(),
        ),
      _ => throw FormatException("Cihaz yüklenirken hata oluştu."),
    };
  }
}

class YapilanIslem {
  final int id;
  final int cihazID;
  final int islemSayisi;
  final String ad;
  final double maliyet;
  final double birimFiyati;
  final int miktar;
  final double kdv;

  const YapilanIslem({
    required this.id,
    required this.cihazID,
    required this.islemSayisi,
    required this.ad,
    required this.maliyet,
    required this.birimFiyati,
    required this.miktar,
    required this.kdv,
  });
  static YapilanIslem create({
    required String id,
    required String cihazID,
    required String islemSayisi,
    required String ad,
    required String maliyet,
    required String birimFiyati,
    required String miktar,
    required String kdv,
  }) {
    return YapilanIslem(
      id: int.tryParse(id) ?? 0,
      cihazID: int.tryParse(cihazID) ?? 0,
      islemSayisi: int.tryParse(islemSayisi) ?? 0,
      ad: ad,
      maliyet: double.tryParse(maliyet) ?? 0.00,
      birimFiyati: double.tryParse(birimFiyati) ?? 0.00,
      miktar: int.tryParse(miktar) ?? 0,
      kdv: double.tryParse(kdv) ?? 0.00,
    );
  }

  factory YapilanIslem.fromJson(Map<String, dynamic> json) {
    return switch (json) {
      {
        "id": String id,
        "cihaz_id": String cihazID,
        "islem_sayisi": String islemSayisi,
        "ad": String ad,
        "maliyet": String maliyet,
        "birim_fiyat": String birimFiyati,
        "miktar": String miktar,
        "kdv": String kdv,
      } =>
        YapilanIslem.create(
          id: id,
          cihazID: cihazID,
          islemSayisi: islemSayisi,
          ad: ad,
          maliyet: maliyet,
          birimFiyati: birimFiyati,
          miktar: miktar,
          kdv: kdv,
        ),
      _ => throw FormatException("Yapılan işlem yüklenirken hata oluştu."),
    };
  }
}
