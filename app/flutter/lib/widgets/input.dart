import 'package:flutter/material.dart';
import 'package:flutter/services.dart';

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
    this.value,
    this.items,
    this.onChanged,
    this.errorText,
  });
  final T? value;
  final List<DropdownMenuItem<T>>? items;
  final Function(T?)? onChanged;
  final String? errorText;

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      width: MediaQuery.of(context).size.width,
      child: DropdownButtonFormField<T>(
        decoration: InputDecoration(
          border: OutlineInputBorder(
            borderSide: BorderSide(
              color: Theme.of(context).colorScheme.error,
            ),
          ),
          focusedBorder: OutlineInputBorder(
              borderSide: BorderSide(
            color: Theme.of(context).colorScheme.error,
          )),
          enabledBorder: OutlineInputBorder(
            borderSide: BorderSide(
              color: Theme.of(context).colorScheme.error,
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
