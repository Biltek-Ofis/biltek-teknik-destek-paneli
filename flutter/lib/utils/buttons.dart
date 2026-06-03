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
    this.label,
    required this.onPressed,
    this.width,
    this.height = 40,
    this.loading = false,
    this.backgroundColor,
    this.textColor = Colors.white,
  });

  final IconData? icon;
  final String? label;
  final VoidCallback onPressed;
  final double? width;
  final double height;
  final bool loading;
  final Color? backgroundColor;
  final Color textColor;

  @override
  Widget build(BuildContext context) {
    final Color bg = backgroundColor ?? Theme.of(context).colorScheme.primary;

    if (label != null) {
      return _LabelButton(
        icon: icon,
        label: label!,
        onPressed: loading ? null : onPressed,
        width: width,
        height: height,
        bg: bg,
        textColor: textColor,
        loading: loading,
      );
    }

    if (icon != null) {
      return _IconButton(
        icon: icon!,
        onPressed: onPressed,
        size: height,
        bg: bg,
        textColor: textColor,
      );
    }

    return const SizedBox.shrink();
  }
}

class _LabelButton extends StatelessWidget {
  const _LabelButton({
    required this.label,
    required this.onPressed,
    required this.bg,
    required this.textColor,
    required this.loading,
    required this.height,
    this.icon,
    this.width,
  });

  final String label;
  final VoidCallback? onPressed;
  final Color bg;
  final Color textColor;
  final bool loading;
  final double height;
  final IconData? icon;
  final double? width;

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      width: width,
      height: height,
      child: FilledButton(
        onPressed: onPressed,
        style: FilledButton.styleFrom(
          backgroundColor: bg,
          disabledBackgroundColor: bg.withValues(alpha: 0.55),
          foregroundColor: textColor,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(12),
          ),
          padding: const EdgeInsets.symmetric(horizontal: 18),
          elevation: 0,
          animationDuration: const Duration(milliseconds: 150),
        ),
        child: AnimatedSwitcher(
          duration: const Duration(milliseconds: 180),
          child:
              loading
                  ? _LoadingIndicator(color: textColor)
                  : Row(
                    key: const ValueKey('content'),
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      if (icon != null) ...[
                        Icon(icon, size: 16, color: textColor),
                        const SizedBox(width: 7),
                      ],
                      Text(
                        label,
                        style: TextStyle(
                          color: textColor,
                          fontWeight: FontWeight.w600,
                          fontSize: 13.5,
                          letterSpacing: 0.1,
                        ),
                      ),
                    ],
                  ),
        ),
      ),
    );
  }
}

class _IconButton extends StatelessWidget {
  const _IconButton({
    required this.icon,
    required this.onPressed,
    required this.bg,
    required this.textColor,
    required this.size,
  });

  final IconData icon;
  final VoidCallback onPressed;
  final Color bg;
  final Color textColor;
  final double size;

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      width: size,
      height: size,
      child: FilledButton(
        onPressed: onPressed,
        style: FilledButton.styleFrom(
          backgroundColor: bg,
          foregroundColor: textColor,
          shape: const CircleBorder(),
          padding: EdgeInsets.zero,
          elevation: 0,
          animationDuration: const Duration(milliseconds: 120),
        ),
        child: Icon(icon, size: 18, color: textColor),
      ),
    );
  }
}

class _LoadingIndicator extends StatelessWidget {
  const _LoadingIndicator({required this.color});
  final Color color;

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      key: const ValueKey('loading'),
      width: 16,
      height: 16,
      child: CircularProgressIndicator(
        strokeWidth: 2,
        color: color.withValues(alpha: 0.8),
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
    this.height = 40,
    this.loading = false,
    this.backgroundColor = const Color.fromARGB(255, 58, 59, 58),
    this.textColor = Colors.white,
  });

  final IconData? icon;
  final String label;
  final VoidCallback onPressed;
  final double? width;
  final double height;
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
