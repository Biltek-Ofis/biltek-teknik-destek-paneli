import 'package:flutter/material.dart';

Widget buttonDef({
  required String text,
  double? width,
  double? height,
  double? fontSize,
  VoidCallback? onPressed,
}) {
  return ElevatedButton(
    onPressed: onPressed,
    style: ButtonStyle(
      backgroundColor: MaterialStateProperty.all<Color>(Colors.blue),
      alignment: Alignment.center,
    ),
    child: SizedBox(
      width: width,
      height: height,
      child: Center(
        child: Text(
          text,
          style: TextStyle(
            color: Colors.white,
            fontSize: fontSize,
          ),
        ),
      ),
    ),
  );
}
