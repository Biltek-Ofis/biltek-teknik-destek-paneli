import 'package:flutter/services.dart';

class IpAddressInputFormatter extends TextInputFormatter {
  @override
  TextEditingValue formatEditUpdate(
    TextEditingValue oldValue,
    TextEditingValue newValue,
  ) {
    final isDeleting = newValue.text.length < oldValue.text.length;
    if (isDeleting) return newValue;

    String text = newValue.text;

    if (text.replaceAll(RegExp(r'[0-9.]'), '').isNotEmpty) return oldValue;

    final parts = text.split('.');

    if (parts.length > 4) return oldValue;

    for (int i = 0; i < parts.length; i++) {
      final part = parts[i];

      if (part.length > 3) return oldValue;

      if (part.isNotEmpty) {
        final val = int.tryParse(part);
        if (val != null && val > 255) return oldValue;
      }

      if (part.isEmpty && i < parts.length - 1) return oldValue;
    }

    String formatted = text;
    final lastPart = parts.last;

    if (lastPart.length == 3 && parts.length < 4) {
      final val = int.tryParse(lastPart);
      if (val != null && val <= 255) {
        formatted = '$text.';
      }
    }

    return TextEditingValue(
      text: formatted,
      selection: TextSelection.collapsed(offset: formatted.length),
    );
  }
}
