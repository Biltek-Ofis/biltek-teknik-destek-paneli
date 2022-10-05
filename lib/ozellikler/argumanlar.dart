import 'package:flutter/cupertino.dart';

class DirektGiris {
  DirektGiris(this.direktGiris);
  final bool direktGiris;
}

RouteSettings direktGirisRouteSettings(bool durum) {
  return RouteSettings(arguments: DirektGiris(durum));
}
