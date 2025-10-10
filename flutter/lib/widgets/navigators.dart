import 'dart:ui';

import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class BiltekBottomNavigationBar extends StatelessWidget {
  const BiltekBottomNavigationBar({
    super.key,
    required this.items,
    required this.onTap,
    this.currentIndex = -1,
    this.selectedItemColor,
    this.unselectedItemColor,
    this.notchMargin = 5,
  });
  final List<BottomNavigationBarItem> items;
  final int currentIndex;
  final ValueChanged<int>? onTap;
  final Color? selectedItemColor;
  final Color? unselectedItemColor;
  final double notchMargin;
  @override
  Widget build(BuildContext context) {
    return BottomAppBar(
      color: Colors.transparent,
      shape: const CircularNotchedRectangle(),
      notchMargin: notchMargin,
      clipBehavior: Clip.antiAlias,
      elevation: 0,
      padding: EdgeInsets.all(0),
      child: SizedBox(
        height: kBottomNavigationBarHeight,
        child: BottomNavigationBar(
          elevation: 0,
          iconSize: 20,
          type: BottomNavigationBarType.fixed,
          items: items,
          currentIndex: currentIndex < 0 ? 0 : currentIndex,
          backgroundColor: Theme.of(context).appBarTheme.backgroundColor,
          selectedItemColor:
              currentIndex < 0
                  ? (unselectedItemColor ??
                      Theme.of(context).appBarTheme.iconTheme?.color)
                  : (selectedItemColor ??
                      Theme.of(
                        context,
                      ).appBarTheme.iconTheme?.color?.withAlpha(170)),
          unselectedItemColor:
              unselectedItemColor ??
              Theme.of(context).appBarTheme.iconTheme?.color,
          selectedLabelStyle: GoogleFonts.dynaPuff(fontSize: 10),
          unselectedLabelStyle: GoogleFonts.dynaPuff(fontSize: 10),
          onTap: onTap,
        ),
      ),
    );
  }
}
