import 'dart:convert';

import 'package:flutter/foundation.dart';
import 'package:http/http.dart' as http;
import 'package:in_app_update/in_app_update.dart';
import 'package:package_info_plus/package_info_plus.dart';
import 'package:universal_io/universal_io.dart';

import '../ayarlar.dart';
import '../models/ayarlar.dart';
import '../models/bildirim.dart';
import '../models/cagri_kaydi.dart';
import '../models/cihaz.dart';
import '../models/cihaz_duzenleme/cihaz_duzenleme.dart';
import '../models/cihaz_duzenleme/cihaz_turleri.dart';
import '../models/kullanici.dart';
import '../models/lisans/lisans.dart';
import '../models/lisans/versiyon.dart';
import '../models/malzeme_teslimi_model.dart';
import '../models/medya.dart';
import '../models/musteri.dart';
import '../models/not.dart';
import '../models/sifre.dart';
import 'secure_storage.dart';

class BiltekPost {
  final String auth;
  String hata = "";

  BiltekPost._(this.auth);

  factory BiltekPost.of(String auth) {
    return BiltekPost._(auth);
  }

  Future<http.StreamedResponse> postMultiPart(
    String url,
    List<http.MultipartFile> files,
    Map<String, String> data,
  ) async {
    data.addAll({"token": Ayarlar.token});
    data.addAll({"authM": auth});

    /*var headers = <String, String>{
      'Content-Type': 'application/json; charset=UTF-8',
    };*/
    var request = http.MultipartRequest("POST", Uri.parse(url));
    for (var i = 0; i < data.keys.length; i++) {
      String key = data.keys.elementAt(i);
      request.fields[key] = data[key]!;
    }
    for (var i = 0; i < files.length; i++) {
      request.files.add(files[i]);
    }

    ///request.headers.addAll(headers);

    http.StreamedResponse response = await request.send();

    return response;
  }

  Future<http.StreamedResponse> post(
    String url,
    Map<String, String> data,
  ) async {
    data.addAll({"token": Ayarlar.token});
    data.addAll({"authM": auth});

    /*var headers = <String, String>{
      'Content-Type': 'application/json; charset=UTF-8',
    };*/
    var request = http.Request("POST", Uri.parse(url));
    request.bodyFields = data;

    ///request.headers.addAll(headers);

    http.StreamedResponse response = await request.send();

    return response;
  }

  static Future<bool> guncellemeGerekli() async {
    try {
      if (kIsWeb) {
        return false;
      }
      bool guncelle;
      if (Platform.isAndroid) {
        AppUpdateInfo updateInfo = await InAppUpdate.checkForUpdate();
        guncelle =
            updateInfo.updateAvailability == UpdateAvailability.updateAvailable;
      } else {
        var response = await BiltekPost.of("").post(Ayarlar.version, {});
        if (response.statusCode == 201) {
          var resp = await response.stream.bytesToString();
          PackageInfo packageInfo = await PackageInfo.fromPlatform();
          debugPrint("Current version: ${packageInfo.buildNumber}");
          int currentVersion = int.parse(packageInfo.buildNumber);
          int updatedVersion = int.parse(resp);
          guncelle = currentVersion < updatedVersion;
        } else {
          guncelle = false;
        }
      }
      return guncelle;
    } on Exception catch (e) {
      debugPrint(e.toString());
      return false;
    }
  }

  Future<AyarlarModel?> ayarlar() async {
    try {
      var response = await post(Ayarlar.ayarlar, {});

      var resp = await response.stream.bytesToString();
      debugPrint("Ayarlar sonuç: $resp");
      if (response.statusCode == 201) {
        AyarlarModel ayarlar = AyarlarModel.fromJson(
          jsonDecode(resp) as Map<String, dynamic>,
        );
        return ayarlar;
      } else {
        return null;
      }
    } on Exception catch (e) {
      debugPrint(e.toString());
      hata =
          "Ayarlar alınırken bir hata oluştu. Lütfen daha sonra tekrar deneyin.";
      return null;
    }
  }

  static Future<KullaniciAuthModel?> kullaniciGetir(String auth) async {
    try {
      var response = await BiltekPost.of(
        "",
      ).post(Ayarlar.kullaniciGetir, {"auth": auth});
      if (response.statusCode == 201) {
        var resp = await response.stream.bytesToString();
        KullaniciGetirModel kullaniciGetir = KullaniciGetirModel.fromJson(
          jsonDecode(resp) as Map<String, dynamic>,
        );
        if (kullaniciGetir.durum) {
          return kullaniciGetir.kullanici;
        } else {
          return null;
        }
      } else {
        return null;
      }
    } on Exception catch (e) {
      debugPrint(e.toString());
      return null;
    }
  }

  Future<String?> kullaniciDuzenle({
    required String auth,
    required String adSoyad,
    required String kullaniciAdiOrjinal,
    required String kullaniciAdi,
    required String eskiSifre,
    required String yeniSifre,
    required String yeniSifreTekrar,
  }) async {
    try {
      Map<String, String> postData = {
        "auth": auth,
        "ad_soyad": adSoyad,
        "kullanici_adi_orj": kullaniciAdiOrjinal,
        "kullanici_adi": kullaniciAdi,
        "eski_sifre": eskiSifre,
        "yeni_sifre": yeniSifre,
        "yeni_sifre_tekrar": yeniSifreTekrar,
      };

      var response = await post(Ayarlar.kullaniciGuncelle, postData);
      var resp = await response.stream.bytesToString();
      if (response.statusCode == 201) {
        Map<String, dynamic> map =
            jsonDecode("${resp.split("}")[0]}}") as Map<String, dynamic>;
        if (map.containsKey("sonuc")) {
          if (map["sonuc"].toString() == "1") {
            return null;
          } else {
            return map["mesaj"]?.toString() ?? "Güncelleme başarısız oldu";
          }
        }
      }
      return "Güncelleme başarısız oldu";
    } on Exception catch (e) {
      debugPrint(e.toString());
      hata =
          "Kullanıcı bilgileri alınırken bir hata oluştu. Lütfen daha sonra tekrar deneyin.";
      return "Güncelleme başarısız oldu";
    }
  }

  Future<List<Cihaz>> cihazlariGetir({
    int? sorumlu,
    String? arama,
    List<dynamic> specific = const [],
    int offset = 0,
    int limit = 50,
  }) async {
    Map<String, String> postMap = {
      "sira": offset.toString(),
      "limit": limit.toString(),
    };
    if (sorumlu != null) {
      postMap.addAll({"sorumlu": sorumlu.toString()});
    }
    if (arama != null) {
      postMap.addAll({"arama": arama});
    }
    if (specific.isNotEmpty) {
      postMap.addAll({"specific": jsonEncode(specific)});
    }
    var response = await post(Ayarlar.cihazlarTumu, postMap);
    if (response.statusCode == 201) {
      var resp = await response.stream.bytesToString();
      try {
        List<dynamic> cihazlar = jsonDecode(resp) as List<dynamic>;
        return cihazlar
            .map((cihaz) => Cihaz.fromJson(cihaz as Map<String, dynamic>))
            .toList();
      } on Exception catch (e) {
        debugPrint(e.toString());
        throw Exception(
          "Cihazlar yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin",
        );
      }
    } else {
      throw Exception(
        "Cihazlar yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin",
      );
    }
  }

  static Future<Cihaz?> cihazGetirNoAuth({required int no}) async {
    Map<String, String> postData = {"servis_no": no.toString()};

    var response = await BiltekPost.of(
      "",
    ).post(Ayarlar.tekCihazNoAuth, postData);
    var resp = await response.stream.bytesToString();
    if (response.statusCode == 201) {
      try {
        Cihaz cihaz = Cihaz.fromJson(jsonDecode(resp) as Map<String, dynamic>);
        return cihaz;
      } on Exception catch (e) {
        debugPrint(e.toString());
        return null;
      }
    } else {
      debugPrint(
        "Cihaz yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin",
      );
      return null;
    }
  }

  Future<Cihaz?> cihazGetir({required int no}) async {
    Map<String, String> postData = {"servis_no": no.toString()};

    var response = await post(Ayarlar.tekCihaz, postData);
    var resp = await response.stream.bytesToString();
    if (response.statusCode == 201) {
      try {
        Cihaz cihaz = Cihaz.fromJson(jsonDecode(resp) as Map<String, dynamic>);
        return cihaz;
      } on Exception catch (e) {
        debugPrint(e.toString());
        return null;
      }
    } else {
      debugPrint(
        "Cihaz yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin",
      );
      return null;
    }
  }

  Future<void> fcmToken({
    required String auth,
    required String fcmToken,
  }) async {
    try {
      var response = await post(Ayarlar.fcmToken, {
        "auth": auth,
        "fcmToken": fcmToken,
      });
      await response.stream.bytesToString();
    } on Exception catch (e) {
      debugPrint("fcmToken güncellenemedi: ${e.toString()}");
    }
  }

  Future<void> fcmTokenSifirla({required String? fcmToken}) async {
    try {
      if (fcmToken != null) {
        var response = await post(Ayarlar.fcmTokenSifirla, {
          "fcmToken": fcmToken,
        });
        await response.stream.bytesToString();
      }
    } on Exception catch (e) {
      debugPrint("fcmToken sıfırlanamadı: ${e.toString()}");
    }
  }

  Future<void> fcmTokenGuncelle(String auth, String? token) async {
    if (token != null) {
      await SecureStorage.setString(SecureStorage.fcmTokenString, token);
      await fcmToken(auth: auth, fcmToken: token);
    }
  }

  static Future<void> bilgisayardaAc({
    required int kullaniciID,
    required int no,
  }) async {
    try {
      var response = await BiltekPost.of("").post(Ayarlar.bilgisayardaAc, {
        "kullanici_id": kullaniciID.toString(),
        "servis_no": no.toString(),
      });
      await response.stream.bytesToString();
    } on Exception catch (e) {
      debugPrint(e.toString());
      debugPrint("Bilgisayarda ac çalışmadı");
    }
  }

  Future<List<MedyaModel>> medyalariGetir({required int id}) async {
    Map<String, String> postData = {};
    postData.addAll({"id": id.toString()});
    var response = await post(Ayarlar.medyalar, postData);
    var resp = await response.stream.bytesToString();
    if (response.statusCode == 201) {
      try {
        var map = jsonDecode(resp) as List<dynamic>;
        List<MedyaModel> medyaList =
            map
                .map((m) => MedyaModel.fromJson(m as Map<String, dynamic>))
                .toList();
        return medyaList;
      } on Exception catch (e) {
        debugPrint(e.toString());
        return [];
      }
    } else {
      debugPrint(
        "Medyalar yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin",
      );
      return [];
    }
  }

  Future<bool> medyaYukle({required int id, required Uint8List medya}) async {
    var response = await postMultiPart(
      Ayarlar.medyaYukle,
      [
        http.MultipartFile.fromBytes(
          "yuklenecekDosya",
          medya,
          filename: "upload.png",
        ),
      ],
      {"id": id.toString()},
    );
    var resp = await response.stream.bytesToString();
    if (response.statusCode == 201) {
      try {
        Map<String, dynamic> map =
            jsonDecode("${resp.split("}")[0]}}") as Map<String, dynamic>;
        if (map.containsKey("sonuc") && map["sonuc"].toString() == "1") {
          return true;
        }
      } on Exception catch (e) {
        debugPrint(e.toString());
      }
    }
    return false;
  }

  Future<bool> medyaSil({required int id}) async {
    var response = await post(Ayarlar.medyaSil, {"id": id.toString()});
    var resp = await response.stream.bytesToString();
    debugPrint(resp);
    if (response.statusCode == 201) {
      try {
        Map<String, dynamic> map =
            jsonDecode("${resp.split("}")[0]}}") as Map<String, dynamic>;
        if (map.containsKey("sonuc") && map["sonuc"].toString() == "1") {
          return true;
        }
      } on Exception catch (e) {
        debugPrint(e.toString());
      }
    }
    return false;
  }

  Future<List<CihazTurleriModel>> cihazTurleri() async {
    var response = await post(Ayarlar.cihazTurleri, {});
    var resp = await response.stream.bytesToString();
    if (response.statusCode == 201) {
      try {
        var list = jsonDecode(resp) as List<dynamic>;
        return list
            .map(
              (tur) => CihazTurleriModel.fromJson(tur as Map<String, dynamic>),
            )
            .toList();
      } on Exception catch (e) {
        debugPrint(e.toString());
        return [];
      }
    } else {
      debugPrint(
        "Cihaz turleri yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin",
      );
      return [];
    }
  }

  Future<CihazDuzenlemeModel> cihazDuzenlemeGetir() async {
    var response = await post(Ayarlar.cihazDuzenleme, {});
    var resp = await response.stream.bytesToString();
    if (response.statusCode == 201) {
      try {
        var map = jsonDecode(resp) as Map<String, dynamic>;

        return CihazDuzenlemeModel.fromJson(map);
      } on Exception catch (e) {
        debugPrint(e.toString());
        return CihazDuzenlemeModel.bos();
      }
    } else {
      debugPrint(
        "Cihaz Duzenleme yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin",
      );
      return CihazDuzenlemeModel.bos();
    }
  }

  Future<bool> cihazEkle({required Map<String, String> postData}) async {
    var response = await post(Ayarlar.cihazEkle, postData);
    var resp = await response.stream.bytesToString();
    if (response.statusCode == 201) {
      try {
        Map<String, dynamic> map =
            jsonDecode("${resp.split("}")[0]}}") as Map<String, dynamic>;
        if (map.containsKey("sonuc") && map["sonuc"].toString() == "1") {
          return true;
        }
      } on Exception catch (e) {
        debugPrint(e.toString());
      }
    }
    return false;
  }

  Future<bool> cihazDuzenle({
    required int id,
    required Map<String, String> postData,
  }) async {
    postData.addAll({"id": id.toString()});
    var response = await post(Ayarlar.cihazDuzenle, postData);
    var resp = await response.stream.bytesToString();
    if (response.statusCode == 201) {
      try {
        Map<String, dynamic> map =
            jsonDecode("${resp.split("}")[0]}}") as Map<String, dynamic>;
        if (map.containsKey("sonuc") && map["sonuc"].toString() == "1") {
          return true;
        }
      } on Exception catch (e) {
        debugPrint(e.toString());
      }
    }
    return false;
  }

  Future<List<MusteriModel>> musteriBilgileriGetir(String musteriAdi) async {
    Map<String, String> postMap = {};

    postMap.addAll({"ara": musteriAdi});

    var response = await post(Ayarlar.musteriler, postMap);
    if (response.statusCode == 201) {
      var resp = await response.stream.bytesToString();
      try {
        debugPrint(resp);
        List<dynamic> musteriler = jsonDecode(resp) as List<dynamic>;
        return musteriler
            .map(
              (cihaz) => MusteriModel.fromJson(cihaz as Map<String, dynamic>),
            )
            .toList();
      } on Exception catch (e) {
        debugPrint("Musteri bilgileri yüklenirken bir hata oluştu. $e");
        return [];
      }
    } else {
      debugPrint("Musteri bilgileri yüklenirken bir hata oluştu.");
      return [];
    }
  }

  Future<List<Lisans>> lisanslariGetir() async {
    Map<String, String> postMap = {};

    var response = await post(Ayarlar.lisanslarTumu, postMap);
    if (response.statusCode == 201) {
      var resp = await response.stream.bytesToString();
      try {
        debugPrint(resp);
        List<dynamic> lisanslar = jsonDecode(resp) as List<dynamic>;
        return lisanslar
            .map((cihaz) => Lisans.fromJson(cihaz as Map<String, dynamic>))
            .toList();
      } on Exception catch (e) {
        debugPrint(e.toString());
        throw Exception(
          "Lisanslar yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin",
        );
      }
    } else {
      throw Exception(
        "Lisanslar yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin",
      );
    }
  }

  Future<bool> lisansEkle({required Map<String, String> postData}) async {
    var response = await post(Ayarlar.lisansEkle, postData);
    if (response.statusCode == 201) {
      var resp = await response.stream.bytesToString();
      try {
        debugPrint(resp);
        Map<String, dynamic> sonuc = jsonDecode(resp) as Map<String, dynamic>;
        if (sonuc.containsKey("durum")) {
          return sonuc["durum"] as bool;
        } else {
          return false;
        }
      } on Exception catch (e) {
        debugPrint(e.toString());
        return false;
      }
    } else {
      return false;
    }
  }

  Future<bool> lisansDuzenle({
    required int id,
    required Map<String, String> postData,
  }) async {
    postData.addAll({"id": id.toString()});
    var response = await post(Ayarlar.lisansDuzenle, postData);
    if (response.statusCode == 201) {
      var resp = await response.stream.bytesToString();
      try {
        debugPrint(resp);
        Map<String, dynamic> sonuc = jsonDecode(resp) as Map<String, dynamic>;
        if (sonuc.containsKey("durum")) {
          return sonuc["durum"] as bool;
        } else {
          return false;
        }
      } on Exception catch (e) {
        debugPrint(e.toString());
        return false;
      }
    } else {
      return false;
    }
  }

  Future<bool> lisansSil(int id) async {
    Map<String, String> postMap = {"id": id.toString()};

    var response = await post(Ayarlar.lisansSil, postMap);
    if (response.statusCode == 201) {
      var resp = await response.stream.bytesToString();
      try {
        debugPrint(resp);
        Map<String, dynamic> sonuc = jsonDecode(resp) as Map<String, dynamic>;
        if (sonuc.containsKey("durum")) {
          return sonuc["durum"] as bool;
        } else {
          return false;
        }
      } on Exception catch (e) {
        debugPrint(e.toString());
        return false;
      }
    } else {
      return false;
    }
  }

  Future<List<Versiyon>> versiyonlariGetir() async {
    Map<String, String> postMap = {};

    var response = await post(Ayarlar.versiyonlarTumu, postMap);
    if (response.statusCode == 201) {
      var resp = await response.stream.bytesToString();
      try {
        debugPrint(resp);
        List<dynamic> versiyonlar = jsonDecode(resp) as List<dynamic>;
        return versiyonlar
            .map((cihaz) => Versiyon.fromJson(cihaz as Map<String, dynamic>))
            .toList();
      } on Exception catch (e) {
        debugPrint(e.toString());
        throw Exception(
          "Versiyonlar yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin",
        );
      }
    } else {
      throw Exception(
        "Versiyonlar yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin",
      );
    }
  }

  Future<bool> versiyonEkle({required Map<String, String> postData}) async {
    var response = await post(Ayarlar.versiyonEkle, postData);
    if (response.statusCode == 201) {
      var resp = await response.stream.bytesToString();
      try {
        debugPrint(resp);
        Map<String, dynamic> sonuc = jsonDecode(resp) as Map<String, dynamic>;
        if (sonuc.containsKey("durum")) {
          return sonuc["durum"] as bool;
        } else {
          return false;
        }
      } on Exception catch (e) {
        debugPrint(e.toString());
        return false;
      }
    } else {
      return false;
    }
  }

  Future<bool> versiyonDuzenle({
    required int id,
    required Map<String, String> postData,
  }) async {
    postData.addAll({"id": id.toString()});
    var response = await post(Ayarlar.versiyonDuzenle, postData);
    if (response.statusCode == 201) {
      var resp = await response.stream.bytesToString();
      try {
        debugPrint(resp);
        Map<String, dynamic> sonuc = jsonDecode(resp) as Map<String, dynamic>;
        if (sonuc.containsKey("durum")) {
          return sonuc["durum"] as bool;
        } else {
          return false;
        }
      } on Exception catch (e) {
        debugPrint(e.toString());
        return false;
      }
    } else {
      return false;
    }
  }

  Future<bool> versiyonSil(int id) async {
    Map<String, String> postMap = {"id": id.toString()};

    var response = await post(Ayarlar.versiyonSil, postMap);
    if (response.statusCode == 201) {
      var resp = await response.stream.bytesToString();
      try {
        debugPrint(resp);
        Map<String, dynamic> sonuc = jsonDecode(resp) as Map<String, dynamic>;
        if (sonuc.containsKey("durum")) {
          return sonuc["durum"] as bool;
        } else {
          return false;
        }
      } on Exception catch (e) {
        debugPrint(e.toString());
        return false;
      }
    } else {
      return false;
    }
  }

  Future<List<BildirimModel>> bildirimleriGetir(int kullaniciID) async {
    try {
      var response = await post(Ayarlar.bildirimleriGetir, {
        "kullanici_id": kullaniciID.toString(),
      });
      if (response.statusCode == 201) {
        var resp = await response.stream.bytesToString();
        List<dynamic> bildirimler = jsonDecode(resp) as List<dynamic>;
        return bildirimler
            .map(
              (bildirim) =>
                  BildirimModel.fromJson(bildirim as Map<String, dynamic>),
            )
            .toList();
      } else {
        return [];
      }
    } on Exception catch (e) {
      debugPrint(e.toString());
      return [];
    }
  }

  Future<bool> bildirimAyarla(int kullaniciID, String tur, bool durum) async {
    try {
      var response = await post(Ayarlar.bildirimAyarla, {
        "kullanici_id": kullaniciID.toString(),
        "tur": tur,
        "durum": durum.toString(),
      });
      var resp = await response.stream.bytesToString();
      debugPrint("durum: $resp");
      if (response.statusCode == 201) {
        Map<String, dynamic> map = jsonDecode(resp);
        if (map.containsKey("sonuc")) {
          int sonuc = int.tryParse(map["sonuc"].toString()) ?? 0;
          return sonuc == 1;
        }
        return false;
      } else {
        return false;
      }
    } on Exception catch (e) {
      debugPrint(e.toString());
      return false;
    }
  }

  Future<bool> bildirimAyarlaToplu(
    int kullaniciID,
    List<BildirimModel> bildirimler,
  ) async {
    try {
      String b = jsonEncode(bildirimler.map((b) => b.toJson()).toList());
      var response = await post(Ayarlar.bildirimAyarlaToplu, {
        "kullanici_id": kullaniciID.toString(),
        "bildirimler": b,
      });
      var resp = await response.stream.bytesToString();
      debugPrint("durum: $resp");
      if (response.statusCode == 201) {
        Map<String, dynamic> map = jsonDecode(resp);
        if (map.containsKey("sonuc")) {
          int sonuc = int.tryParse(map["sonuc"].toString()) ?? 0;
          return sonuc == 1;
        }
        return false;
      } else {
        return false;
      }
    } on Exception catch (e) {
      debugPrint(e.toString());
      return false;
    }
  }

  Future<List<CagriKaydiModel>> cagriKayitlari({int kullaniciID = 0}) async {
    try {
      Map<String, String> data = {};
      if (kullaniciID > 0) {
        data.addAll({"kullanici_id": kullaniciID.toString()});
      }
      var response = await post(Ayarlar.cagriKayitlari, data);
      if (response.statusCode == 201) {
        var resp = await response.stream.bytesToString();
        List<dynamic> cagrilar = jsonDecode(resp) as List<dynamic>;
        return cagrilar
            .map(
              (cagri) =>
                  CagriKaydiModel.fromJson(cagri as Map<String, dynamic>),
            )
            .toList();
      } else {
        return [];
      }
    } on Exception catch (ex) {
      debugPrint("Cağrı kaydı hata: $ex");
      return [];
    }
  }

  Future<CagriKaydiModel?> cagriKaydi({required int id}) async {
    try {
      var response = await post(Ayarlar.cagriKaydi, {"id": id.toString()});
      var resp = await response.stream.bytesToString();
      debugPrint("Çağrı kaydı sonuç: $resp");
      if (response.statusCode == 201) {
        var cagri = jsonDecode(resp) as Map<String, dynamic>;
        return CagriKaydiModel.fromJson(cagri);
      } else {
        return null;
      }
    } on Exception catch (ex) {
      debugPrint("Cağrı kaydı hata: $ex");
      return null;
    }
  }

  Future<bool> fiyatiOnayla({required int id}) async {
    try {
      var response = await post(Ayarlar.fiyatiOnayla, {"id": id.toString()});
      var resp = await response.stream.bytesToString();
      debugPrint("Fiyati onayla sonuç: $resp");
      if (response.statusCode == 201) {
        return true;
      } else {
        return false;
      }
    } on Exception catch (ex) {
      debugPrint("Fiyat onayı hata: $ex");
      return false;
    }
  }

  Future<bool> fiyatiReddet({required int id}) async {
    try {
      var response = await post(Ayarlar.fiyatiReddet, {"id": id.toString()});
      var resp = await response.stream.bytesToString();
      debugPrint("Fiyati reddet sonuç: $resp");
      if (response.statusCode == 201) {
        return true;
      } else {
        return false;
      }
    } on Exception catch (ex) {
      debugPrint("Fiyat reddet hata: $ex");
      return false;
    }
  }

  Future<bool> cagriKaydiSil({required int id}) async {
    try {
      var response = await post(Ayarlar.cagriKaydiSil, {"id": id.toString()});
      var resp = await response.stream.bytesToString();
      if (response.statusCode == 201) {
        Map<String, dynamic> sonuc = jsonDecode(resp) as Map<String, dynamic>;
        if (sonuc.containsKey("sonuc")) {
          return sonuc["sonuc"];
        }
        return false;
      } else {
        return false;
      }
    } on Exception catch (ex) {
      debugPrint("Çağrı kaydı sil hata: $ex");
      return false;
    }
  }

  Future<bool> imzaYukle({
    required int id,
    required Uint8List medya,
    required String points,
    required int kullaniciID,
    required String teslimAlan,
  }) async {
    var response = await postMultiPart(
      Ayarlar.imzaYukle,
      [
        http.MultipartFile.fromBytes(
          "yuklenecekDosya",
          medya,
          filename: "upload.png",
        ),
      ],
      {
        "id": id.toString(),
        "points": points,
        "uye_id": kullaniciID.toString(),
        "teslim_alan": teslimAlan,
      },
    );
    var resp = await response.stream.bytesToString();
    debugPrint(resp);
    if (response.statusCode == 201) {
      try {
        Map<String, dynamic> map =
            jsonDecode("${resp.split("}")[0]}}") as Map<String, dynamic>;
        if (map.containsKey("sonuc") && map["sonuc"].toString() == "1") {
          return true;
        }
      } on Exception catch (e) {
        debugPrint(e.toString());
      }
    }
    return false;
  }

  Future<bool> imzaSil({
    required int id,
    required int kullaniciID,
    required String teslimAlan,
  }) async {
    var response = await post(Ayarlar.imzaSil, {
      "id": id.toString(),
      "uye_id": kullaniciID.toString(),
      "teslim_alan": teslimAlan,
    });
    var resp = await response.stream.bytesToString();
    debugPrint(resp);
    if (response.statusCode == 201) {
      try {
        Map<String, dynamic> map =
            jsonDecode("${resp.split("}")[0]}}") as Map<String, dynamic>;
        if (map.containsKey("sonuc") && map["sonuc"].toString() == "1") {
          return true;
        }
      } on Exception catch (e) {
        debugPrint(e.toString());
      }
    }
    return false;
  }

  Future<bool> barkodGiris({required int id, required String qr}) async {
    var response = await post(Ayarlar.qrEkle, {"id": id.toString(), "qr": qr});
    var resp = await response.stream.bytesToString();
    if (response.statusCode == 201) {
      try {
        Map<String, dynamic> map =
            jsonDecode("${resp.split("}")[0]}}") as Map<String, dynamic>;
        if (map.containsKey("sonuc") && map["sonuc"].toString() == "1") {
          return true;
        }
      } on Exception catch (e) {
        debugPrint(e.toString());
      }
    }
    return false;
  }

  Future<List<MalzemeTeslimiModel>> malzemeTeslimleriGetir({
    String? arama,
    int offset = 0,
    int limit = 50,
  }) async {
    Map<String, String> postData = {
      "sira": offset.toString(),
      "limit": limit.toString(),
    };
    if (arama != null) {
      postData.addAll({"arama": arama});
    }
    var response = await post(Ayarlar.malzemeTeslimleri, postData);
    var resp = await response.stream.bytesToString();
    if (response.statusCode == 201) {
      try {
        List<dynamic> malzemeTeslimleri = jsonDecode(resp) as List<dynamic>;
        return malzemeTeslimleri
            .map(
              (not) =>
                  MalzemeTeslimiModel.fromJson(not as Map<String, dynamic>),
            )
            .toList();
      } on Exception catch (e) {
        debugPrint(
          "Malzeme Teslimleri yüklenirken bir hata oluştu.\n${e.toString()}",
        );
        return [];
      }
    } else {
      debugPrint(
        "Malzeme Teslimleri yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin",
      );
      return [];
    }
  }

  Future<List<NotModel>> notlariGetir() async {
    Map<String, String> postData = {};

    var response = await post(Ayarlar.notlar, postData);
    var resp = await response.stream.bytesToString();
    if (response.statusCode == 201) {
      try {
        List<dynamic> notlar = jsonDecode(resp) as List<dynamic>;
        return notlar
            .map((not) => NotModel.fromJson(not as Map<String, dynamic>))
            .toList();
      } on Exception catch (e) {
        debugPrint("Notlar yüklenirken bir hata oluştu.\n${e.toString()}");
        return [];
      }
    } else {
      debugPrint(
        "Notlar yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin",
      );
      return [];
    }
  }

  Future<bool> notEkle({
    required String aciklama,
    required int kullaniciID,
  }) async {
    var response = await post(Ayarlar.notEkle, {
      "aciklama": aciklama,
      "kullanici": kullaniciID.toString(),
    });
    var resp = await response.stream.bytesToString();
    if (response.statusCode == 201) {
      try {
        Map<String, dynamic> map =
            jsonDecode("${resp.split("}")[0]}}") as Map<String, dynamic>;
        if (map.containsKey("sonuc") && map["sonuc"].toString() == "1") {
          return true;
        }
      } on Exception catch (e) {
        debugPrint(e.toString());
      }
    }
    return false;
  }

  Future<bool> notDuzenle({
    required int id,
    required String aciklama,
    required int kullaniciID,
  }) async {
    var response = await post(Ayarlar.notDuzenle, {
      "id": id.toString(),
      "aciklama": aciklama,
      "kullanici": kullaniciID.toString(),
    });
    var resp = await response.stream.bytesToString();
    if (response.statusCode == 201) {
      try {
        Map<String, dynamic> map =
            jsonDecode("${resp.split("}")[0]}}") as Map<String, dynamic>;
        if (map.containsKey("sonuc") && map["sonuc"].toString() == "1") {
          return true;
        }
      } on Exception catch (e) {
        debugPrint(e.toString());
      }
    }
    return false;
  }

  Future<bool> notSil({required int id}) async {
    var response = await post(Ayarlar.notSil, {"id": id.toString()});
    var resp = await response.stream.bytesToString();
    if (response.statusCode == 201) {
      try {
        Map<String, dynamic> map =
            jsonDecode("${resp.split("}")[0]}}") as Map<String, dynamic>;
        if (map.containsKey("sonuc") && map["sonuc"].toString() == "1") {
          return true;
        }
      } on Exception catch (e) {
        debugPrint(e.toString());
      }
    }
    return false;
  }

  Future<List<SifreModel>> sifreleriGetir() async {
    Map<String, String> postData = {};

    var response = await post(Ayarlar.sifreler, postData);
    var resp = await response.stream.bytesToString();
    if (response.statusCode == 201) {
      try {
        List<dynamic> sifreler = jsonDecode(resp) as List<dynamic>;
        return sifreler
            .map((sifre) => SifreModel.fromJson(sifre as Map<String, dynamic>))
            .toList();
      } on Exception catch (e) {
        debugPrint("Şifreler yüklenirken bir hata oluştu.\n${e.toString()}");
        return [];
      }
    } else {
      debugPrint(
        "Şifreler yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin",
      );
      return [];
    }
  }

  Future<bool> sifreEkle({
    required String musteriAdi,
    required String aciklama,
    required String kAdi,
    required String sifre,
    required int kullaniciID,
  }) async {
    var response = await post(Ayarlar.sifreEkle, {
      "musteri_adi": musteriAdi,
      "aciklama": aciklama,
      "k_adi": kAdi,
      "sifre": sifre,
      "kullanici": kullaniciID.toString(),
    });
    var resp = await response.stream.bytesToString();
    if (response.statusCode == 201) {
      try {
        Map<String, dynamic> map =
            jsonDecode("${resp.split("}")[0]}}") as Map<String, dynamic>;
        if (map.containsKey("sonuc") && map["sonuc"].toString() == "1") {
          return true;
        }
      } on Exception catch (e) {
        debugPrint(e.toString());
      }
    }
    return false;
  }

  Future<bool> sifreDuzenle({
    required int id,
    required String musteriAdi,
    required String aciklama,
    required String kAdi,
    required String sifre,
    required int kullaniciID,
  }) async {
    var response = await post(Ayarlar.sifreDuzenle, {
      "id": id.toString(),
      "musteri_adi": musteriAdi,
      "aciklama": aciklama,
      "k_adi": kAdi,
      "sifre": sifre,
      "kullanici": kullaniciID.toString(),
    });
    var resp = await response.stream.bytesToString();
    if (response.statusCode == 201) {
      try {
        Map<String, dynamic> map =
            jsonDecode("${resp.split("}")[0]}}") as Map<String, dynamic>;
        if (map.containsKey("sonuc") && map["sonuc"].toString() == "1") {
          return true;
        }
      } on Exception catch (e) {
        debugPrint(e.toString());
      }
    }
    return false;
  }

  Future<bool> sifreSil({required int id}) async {
    var response = await post(Ayarlar.sifreSil, {"id": id.toString()});
    var resp = await response.stream.bytesToString();
    if (response.statusCode == 201) {
      try {
        Map<String, dynamic> map =
            jsonDecode("${resp.split("}")[0]}}") as Map<String, dynamic>;
        if (map.containsKey("sonuc") && map["sonuc"].toString() == "1") {
          return true;
        }
      } on Exception catch (e) {
        debugPrint(e.toString());
      }
    }
    return false;
  }
}
