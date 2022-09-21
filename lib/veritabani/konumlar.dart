import '../env.dart';

class Konumlar {
  static String get getRelativePath {
    return Env.path.substring(Env.path.length - 1) == "/"
        ? Env.path
        : "${Env.path}/";
  }

  static String girisYap(String kullaniciAdi, String sifre) {
    return "${getRelativePath}girisyap/$kullaniciAdi/$sifre/${Env.authToken}";
  }

  static String kullaniciBilgileri(int id) {
    return "${getRelativePath}kullaniciBilgileri/$id/${Env.authToken}";
  }

  static String cihazlar() {
    return "${getRelativePath}cihazlarTumu/${Env.authToken}";
  }
}
