class Lisans {
  final int id;
  final String isim;
  final String lisans;
  final String kayit;
  final String baslangic;
  final String bitis;
  final bool suresiz;
  final bool aktif;

  final Map<String, dynamic> durum;

  const Lisans({
    required this.id,
    required this.isim,
    required this.lisans,
    required this.kayit,
    required this.baslangic,
    required this.bitis,
    required this.suresiz,
    required this.aktif,
    required this.durum,
  });
  factory Lisans.fromJson(Map<String, dynamic> json) {
    return switch (json) {
      {
        "id": String id,
        "isim": String isim,
        "lisans": String lisans,
        "kayit": String kayit,
        "baslangic": String baslangic,
        "bitis": String bitis,
        "suresiz": String suresiz,
        "aktif": String aktif,
        "durum": Map<String, dynamic> durum,
      } =>
        Lisans(
          id: int.tryParse(id) ?? 0,
          isim: isim,
          lisans: lisans,
          kayit: kayit,
          baslangic: baslangic,
          bitis: bitis,
          suresiz: suresiz == "1",
          aktif: aktif == "1",
          durum: durum,
        ),
      _ => throw FormatException("Lisans yüklenirken hata oluştu."),
    };
  }
}
