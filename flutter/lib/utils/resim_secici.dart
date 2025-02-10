import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';

typedef ResimSecildi = Function(XFile? resim);

class ResimSecici {
  final BuildContext _context;
  final ImagePicker _picker;

  ResimSecici._(this._context, this._picker);

  factory ResimSecici.of(BuildContext context) {
    return ResimSecici._(context, ImagePicker());
  }
  void sec({required ResimSecildi resimSecildi}) {
    showModalBottomSheet<void>(
      context: _context,
      builder: (context) {
        return SizedBox(
          height: 100,
          child: Center(
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              mainAxisSize: MainAxisSize.min,
              children: <Widget>[
                TextButton(
                  onPressed: () async {
                    Navigator.pop(context);
                    final resim = await _picker.pickImage(
                      source: ImageSource.camera,
                      preferredCameraDevice: CameraDevice.rear,
                      maxWidth: 1000,
                      maxHeight: 1000,
                    );

                    resimSecildi.call(resim);
                  },
                  child: Text("Kamera"),
                ),
                TextButton(
                  onPressed: () async {
                    Navigator.pop(context);
                    final resim = await _picker.pickImage(
                      source: ImageSource.gallery,
                      maxWidth: 1000,
                      maxHeight: 1000,
                    );

                    resimSecildi.call(resim);
                  },
                  child: Text("Galeri"),
                ),
              ],
            ),
          ),
        );
      },
    );
  }
}
