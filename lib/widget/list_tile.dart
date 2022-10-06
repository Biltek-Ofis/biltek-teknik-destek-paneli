import 'package:flutter/material.dart';

class CustomListTile extends ListTile {
  const CustomListTile({
    super.key,
    super.leading,
    super.title,
    super.subtitle,
    super.trailing,
    super.isThreeLine,
    super.dense,
    super.visualDensity,
    super.shape,
    super.style,
    super.selectedColor,
    super.iconColor,
    super.textColor,
    super.contentPadding,
    super.enabled,
    this.onHover,
    super.onTap,
    super.onLongPress,
    super.mouseCursor,
    super.selected,
    super.focusColor,
    super.hoverColor,
    super.focusNode,
    super.autofocus,
    super.tileColor,
    super.selectedTileColor,
    super.enableFeedback,
    super.horizontalTitleGap,
    super.minVerticalPadding,
    super.minLeadingWidth,
  });
  final ValueChanged<bool>? onHover;
  @override
  Widget build(BuildContext context) {
    return InkWell(onHover: onHover, child: super.build(context));
  }
}
