import 'package:flutter/material.dart';

class DefaultButton extends StatelessWidget {
  const DefaultButton({
    super.key,
    required this.onPressed,
    this.text = "",
    this.background,
  });

  final VoidCallback? onPressed;
  final String text;
  final Color? background;

  @override
  Widget build(BuildContext context) {
    return ElevatedButton(
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
    );
  }
}
