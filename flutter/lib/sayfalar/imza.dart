import 'dart:ui' as ui;

import 'package:biltekteknikservis/widgets/input.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:signature/signature.dart';

import '../models/cihaz.dart';
import '../models/kullanici.dart';
import '../utils/alerts.dart';
import '../utils/post.dart';

class ImzaSayfasi extends StatefulWidget {
  const ImzaSayfasi({
    super.key,
    required this.id,
    required this.points,
    required this.kullanici,
    required this.teslimAlan,
    required this.onYuklendi,
  });

  final int id;
  final List<Point> points;
  final KullaniciAuthModel kullanici;
  final String teslimAlan;
  final VoidCallback onYuklendi;

  @override
  State<ImzaSayfasi> createState() => _ImzaSayfasiState();
}

class _ImzaSayfasiState extends State<ImzaSayfasi> {
  late SignatureController _controller;

  bool _changed = false;
  bool _canUndo = false;
  bool _canRedo = false;
  TextEditingController teslimAlanController = TextEditingController();
  String? _adSoyadError;
  @override
  void initState() {
    super.initState();
    _controller = SignatureController(
      points: widget.points,
      penStrokeWidth: 5,
      penColor: Colors.black,
      exportBackgroundColor: Colors.white,
      onDrawStart: () {
        setState(() {
          _changed = true;
          _canUndo = true;
        });
      },
      onDrawMove: () {
        setState(() {
          _changed = true;
          _canUndo = true;
        });
      },
      onDrawEnd: () {
        setState(() {
          _changed = true;
          _canUndo = true;
        });
      },
    );
    Future.delayed(Duration.zero, () {
      if (widget.points.isNotEmpty) {
        setState(() {
          _canUndo = true;
        });
      }
      setState(() {
        teslimAlanController.text = widget.teslimAlan;
      });
    });
  }

  @override
  void dispose() {
    _controller.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SafeArea(
        child: Container(
          decoration: BoxDecoration(
            color: Theme.of(context).scaffoldBackgroundColor,
          ),
          child: Column(
            children: [
              Expanded(
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Padding(
                      padding: EdgeInsetsGeometry.symmetric(horizontal: 8),
                      child: BiltekTextField(
                        controller: teslimAlanController,
                        label: "Ad Soyad",
                        errorText: _adSoyadError,
                        onChanged: (val) {
                          setState(() {
                            _changed = true;
                            _adSoyadError = null;
                          });
                        },
                        border: const OutlineInputBorder(
                          // width: 0.0 produces a thin "hairline" border
                          borderSide: BorderSide(
                            color: Colors.black,
                            width: 1.0,
                          ),
                        ),
                      ),
                    ),
                    SizedBox(height: 5),
                    Text(
                      "Bu alanı imzalayın:",
                      style: TextStyle(
                        fontWeight: FontWeight.bold,
                        fontSize: 20,
                      ),
                    ),
                    SizedBox(height: 5),
                    Container(
                      decoration: BoxDecoration(
                        border: Border.all(color: Colors.black, width: 1),
                      ),
                      child: Signature(
                        controller: _controller,
                        width: MediaQuery.of(context).size.width,
                        height: 300,
                        backgroundColor: Colors.white,
                      ),
                    ),
                  ],
                ),
              ),
              Container(
                width: MediaQuery.of(context).size.width,
                height: 50,
                padding: EdgeInsets.all(8),
                decoration: BoxDecoration(
                  color: Theme.of(context).colorScheme.primary,
                ),
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  crossAxisAlignment: CrossAxisAlignment.stretch,
                  children: [
                    IconButton(
                      onPressed: () async {
                        await _imzaYukle();
                      },
                      icon: Icon(
                        CupertinoIcons.check_mark,
                        color: Theme.of(context).appBarTheme.iconTheme?.color,
                      ),
                    ),
                    IconButton(
                      onPressed:
                          _canUndo
                              ? () {
                                _undo();
                              }
                              : null,
                      icon: Icon(
                        CupertinoIcons.arrow_uturn_left,
                        color: Theme.of(context).appBarTheme.iconTheme?.color,
                      ),
                    ),
                    IconButton(
                      onPressed: () {
                        _controller.clear();
                        _setRedoUndo();
                      },
                      icon: Icon(
                        CupertinoIcons.delete,
                        color: Theme.of(context).appBarTheme.iconTheme?.color,
                      ),
                    ),
                    IconButton(
                      onPressed:
                          _canRedo
                              ? () {
                                _redo();
                              }
                              : null,
                      icon: Icon(
                        CupertinoIcons.arrow_uturn_right,
                        color: Theme.of(context).appBarTheme.iconTheme?.color,
                      ),
                    ),
                    IconButton(
                      onPressed: () {
                        if (!_changed) {
                          Navigator.of(context).pop();
                        } else {
                          showDialog(
                            context: context,
                            builder: (context) {
                              return AlertDialog(
                                title: Text("Değişiklikler Kaydedilmedi"),
                                content: Text(
                                  "Yapılan değişiklikler kaydedilmedi. Çıkmak istediğinize emin misiniz?",
                                ),
                                actions: [
                                  TextButton(
                                    onPressed: () {
                                      Navigator.of(context).pop();
                                      Navigator.of(context).pop();
                                    },
                                    child: Text("Evet"),
                                  ),
                                  TextButton(
                                    onPressed: () {
                                      Navigator.of(context).pop();
                                    },
                                    child: Text("Hayır"),
                                  ),
                                ],
                              );
                            },
                          );
                        }
                      },
                      icon: Icon(
                        CupertinoIcons.xmark,
                        color: Theme.of(context).appBarTheme.iconTheme?.color,
                      ),
                    ),
                  ],
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  Future<void> _imzaYukle() async {
    setState(() {
      _adSoyadError = null;
    });
    if (_changed) {
      _yukleniyorGoster();
      bool yuklendi = false;
      if (_controller.isNotEmpty) {
        if (teslimAlanController.text.trim().isNotEmpty) {
          ui.Image? image = await _controller.toImage();
          if (image != null) {
            final byteData = await image.toByteData(
              format: ui.ImageByteFormat.png,
            );
            if (byteData != null) {
              yuklendi = await BiltekPost.imzaYukle(
                id: widget.id,
                medya: byteData.buffer.asUint8List(),
                points: Cihaz.imzaPointsToJson(_controller.points),
                kullaniciID: widget.kullanici.id,
                teslimAlan: teslimAlanController.text.trim(),
              );
            }
          }
        } else {
          _yukleniyorGizle();
          setState(() {
            _adSoyadError = "Lütfen geçerli bir isim girin";
          });
          return;
        }
      } else {
        if (widget.points.isNotEmpty ||
            teslimAlanController.text.trim() != widget.teslimAlan) {
          yuklendi = await BiltekPost.imzaSil(
            id: widget.id,
            kullaniciID: widget.kullanici.id,
            teslimAlan: teslimAlanController.text.trim(),
          );
        } else {
          _yukleniyorGizle();
          _degisiklikYapilmadi();
          return;
        }
      }

      _yukleniyorGizle();
      if (yuklendi) {
        _yuklemeBasarili();
      } else {
        _yuklemeBasarisiz();
      }
    } else {
      _degisiklikYapilmadi();
    }
  }

  bool yukleniyorAcik = false;
  void _yukleniyorGoster() {
    if (mounted && !yukleniyorAcik) {
      setState(() {
        yukleniyorAcik = true;
      });
      yukleniyor(context);
    }
  }

  void _yukleniyorGizle() {
    if (mounted && yukleniyorAcik) {
      Navigator.pop(context);
      setState(() {
        yukleniyorAcik = false;
      });
    }
  }

  void _yuklemeBasarisiz() {
    showDialog(
      context: context,
      builder: (context) {
        return AlertDialog(
          title: Text("İmza Kaydetme Başarısız"),
          content: Text("İmza kaydedilirken bir hata oluştu."),
          actions: [
            TextButton(
              onPressed: () {
                Navigator.of(context).pop();
              },
              child: Text("Tamam"),
            ),
          ],
        );
      },
    );
  }

  void _yuklemeBasarili() {
    showDialog(
      context: context,
      barrierDismissible: false,
      builder: (context) {
        return AlertDialog(
          title: Text("İmza Başarılı"),
          content: Text("İmza başarıyla kaydedildi."),
          actions: [
            TextButton(
              onPressed: () {
                Navigator.of(context).pop();
                Navigator.of(context).pop();
                widget.onYuklendi.call();
              },
              child: Text("Tamam"),
            ),
          ],
        );
      },
    );
  }

  void _undo() {
    if (_controller.canUndo) {
      _controller.undo();
    }
    _setRedoUndo();
  }

  void _redo() {
    if (_controller.canRedo) {
      _controller.redo();
    }
    _setRedoUndo();
  }

  void _setRedoUndo() {
    setState(() {
      _canUndo = _controller.canUndo;
      _canRedo = _controller.canRedo;
    });
  }

  void _degisiklikYapilmadi() {
    showDialog(
      context: context,
      builder: (context) {
        return AlertDialog(
          title: Text("Değişiklik Yapılmadı"),
          content: Text(
            "Herhangi bir değişiklik yapılmadığı için kaydedilmedi.",
          ),
          actions: [
            TextButton(
              onPressed: () {
                Navigator.of(context).pop();
              },
              child: Text("Tamam"),
            ),
          ],
        );
      },
    );
  }
}
