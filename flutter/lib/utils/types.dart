import 'package:flutter/material.dart';

typedef AramaDurumu = Function(bool durum);
typedef AramaText = Function(String value);

class AramaAppBar extends StatefulWidget {
  const AramaAppBar({
    super.key,
    required this.searchbarFocus,
    required this.aramaText,
    required this.aramaDurumu,
    this.hint = "Ara...",
  });

  final FocusNode searchbarFocus;
  final AramaText aramaText;
  final AramaDurumu aramaDurumu;
  final String hint;

  @override
  State<AramaAppBar> createState() => _AramaAppBarState();
}

class _AramaAppBarState extends State<AramaAppBar> {
  @override
  Widget build(BuildContext context) {
    return SafeArea(
      child: Builder(
        builder: (context) {
          WidgetStateProperty<Color?>? color =
              WidgetStateProperty.resolveWith<Color?>((
                Set<WidgetState> states,
              ) {
                return Colors.transparent; // Use the component's default.
              });
          Color textColor = Colors.white;
          return SearchBar(
            focusNode: widget.searchbarFocus,
            textInputAction: TextInputAction.search,
            padding: const WidgetStatePropertyAll<EdgeInsets>(
              EdgeInsets.symmetric(horizontal: 16.0),
            ),
            backgroundColor: color,
            shadowColor: color,
            overlayColor: color,
            surfaceTintColor: color,
            hintText: widget.hint,
            hintStyle: WidgetStateProperty.resolveWith<TextStyle?>((
              Set<WidgetState> states,
            ) {
              return TextStyle(color: textColor.withAlpha(150));
            }),
            textStyle: WidgetStateProperty.resolveWith<TextStyle?>((
              Set<WidgetState> states,
            ) {
              return TextStyle(color: textColor);
            }),
            onTap: () {
              ////controller.openView();
            },
            onChanged: (value) {
              widget.aramaText.call(value);
            },
            leading: IconButton(
              onPressed: () {
                widget.aramaDurumu.call(false);
              },
              color: Colors.white,
              icon: Icon(Icons.arrow_back),
            ),
            trailing: <Widget>[],
          );
        },
      ),
    );
  }
}
