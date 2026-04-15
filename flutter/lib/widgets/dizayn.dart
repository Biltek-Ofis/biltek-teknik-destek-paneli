import 'package:flutter/material.dart';

import '../utils/islemler.dart';

class SectionCard extends StatelessWidget {
  const SectionCard({
    super.key,
    this.icon,
    this.title,
    this.children,
    this.iconColor,
    this.backgroundColor,
    this.darkTheme,
    this.padding,
  });

  final IconData? icon;
  final String? title;
  final List<Widget>? children;
  final Color? iconColor;
  final Color? backgroundColor;
  final bool? darkTheme;
  final EdgeInsets? padding;

  @override
  Widget build(BuildContext context) {
    final isDark = Theme.of(context).brightness == Brightness.dark;
    return Card(
      color: backgroundColor,
      elevation: 0,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(16),
        side: BorderSide(
          color: (darkTheme ?? isDark) ? Colors.white12 : Colors.black12,
        ),
      ),
      child: Padding(
        padding: padding ?? const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          mainAxisAlignment: MainAxisAlignment.start,
          children: [
            if (icon != null || title != null)
              Row(
                children: [
                  if (icon != null)
                    Icon(
                      icon,
                      size: 18,
                      color: iconColor ?? Colors.greenAccent,
                    ),
                  if (title != null) const SizedBox(width: 8),
                  if (title != null)
                    Text(
                      title!,
                      style: TextStyle(
                        fontSize: 13,
                        fontWeight: FontWeight.w700,
                        color: iconColor ?? Colors.greenAccent,
                        letterSpacing: 0.3,
                      ),
                    ),
                ],
              ),
            if (children != null) const SizedBox(height: 12),
            if (children != null)
              Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                mainAxisAlignment: MainAxisAlignment.start,
                children: children!,
              ),
          ],
        ),
      ),
    );
  }
}

class StatusCard extends StatelessWidget {
  const StatusCard({super.key, required this.durum, required this.renk});
  final String durum;
  final String renk;

  @override
  Widget build(BuildContext context) {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(16),
        color: Islemler.arkaRenk(renk)?.withValues(alpha: 0.7),
        border: Border.all(color: Colors.greenAccent.withAlpha(80)),
      ),
      child: Row(
        children: [
          Container(
            width: 13,
            height: 13,
            decoration: BoxDecoration(
              color: Islemler.arkaRenk(renk),
              shape: BoxShape.circle,
              border: Border.all(color: Colors.black),
            ),
          ),
          const SizedBox(width: 10),
          Text(
            durum.isEmpty ? "—" : durum,
            style: TextStyle(
              fontWeight: FontWeight.bold,
              fontSize: 15,
              color: Islemler.yaziRengi(renk),
            ),
          ),
        ],
      ),
    );
  }
}

class InfoTile extends StatelessWidget {
  const InfoTile({
    super.key,
    this.labelFontSize,
    required this.label,
    this.valueFontSize = 14,
    required this.value,
    this.textColor,
    this.icon,
    this.iconColor,
    this.selectable = true,
    this.badge = false,
    this.multiline = false,
    this.padding = const EdgeInsets.symmetric(vertical: 5),
  });

  final double? labelFontSize;
  final String label;
  final double valueFontSize;
  final String value;
  final Color? textColor;
  final IconData? icon;
  final Color? iconColor;
  final bool selectable;
  final bool badge;
  final bool multiline;
  final EdgeInsets padding;

  @override
  Widget build(BuildContext context) {
    final empty = value.trim().isEmpty;
    final displayValue = empty ? "—" : value;
    Color? emptyColor =
        (textColor != null ? textColor?.withValues(alpha: 0.7) : Colors.grey);

    return Padding(
      padding: padding,
      child:
          multiline
              ? Wrap(
                crossAxisAlignment: WrapCrossAlignment.start,
                children: [
                  Container(
                    alignment: Alignment.topLeft,
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        _labelWidget(),
                        if (label.trim().isNotEmpty) const SizedBox(height: 3),
                        if (selectable)
                          SelectionArea(
                            child: Text(
                              displayValue,
                              style: TextStyle(
                                fontSize: valueFontSize,
                                color: empty ? emptyColor : textColor,
                              ),
                            ),
                          )
                        else
                          Text(
                            displayValue,
                            style: TextStyle(
                              fontSize: valueFontSize,
                              color: empty ? emptyColor : textColor,
                            ),
                          ),
                        Divider(
                          height: 12,
                          thickness: 0.4,
                          color: textColor ?? Colors.grey.withAlpha(80),
                        ),
                      ],
                    ),
                  ),
                ],
              )
              : Wrap(
                crossAxisAlignment: WrapCrossAlignment.start,
                children: [
                  if (icon != null) ...[
                    Icon(
                      icon,
                      size: 14,
                      color: iconColor ?? textColor ?? Colors.grey,
                    ),
                    const SizedBox(width: 4),
                  ],
                  _labelWidget(),
                  SizedBox(width: 8),
                  if (badge)
                    Container(
                      padding: const EdgeInsets.symmetric(
                        horizontal: 10,
                        vertical: 3,
                      ),
                      decoration: BoxDecoration(
                        color: Colors.greenAccent.withAlpha(30),
                        borderRadius: BorderRadius.circular(20),
                        border: Border.all(
                          color: Colors.greenAccent.withAlpha(100),
                        ),
                      ),
                      child:
                          selectable
                              ? SelectionArea(
                                child: Text(
                                  displayValue,
                                  style: TextStyle(
                                    fontSize: valueFontSize,
                                    fontWeight: FontWeight.bold,
                                    color: Colors.greenAccent,
                                  ),
                                ),
                              )
                              : Text(
                                displayValue,
                                style: TextStyle(
                                  fontSize: valueFontSize,
                                  fontWeight: FontWeight.bold,
                                  color: Colors.greenAccent,
                                ),
                              ),
                    )
                  else if (selectable)
                    SelectionArea(
                      child: Text(
                        displayValue,
                        textAlign: TextAlign.start,
                        style: TextStyle(
                          fontSize: valueFontSize,
                          color: empty ? emptyColor : textColor,
                        ),
                      ),
                    )
                  else
                    Text(
                      displayValue,
                      textAlign: TextAlign.start,
                      style: TextStyle(
                        fontSize: valueFontSize,
                        color: empty ? emptyColor : textColor,
                      ),
                    ),
                ],
              ),
    );
  }

  Widget _labelWidget() =>
      label.trim().isNotEmpty
          ? Text(
            "$label: ",
            style: TextStyle(
              fontSize: labelFontSize ?? 12,
              color: textColor ?? Colors.grey.shade500,
              fontWeight: FontWeight.bold,
            ),
          )
          : SizedBox();
}

class InfoTileList extends StatelessWidget {
  const InfoTileList({
    super.key,
    this.label,
    this.labelFontSize = 14,
    required this.value,
    this.valueFontSize = 15,
    this.textColor,
    this.icon,
    this.iconColor,
    this.selectable = true,
    this.badge = false,
    this.multiline = false,
    this.padding = const EdgeInsets.all(0),
  });
  final String? label;
  final double? labelFontSize;
  final String value;
  final double valueFontSize;
  final Color? textColor;
  final IconData? icon;
  final Color? iconColor;
  final bool selectable;
  final bool badge;
  final bool multiline;
  final EdgeInsets padding;

  @override
  Widget build(BuildContext context) {
    return InfoTile(
      label: label ?? "",
      labelFontSize: labelFontSize,
      value: value,
      valueFontSize: valueFontSize,
      textColor: textColor,
      icon: icon,
      iconColor: iconColor,
      selectable: selectable,
      badge: badge,
      multiline: multiline,
      padding: padding,
    );
  }
}

class PhoneActionBtn extends StatelessWidget {
  const PhoneActionBtn({
    super.key,
    this.icon,
    this.iconAsset,
    required this.label,
    required this.color,
    required this.onTap,
  }) : assert(icon != null || iconAsset != null);

  final IconData? icon;
  final String? iconAsset;
  final String label;
  final Color color;
  final VoidCallback onTap;

  @override
  Widget build(BuildContext context) {
    return InkWell(
      borderRadius: BorderRadius.circular(12),
      onTap: onTap,
      child: Container(
        padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 8),
        decoration: BoxDecoration(
          color: color.withAlpha(30),
          borderRadius: BorderRadius.circular(12),
          border: Border.all(color: color.withAlpha(80)),
        ),
        child: Column(
          children: [
            if (icon != null)
              Icon(icon, size: 20, color: color)
            else
              Image.asset(iconAsset!, width: 20, height: 20),
            const SizedBox(height: 3),
            Text(
              label,
              style: TextStyle(
                fontSize: 10,
                color: color,
                fontWeight: FontWeight.w600,
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class FabItem {
  const FabItem({
    required this.tag,
    required this.icon,
    required this.label,
    required this.onPressed,
  });
  final String tag;
  final IconData icon;
  final String label;
  final VoidCallback onPressed;
}

class AnimatedCheckbox extends StatelessWidget {
  const AnimatedCheckbox({
    super.key,
    required this.value,
    required this.onChanged,
  });

  final bool value;
  final ValueChanged<bool> onChanged;

  static const _accent = Color(0xFF00E676);
  static const _border = Color(0xFF2C2F3E);

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: () => onChanged(!value),
      child: AnimatedContainer(
        duration: const Duration(milliseconds: 180),
        width: 20,
        height: 20,
        decoration: BoxDecoration(
          color: value ? _accent.withAlpha(30) : Colors.transparent,
          borderRadius: BorderRadius.circular(5),
          border: Border.all(color: value ? _accent : _border, width: 1.5),
        ),
        child:
            value
                ? const Icon(Icons.check_rounded, size: 14, color: _accent)
                : null,
      ),
    );
  }
}

class ErrorBanner extends StatelessWidget {
  const ErrorBanner({super.key, required this.message});
  final String message;

  @override
  Widget build(BuildContext context) {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 10),
      decoration: BoxDecoration(
        color: const Color(0xFFFF5252).withAlpha(20),
        borderRadius: BorderRadius.circular(10),
        border: Border.all(color: const Color(0xFFFF5252).withAlpha(80)),
      ),
      child: Row(
        children: [
          const Icon(
            Icons.warning_amber_rounded,
            size: 16,
            color: Color(0xFFFF5252),
          ),
          const SizedBox(width: 8),
          Expanded(
            child: Text(
              message,
              style: const TextStyle(
                color: Color(0xFFFF5252),
                fontSize: 12,
                fontWeight: FontWeight.w500,
              ),
            ),
          ),
        ],
      ),
    );
  }
}
