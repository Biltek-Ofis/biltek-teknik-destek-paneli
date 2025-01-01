import 'package:flutter/material.dart';

class BiltekTextField extends StatelessWidget {
  const BiltekTextField({
    super.key,
    this.controller,
    this.currentFocus,
    this.nextFocus,
    this.label,
    this.errorText,
    this.onChanged,
    this.onSubmitted,
    this.obscureText = false,
    this.enableSuggestions = true,
    this.autocorrect = true,
    this.suffix,
  });

  final TextEditingController? controller;
  final FocusNode? currentFocus;
  final FocusNode? nextFocus;
  final String? label;
  final String? errorText;
  final Function(String)? onChanged;
  final Function(String)? onSubmitted;
  final bool obscureText;
  final bool enableSuggestions;
  final bool autocorrect;
  final Widget? suffix;

  @override
  Widget build(BuildContext context) {
    return TextField(
      controller: controller,
      focusNode: currentFocus,
      textInputAction:
          nextFocus != null ? TextInputAction.next : TextInputAction.done,
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
    );
  }
}

class BiltekSifre extends StatefulWidget {
  const BiltekSifre({
    super.key,
    this.controller,
    this.currentFocus,
    this.nextFocus,
    this.label,
    this.errorText,
    this.onChanged,
    this.onSubmitted,
  });
  final TextEditingController? controller;
  final FocusNode? currentFocus;
  final FocusNode? nextFocus;
  final String? label;
  final String? errorText;
  final Function(String)? onChanged;
  final Function(String)? onSubmitted;

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
    );
  }
}
