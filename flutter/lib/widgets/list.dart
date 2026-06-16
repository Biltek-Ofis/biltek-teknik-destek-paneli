import 'package:flutter/material.dart';

class BiltekListTile extends StatelessWidget {
  const BiltekListTile({
    super.key,
    this.leading,
    this.trailing,
    this.title,
    this.subtitle,
    this.onTap,
    this.onLongPress,
    this.onTapDown,
  });
  final Widget? leading;
  final Widget? trailing;
  final String? title;
  final String? subtitle;
  final VoidCallback? onTap;
  final VoidCallback? onLongPress;
  final Function(TapDownDetails)? onTapDown;

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: onTap,
      onLongPress: onLongPress,
      onTapDown: onTapDown,
      child: ListTile(
        leading: leading,
        trailing: trailing,
        title: title != null ? Text(title!) : null,
        subtitleTextStyle: TextStyle(
          color: Theme.of(context).textTheme.bodySmall?.color?.withAlpha(200),
        ),
        subtitle:
            subtitle != null
                ? Container(
                  padding: EdgeInsets.only(left: 5),
                  child: Text(subtitle!),
                )
                : null,
      ),
    );
  }
}
