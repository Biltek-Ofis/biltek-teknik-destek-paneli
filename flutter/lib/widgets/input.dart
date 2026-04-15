import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:intl/intl.dart';

import '../utils/islemler.dart';
import 'takvim/dialog.dart';

class BiltekTextField extends StatefulWidget {
  const BiltekTextField({
    super.key,
    this.controller,
    this.autofillHints,
    this.currentFocus,
    this.nextFocus,
    this.textInputAction,
    this.label,
    this.hint,
    this.errorText,
    this.onChanged,
    this.onSubmitted,
    this.obscureText = false,
    this.enableSuggestions = true,
    this.autocorrect = true,
    this.prefixIcon,
    this.suffix,
    this.inputFormatters,
    this.keyboardType,
    this.style,
    this.readOnly = false,
    this.onTap,
    this.border,
    this.onEditingComplete,
  });

  final TextEditingController? controller;
  final Iterable<String>? autofillHints;
  final FocusNode? currentFocus;
  final FocusNode? nextFocus;
  final TextInputAction? textInputAction;
  final String? label;
  final String? hint;
  final String? errorText;
  final Function(String)? onChanged;
  final Function(String)? onSubmitted;
  final bool obscureText;
  final bool enableSuggestions;
  final bool autocorrect;
  final IconData? prefixIcon;
  final Widget? suffix;
  final List<TextInputFormatter>? inputFormatters;
  final TextInputType? keyboardType;
  final TextStyle? style;
  final bool readOnly;
  final VoidCallback? onTap;
  final InputBorder? border;
  final VoidCallback? onEditingComplete;

  @override
  State<BiltekTextField> createState() => BiltekTextFieldState();
}

class BiltekTextFieldState extends State<BiltekTextField>
    with SingleTickerProviderStateMixin {
  late final AnimationController _lineCtrl;

  static const _accent = Color(0xFF00E676);
  static const _error = Color(0xFFFF5252);

  @override
  void initState() {
    super.initState();
    _lineCtrl = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 250),
    );
    widget.currentFocus?.addListener(_onFocusChange);
  }

  void _onFocusChange() {
    if (widget.currentFocus == null) {
      return;
    }
    if (widget.currentFocus!.hasFocus) {
      _lineCtrl.forward();
    } else {
      _lineCtrl.reverse();
    }
    setState(() {});
  }

  @override
  void dispose() {
    widget.currentFocus?.removeListener(_onFocusChange);
    _lineCtrl.dispose();
    super.dispose();
  }

  bool get _hasError =>
      widget.errorText != null && widget.errorText!.isNotEmpty;

  @override
  Widget build(BuildContext context) {
    final focused =
        widget.currentFocus != null ? widget.currentFocus!.hasFocus : false;

    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        AnimatedContainer(
          duration: const Duration(milliseconds: 200),
          decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(12),
            border: Border.all(
              color:
                  _hasError
                      ? Theme.of(context).colorScheme.error
                      : focused
                      ? _accent.withAlpha(180)
                      : Theme.of(context).colorScheme.primary,
              width: focused ? 1.5 : 1,
            ),
          ),
          child: Row(
            children: [
              if (widget.prefixIcon != null)
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 14),
                  child: Icon(
                    widget.prefixIcon,
                    size: 18,
                    color:
                        focused
                            ? _accent
                            : Theme.of(context).colorScheme.primary,
                  ),
                ),
              Expanded(
                child: TextField(
                  controller: widget.controller,
                  autofillHints: widget.autofillHints,
                  focusNode: widget.currentFocus,
                  textInputAction:
                      widget.textInputAction ??
                      (widget.nextFocus != null
                          ? TextInputAction.next
                          : TextInputAction.done),
                  keyboardType: widget.keyboardType,
                  decoration: InputDecoration(
                    labelText: widget.label,
                    labelStyle: TextStyle(
                      color:
                          focused
                              ? _accent.withAlpha(200)
                              : Theme.of(context).colorScheme.primary,
                      fontSize: 13,
                    ),
                    border: InputBorder.none,
                    contentPadding: const EdgeInsets.symmetric(vertical: 16),
                  ),
                  onChanged: widget.onChanged,
                  cursorColor: _accent,
                  onSubmitted: (value) {
                    if (widget.nextFocus != null) {
                      FocusScope.of(context).requestFocus(widget.nextFocus);
                    }
                    widget.onSubmitted?.call(value);
                  },
                  obscureText: widget.obscureText,
                  enableSuggestions: widget.enableSuggestions,
                  autocorrect: widget.autocorrect,
                  inputFormatters: widget.inputFormatters,
                  style:
                      widget.style ??
                      const TextStyle(
                        fontSize: 14,
                        fontWeight: FontWeight.w500,
                      ),
                  readOnly: widget.readOnly,
                  onTap: widget.onTap,
                  onEditingComplete: widget.onEditingComplete,
                ),
              ),
              if (widget.suffix != null)
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 14),
                  child: widget.suffix,
                ),
            ],
          ),
        ),
        if (_hasError) ...[
          const SizedBox(height: 4),
          Row(
            children: [
              const Icon(Icons.error_outline_rounded, size: 12, color: _error),
              const SizedBox(width: 4),
              Text(
                widget.errorText!,
                style: const TextStyle(color: _error, fontSize: 11),
              ),
            ],
          ),
        ],
      ],
    );
  }
}

class BiltekSifre extends StatefulWidget {
  const BiltekSifre({
    super.key,
    this.controller,
    this.autofillHints,
    this.currentFocus,
    this.nextFocus,
    this.textInputAction,
    this.label,
    this.prefixIcon,
    this.hint,
    this.errorText,
    this.onChanged,
    this.onSubmitted,
    this.keyboardType,
    this.style,
    this.readOnly = false,
    this.onTap,
    this.onEditingComplete,
  });
  final TextEditingController? controller;
  final Iterable<String>? autofillHints;
  final FocusNode? currentFocus;
  final FocusNode? nextFocus;
  final TextInputAction? textInputAction;
  final String? label;
  final IconData? prefixIcon;
  final String? hint;
  final String? errorText;
  final Function(String)? onChanged;
  final Function(String)? onSubmitted;
  final TextInputType? keyboardType;
  final TextStyle? style;
  final bool readOnly;
  final VoidCallback? onTap;
  final VoidCallback? onEditingComplete;

  @override
  State<BiltekSifre> createState() => _BiltekSifreState();
}

class _BiltekSifreState extends State<BiltekSifre> {
  bool sifreyiGoster = false;

  @override
  Widget build(BuildContext context) {
    final focused =
        widget.currentFocus != null ? widget.currentFocus!.hasFocus : false;

    return BiltekTextField(
      controller: widget.controller,
      autofillHints: widget.autofillHints,
      currentFocus: widget.currentFocus,
      nextFocus: widget.nextFocus,
      textInputAction: widget.textInputAction,
      label: widget.label,
      prefixIcon: widget.prefixIcon,
      hint: widget.hint,
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
          sifreyiGoster ? CupertinoIcons.eye : CupertinoIcons.eye_slash,
          color:
              focused
                  ? BiltekTextFieldState._accent.withAlpha(180)
                  : Theme.of(context).colorScheme.primary,
        ),
      ),
      obscureText: !sifreyiGoster,
      enableSuggestions: sifreyiGoster,
      autocorrect: sifreyiGoster,
      keyboardType: widget.keyboardType,
      style: widget.style,
      readOnly: widget.readOnly,
      onTap: widget.onTap,
      onEditingComplete: widget.onEditingComplete,
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
        onChanged?.call(value != null ? !value! : false);
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
              color:
                  errorText != null
                      ? Theme.of(context).colorScheme.error
                      : Theme.of(context).colorScheme.primary,
            ),
          ),
          focusedBorder: OutlineInputBorder(
            borderSide: BorderSide(
              color:
                  errorText != null
                      ? Theme.of(context).colorScheme.error
                      : Theme.of(context).colorScheme.primary,
            ),
          ),
          enabledBorder: OutlineInputBorder(
            borderSide: BorderSide(
              color:
                  errorText != null
                      ? Theme.of(context).colorScheme.error
                      : Theme.of(context).colorScheme.primary,
            ),
          ),
          errorText: errorText,
        ),
        isExpanded: true,
        initialValue: value,
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
      decoration: InputDecoration(labelText: label, errorText: errorText),
      readOnly: true,
      onTap: () {
        debugPrint(format);
        showTakvim(
          context,
          initialDate:
              controller.text.isEmpty
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
