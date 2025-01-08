import 'widget.dart';

/// A class that provides constants for weekdays and month names.
class Constants {
  /// A list of abbreviated weekday names.
  static const List<String> weekDayName = [
    "Pzt",
    "Sal",
    "Çar",
    "Per",
    "Cum",
    "Cmt",
    "Paz",
  ];

  /// A list of full month names.
  static const List<String> repeatMonthNames = [
    'Ocak',
    'Şubat',
    'Mart',
    'Nisan',
    'Mayıs',
    'Haziran',
    'Temmuz',
    'Ağustos',
    'Eylül',
    'Ekim',
    'Kasım',
    'Aralık',
  ];
}

extension TarihSeciciArkaplanExtension on TarihSeciciArkaplan {
  String get imageUrl {
    String url;
    switch (this) {
      case TarihSeciciArkaplan.christmas:
        url =
            'https://www.icegif.com/wp-content/uploads/2022/12/icegif-1268.gif';
        break;
      case TarihSeciciArkaplan.winter:
        url = 'https://cdn.wallpapersafari.com/92/98/xryMFe.jpg';
        break;
      case TarihSeciciArkaplan.smokyLeaves:
        url =
            'https://images.pexels.com/photos/1379636/pexels-photo-1379636.jpeg?cs=srgb&dl=pexels-irina-iriser-1379636.jpg&fm=jpg';
        break;
      case TarihSeciciArkaplan.snowFall:
        url = 'https://www.animationsoftware7.com/img/agifs/snow02.gif';
        break;
      case TarihSeciciArkaplan.summer:
        url =
            'https://i.pinimg.com/originals/0c/9e/dc/0c9edcff20e55cc4c10101b537e6a362.jpg';
        break;
      case TarihSeciciArkaplan.halloween:
        url = 'https://images7.alphacoders.com/133/1334604.png';
        break;
      default:
        url = '';
        break;
    }
    return url;
  }
}
