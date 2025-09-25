import 'package:flutter/material.dart';

class BiltekListTile extends StatelessWidget {
  const BiltekListTile({
    super.key,
    this.leading,
    this.trailing,
    this.title,
    this.subtitle,
    this.onTap,
  });
  final Widget? leading;
  final Widget? trailing;
  final String? title;
  final String? subtitle;
  final VoidCallback? onTap;

  @override
  Widget build(BuildContext context) {
    return ListTile(
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
      onTap: onTap,
    );
  }
}
