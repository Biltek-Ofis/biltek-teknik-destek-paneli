import 'package:flutter/material.dart';

class DefaultButton extends StatelessWidget {
  const DefaultButton({
    super.key,
    required this.onPressed,
    this.text = "",
    this.background,
    this.width,
  });

  final VoidCallback? onPressed;
  final String text;
  final Color? background;
  final double? width;

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      width: width,
      child: ElevatedButton(
        onPressed: onPressed,
        style: ButtonStyle(
          backgroundColor: WidgetStateProperty.resolveWith<Color?>((
            Set<WidgetState> states,
          ) {
            if (states.contains(WidgetState.pressed)) {
              if (background != null) {
                return background;
              }
              return Theme.of(context).colorScheme.primary.withAlpha(1);
            }
            if (background != null) {
              return background;
            }
            return Theme.of(context).colorScheme.primary;
          }),
        ),
        child: Text(text, style: TextStyle(color: Colors.white)),
      ),
    );
  }
}

class PrimaryButton extends StatelessWidget {
  const PrimaryButton({
    super.key,
    this.icon,
    required this.label,
    required this.onPressed,
    this.width,
    this.height,
    this.loading = false,
    this.backgroundColor,
    this.textColor = Colors.white,
    // this.backgroundColor1 = const Color(0xFF00E676),
    //this.backgroundColor2 = const Color(0xFF00C853),
  });

  final IconData? icon;
  final String label;
  final VoidCallback onPressed;
  final double? width;
  final double? height;
  final bool loading;
  final Color? backgroundColor;
  final Color textColor;

  @override
  Widget build(BuildContext context) {
    Color bg = backgroundColor ?? Theme.of(context).colorScheme.primary;
    return SizedBox(
      width: width,
      height: height ?? 40,
      child: OutlinedButton.icon(
        onPressed: loading ? null : onPressed,
        icon:
            icon != null
                ? Icon(icon, size: 18, color: textColor)
                : const SizedBox.shrink(),
        label: Text(
          label,
          style: TextStyle(
            color: textColor,
            fontWeight: FontWeight.w600,
            fontSize: 14,
          ),
        ),
        style: OutlinedButton.styleFrom(
          side: const BorderSide(width: 1.5),
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(12),
          ),
          backgroundColor: bg,
        ),
      ),
    );
  }
}

class SecondaryButton extends StatelessWidget {
  const SecondaryButton({
    super.key,
    this.icon,
    required this.label,
    required this.onPressed,
    this.width,
    this.height,
    this.loading = false,
    this.backgroundColor = const Color.fromARGB(255, 58, 59, 58),
    this.textColor = Colors.white,
  });

  final IconData? icon;
  final String label;
  final VoidCallback onPressed;
  final double? width;
  final double? height;
  final bool loading;
  final Color backgroundColor;
  final Color textColor;

  @override
  Widget build(BuildContext context) {
    return PrimaryButton(
      icon: icon,
      label: label,
      onPressed: onPressed,
      width: width,
      height: height,
      loading: loading,
      backgroundColor: backgroundColor,
      textColor: textColor,
    );
  }
}
