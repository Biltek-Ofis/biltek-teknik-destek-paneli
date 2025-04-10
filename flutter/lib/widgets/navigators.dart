import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class BiltekBottomNavigationBar extends StatelessWidget {
  const BiltekBottomNavigationBar({
    super.key,
    required this.items,
    required this.currentIndex,
    required this.onTap,
    this.selectedItemColor,
    this.unselectedItemColor,
  });
  final List<BottomNavigationBarItem> items;
  final int currentIndex;
  final ValueChanged<int>? onTap;
  final Color? selectedItemColor;
  final Color? unselectedItemColor;
  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(1.0),
      decoration: BoxDecoration(
        color: Theme.of(context).appBarTheme.backgroundColor,
      ),
      child: BottomNavigationBar(
        elevation: 0,
        iconSize: 20,
        type: BottomNavigationBarType.fixed,
        items: items,
        currentIndex: currentIndex,
        backgroundColor: Theme.of(context).appBarTheme.backgroundColor,
        selectedItemColor: selectedItemColor ??
            Theme.of(context).appBarTheme.iconTheme?.color?.withAlpha(170),
        unselectedItemColor: unselectedItemColor ??
            Theme.of(context).appBarTheme.iconTheme?.color,
        selectedLabelStyle: GoogleFonts.dynaPuff(
          fontSize: 10,
        ),
        unselectedLabelStyle: GoogleFonts.dynaPuff(
          fontSize: 10,
        ),
        onTap: onTap,
      ),
    );
  }
}
