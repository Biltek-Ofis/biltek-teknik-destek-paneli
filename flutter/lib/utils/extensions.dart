String _numberDisplay(
  String num, {
  String decimalSeperator = ",",
  String thousandSeparator = ".",
}) {
  assert(
    thousandSeparator != "",
    "[thousandSeparator] value as the number separator must not be empty!",
  );
  assert(
    decimalSeperator != "",
    "[decimalSeperator] value as the decimal separator must not be empty!",
  );
  assert(
    thousandSeparator != decimalSeperator,
    "[thousandSeparator] and [decimalSeperator] values must not be the same!",
  );
  int qty = 3;
  String tempNum = num;
  tempNum = tempNum.replaceAll(".", decimalSeperator);
  String sign = "";
  String decimal = "";

  if (RegExp(r'^[-+]?[0-9](\d+\.?\d*|\.\d+)').hasMatch(num)) {
    if (num[0] == "+" || num[0] == "-") {
      sign = num[0];
      tempNum = num.substring(1);
    }
    if (tempNum.contains(decimalSeperator)) {
      decimal = "$decimalSeperator${tempNum.split(decimalSeperator)[1]}";
      tempNum = tempNum.split(decimalSeperator)[0];
    }
  }

  return sign +
      (tempNum
          .split('')
          .reversed
          .join()
          .replaceAllMapped(
            RegExp(r'(.{})(?!$)'.replaceAll('''{}''', '''{$qty}''')),
            (m) => '${m[0]}$thousandSeparator',
          )
          .split('')
          .reversed
          .join()) +
      decimal;
}

extension DoubleExt on double {
  String toUcret({
    int decimals = 2,
    String decimalSeperator = ",",
    String thousandSeparator = ".",
  }) {
    return _numberDisplay(
      toStringAsFixed(decimals),
      decimalSeperator: decimalSeperator,
      thousandSeparator: thousandSeparator,
    );
  }
}
