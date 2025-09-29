class KullaniciGetirModel {
  final bool durum;
  final KullaniciAuthModel kullanici;

  const KullaniciGetirModel({required this.durum, required this.kullanici});

  factory KullaniciGetirModel.fromJson(Map<String, dynamic> json) {
    return switch (json) {
      {'durum': bool durum, 'kullanici': Map<String, dynamic> kullanici} =>
        KullaniciGetirModel(
          durum: durum,
          kullanici: KullaniciAuthModel.fromJson(kullanici),
        ),
      _ => KullaniciGetirModel(
        durum: false,
        kullanici: KullaniciAuthModel.fromJson({}),
      ),
    };
  }
}

class KullaniciAuthModel extends KullaniciModel {
  final String auth;

  const KullaniciAuthModel({
    required super.id,
    required super.kullaniciAdi,
    required super.adSoyad,
    required super.urunduzenleme,
    required super.teknikservis,
    required super.yonetici,
    required super.musteri,
    required this.auth,
  });

  factory KullaniciAuthModel.fromJson(Map<String, dynamic> json) {
    return switch (json) {
      {
        'id': String id,
        'kullanici_adi': String kullaniciAdi,
        'ad_soyad': String adSoyad,
        'urunduzenleme': String urunduzenleme,
        'teknikservis': String teknikservis,
        'yonetici': String yonetici,
        'musteri': String musteri,
        'auth': String auth,
      } =>
        KullaniciAuthModel(
          id: int.tryParse(id) ?? 0,
          kullaniciAdi: kullaniciAdi,
          adSoyad: adSoyad,
          urunduzenleme: urunduzenleme == "1",
          teknikservis: teknikservis == "1",
          yonetici: yonetici == "1",
          musteri: musteri == "1",
          auth: auth,
        ),
      _ => KullaniciAuthModel(
        id: 0,
        kullaniciAdi: "",
        adSoyad: "",
        urunduzenleme: false,
        teknikservis: false,
        yonetici: false,
        musteri: true,
        auth: "",
      ),
    };
  }
}

class KullaniciModel {
  final int id;
  final String kullaniciAdi;
  final String adSoyad;
  final bool urunduzenleme;
  final bool teknikservis;
  final bool yonetici;
  final bool musteri;

  const KullaniciModel({
    required this.id,
    required this.kullaniciAdi,
    required this.adSoyad,
    required this.urunduzenleme,
    required this.teknikservis,
    required this.yonetici,
    required this.musteri,
  });

  factory KullaniciModel.fromJson(Map<String, dynamic> json) {
    return switch (json) {
      {
        'id': String id,
        'kullanici_adi': String kullaniciAdi,
        'ad_soyad': String adSoyad,
        'urunduzenleme': String urunduzenleme,
        'teknikservis': String teknikservis,
        'yonetici': String yonetici,
        'musteri': String musteri,
      } =>
        KullaniciModel(
          id: int.tryParse(id) ?? 0,
          kullaniciAdi: kullaniciAdi,
          adSoyad: adSoyad,
          urunduzenleme: urunduzenleme == "1",
          teknikservis: teknikservis == "1",
          yonetici: yonetici == "1",
          musteri: musteri == "1",
        ),
      _ => KullaniciModel(
        id: 0,
        kullaniciAdi: "",
        adSoyad: "",
        urunduzenleme: false,
        teknikservis: false,
        yonetici: false,
        musteri: true,
      ),
    };
  }
}
