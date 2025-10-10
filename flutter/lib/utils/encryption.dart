import 'package:encrypt/encrypt.dart' as encryption;

class Encryption {
  static const String _encryptionKey = String.fromEnvironment('ENCRYPTION_KEY');
  static const String _encryptionIV = String.fromEnvironment('ENCRYPTION_IV');
  static encryption.IV get _iv => encryption.IV.fromUtf8(_encryptionIV);
  static final encryption.Encrypter _encrypter = encryption.Encrypter(
    encryption.AES(
      encryption.Key.fromUtf8(_encryptionKey),
      mode: encryption.AESMode.cbc,
    ),
  );

  static String encrypt(String str) {
    final encrypted = _encrypter.encrypt(str, iv: _iv);
    return encrypted.base64;
  }

  static String decrypt(String str) {
    return _encrypter.decrypt(encryption.Encrypted.from64(str), iv: _iv);
  }
}
