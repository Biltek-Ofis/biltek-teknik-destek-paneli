import 'package:flutter/foundation.dart';

import '../ayarlar.dart';

void biltekPrint(String text) {
  if (kDebugMode || Ayarlar.enableReleaseLogs) {
    // ignore: avoid_print
    print(text);
  }
}
