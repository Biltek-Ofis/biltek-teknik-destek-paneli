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
          backgroundColor: WidgetStateProperty.resolveWith<Color?>(
            (Set<WidgetState> states) {
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
            },
          ),
        ),
        child: Text(
          text,
          style: TextStyle(
            color: Colors.white,
          ),
        ),
      ),
    );
  }
}
