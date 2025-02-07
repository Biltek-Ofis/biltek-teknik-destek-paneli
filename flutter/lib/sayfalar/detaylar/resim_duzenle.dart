import 'dart:typed_data';

import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import 'package:pro_image_editor/pro_image_editor.dart';

typedef ImageEditingCompleteCallback = Future<void> Function(Uint8List bytes);

class ResimDuzenle extends StatefulWidget {
  const ResimDuzenle({
    super.key,
    required this.resim,
    required this.onEditComplete,
  });
  final XFile resim;
  final ImageEditingCompleteCallback onEditComplete;

  @override
  State<ResimDuzenle> createState() => _ResimDuzenleState();
}

class _ResimDuzenleState extends State<ResimDuzenle> {
  Uint8List? bytes;

  @override
  void initState() {
    super.initState();
    Future.delayed(Duration.zero, () async {
      Uint8List bytesTemp = await widget.resim.readAsBytes();
      if (mounted) {
        setState(() {
          bytes = bytesTemp;
        });
      } else {
        bytes = bytesTemp;
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SizedBox(
        width: MediaQuery.of(context).size.width,
        height: MediaQuery.of(context).size.height,
        child: bytes != null
            ? ProImageEditor.memory(
                bytes!,
                callbacks: ProImageEditorCallbacks(
                  onImageEditingComplete: (bytes) async {
                    widget.onEditComplete.call(bytes);
                    Navigator.pop(context);
                  },
                ),
              )
            : Center(
                child: CircularProgressIndicator(),
              ),
      ),
    );
  }
}
