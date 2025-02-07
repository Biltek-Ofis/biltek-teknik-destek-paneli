import 'dart:typed_data';

import 'package:flutter/material.dart';
import 'package:pro_image_editor/pro_image_editor.dart';

typedef ImageEditingCompleteCallback = Future<void> Function(Uint8List bytes);

class ResimDuzenle extends StatefulWidget {
  const ResimDuzenle({
    super.key,
    required this.resim,
    required this.onEditComplete,
  });
  final Uint8List resim;
  final ImageEditingCompleteCallback onEditComplete;

  @override
  State<ResimDuzenle> createState() => _ResimDuzenleState();
}

class _ResimDuzenleState extends State<ResimDuzenle> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SizedBox(
        width: MediaQuery.of(context).size.width,
        height: MediaQuery.of(context).size.height,
        child: ProImageEditor.memory(
          widget.resim,
          callbacks: ProImageEditorCallbacks(
            onImageEditingComplete: (bytes) async {
              widget.onEditComplete.call(bytes);
            },
          ),
        ),
      ),
    );
  }
}
