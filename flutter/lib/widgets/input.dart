import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:intl/intl.dart';

import '../utils/islemler.dart';
import 'takvim/dialog.dart';

class BiltekTextField extends StatelessWidget {
  const BiltekTextField({
    super.key,
    this.controller,
    this.currentFocus,
    this.nextFocus,
    this.textInputAction,
    this.label,
    this.errorText,
    this.onChanged,
    this.onSubmitted,
    this.obscureText = false,
    this.enableSuggestions = true,
    this.autocorrect = true,
    this.suffix,
    this.inputFormatters,
    this.keyboardType,
    this.style,
  });

  final TextEditingController? controller;
  final FocusNode? currentFocus;
  final FocusNode? nextFocus;
  final TextInputAction? textInputAction;
  final String? label;
  final String? errorText;
  final Function(String)? onChanged;
  final Function(String)? onSubmitted;
  final bool obscureText;
  final bool enableSuggestions;
  final bool autocorrect;
  final Widget? suffix;
  final List<TextInputFormatter>? inputFormatters;
  final TextInputType? keyboardType;
  final TextStyle? style;

  @override
  Widget build(BuildContext context) {
    return TextField(
      controller: controller,
      focusNode: currentFocus,
      textInputAction: textInputAction ??
          (nextFocus != null ? TextInputAction.next : TextInputAction.done),
      keyboardType: keyboardType,
      decoration: InputDecoration(
        labelText: label,
        errorText: errorText,
        suffix: suffix,
      ),
      onChanged: onChanged,
      onSubmitted: (value) {
        if (nextFocus != null) {
          FocusScope.of(context).requestFocus(nextFocus);
        }
        onSubmitted?.call(value);
      },
      obscureText: obscureText,
      enableSuggestions: enableSuggestions,
      autocorrect: autocorrect,
      inputFormatters: inputFormatters,
      style: style,
    );
  }
}

class BiltekSifre extends StatefulWidget {
  const BiltekSifre({
    super.key,
    this.controller,
    this.currentFocus,
    this.nextFocus,
    this.textInputAction,
    this.label,
    this.errorText,
    this.onChanged,
    this.onSubmitted,
    this.keyboardType,
    this.style,
  });
  final TextEditingController? controller;
  final FocusNode? currentFocus;
  final FocusNode? nextFocus;
  final TextInputAction? textInputAction;
  final String? label;
  final String? errorText;
  final Function(String)? onChanged;
  final Function(String)? onSubmitted;
  final TextInputType? keyboardType;
  final TextStyle? style;

  @override
  State<BiltekSifre> createState() => _BiltekSifreState();
}

class _BiltekSifreState extends State<BiltekSifre> {
  bool sifreyiGoster = false;

  @override
  Widget build(BuildContext context) {
    return BiltekTextField(
      controller: widget.controller,
      currentFocus: widget.currentFocus,
      nextFocus: widget.nextFocus,
      textInputAction: widget.textInputAction,
      label: widget.label,
      errorText: widget.errorText,
      onChanged: widget.onChanged,
      onSubmitted: widget.onSubmitted,
      suffix: IconButton(
        onPressed: () {
          setState(() {
            sifreyiGoster = !sifreyiGoster;
          });
        },
        icon: Icon(
          sifreyiGoster ? Icons.visibility_off : Icons.visibility,
        ),
      ),
      obscureText: !sifreyiGoster,
      enableSuggestions: sifreyiGoster,
      autocorrect: sifreyiGoster,
      keyboardType: widget.keyboardType,
      style: widget.style,
    );
  }
}

class BiltekCheckbox extends StatelessWidget {
  const BiltekCheckbox({
    super.key,
    required this.label,
    this.value,
    this.onChanged,
  });
  final String label;
  final bool? value;
  final Function(bool?)? onChanged;
  @override
  Widget build(BuildContext context) {
    return ListTile(
      contentPadding: EdgeInsets.all(0),
      leading: Checkbox(
        value: value,
        onChanged: (value) {
          onChanged?.call(value);
        },
      ),
      title: Text(label),
      onTap: () {
        onChanged?.call(
          value != null ? !value! : false,
        );
      },
    );
  }
}

class BiltekSelect<T> extends StatelessWidget {
  const BiltekSelect({
    super.key,
    required this.title,
    this.value,
    this.items,
    this.onChanged,
    this.errorText,
    this.width,
  });
  final String? title;
  final T? value;
  final List<DropdownMenuItem<T>>? items;
  final Function(T?)? onChanged;
  final String? errorText;
  final double? width;

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: EdgeInsets.only(top: 15),
      width: width ?? MediaQuery.of(context).size.width,
      child: DropdownButtonFormField<T>(
        decoration: InputDecoration(
          labelText: title,
          border: OutlineInputBorder(
            borderSide: BorderSide(
              color: errorText != null
                  ? Theme.of(context).colorScheme.error
                  : Theme.of(context).colorScheme.primary,
            ),
          ),
          focusedBorder: OutlineInputBorder(
              borderSide: BorderSide(
            color: errorText != null
                ? Theme.of(context).colorScheme.error
                : Theme.of(context).colorScheme.primary,
          )),
          enabledBorder: OutlineInputBorder(
            borderSide: BorderSide(
              color: errorText != null
                  ? Theme.of(context).colorScheme.error
                  : Theme.of(context).colorScheme.primary,
            ),
          ),
          errorText: errorText,
        ),
        isExpanded: true,
        value: value,
        items: items,
        onChanged: onChanged,
      ),
    );
  }
}

class BiltekTarih extends StatelessWidget {
  const BiltekTarih({
    super.key,
    required this.controller,
    required this.label,
    this.errorText,
    this.format = Islemler.tarihFormat,
    this.onConfirm,
    this.onChanged,
    this.saatiGoster = true,
  });
  final String label;
  final String? errorText;
  final String format;
  final TextEditingController controller;
  final Function(DateTime?)? onConfirm;
  final ValueChanged<String>? onChanged;
  final bool saatiGoster;
  @override
  Widget build(BuildContext context) {
    return TextField(
      controller: controller,
      decoration: InputDecoration(
        labelText: label,
        errorText: errorText,
      ),
      readOnly: true,
      onTap: () {
        debugPrint(format);
        showTakvim(
          context,
          initialDate: controller.text.isEmpty
              ? DateTime.now()
              : DateFormat(format).parse(controller.text),
          onConfirm: (date) {
            onConfirm?.call(date!);
          },
          saatiGoster: saatiGoster,
        );
      },
      onChanged: onChanged,
    );
  }
}
