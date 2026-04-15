import 'package:flutter/material.dart';

import '../../models/kullanici.dart';
import '../../models/not.dart';
import '../../utils/buttons.dart';
import '../../utils/islemler.dart';
import '../../utils/post.dart';
import '../../widgets/input.dart';

class NotEkleDuzenleSayfasi extends StatefulWidget {
  const NotEkleDuzenleSayfasi({
    super.key,
    required this.kullanici,
    this.not,
    this.notlariYenile,
  });

  final KullaniciAuthModel kullanici;
  final NotModel? not;
  final VoidCallback? notlariYenile;

  @override
  State<NotEkleDuzenleSayfasi> createState() => _NotEkleDuzenleSayfasiState();
}

class _NotEkleDuzenleSayfasiState extends State<NotEkleDuzenleSayfasi> {
  TextEditingController textEditingController = TextEditingController();
  bool girildi = false;
  String? error;
  FocusNode focusNode = FocusNode();

  @override
  void initState() {
    super.initState();
    if (widget.not != null) {
      textEditingController.text = widget.not!.aciklama;
    }
    Future.delayed(Duration.zero, () {
      focusNode.requestFocus();
    });
  }

  @override
  Widget build(BuildContext context) {
    return PopScope(
      canPop: false,
      onPopInvokedWithResult: (didPop, result) async {
        if (didPop) {
          return;
        }
        if (girildi) {
          NavigatorState navigatorState = Navigator.of(context);
          bool? result = await showDialog<bool>(
            context: context,
            builder: (context) {
              return AlertDialog(
                title: Text("Değişiklikler Kaydedilmedi"),
                content: Text(
                  "Kaydedilmeyen değişiklikleriniz var. Çıkmak istediğinize emin misiniz?",
                ),
                actions: [
                  TextButton(
                    onPressed: () {
                      navigatorState.pop(true);
                    },
                    child: Text(
                      "İptal Et ve Çık",
                      style: TextStyle(color: Colors.red),
                    ),
                  ),
                  TextButton(
                    onPressed: () {
                      navigatorState.pop(false);
                    },
                    child: Text("Kal"),
                  ),
                ],
              );
            },
          );
          if (result == true) {
            cik();
            navigatorState.pop<bool>(result);
          }
        } else {
          cik();
          Navigator.pop(context);
        }
      },
      child: Scaffold(
        appBar: AppBar(
          title: Text(widget.not != null ? "Not Düzenle" : "Not Ekle"),
        ),
        resizeToAvoidBottomInset: false,
        body: SafeArea(
          child: Column(
            children: [
              Expanded(
                child: BiltekTextField(
                  controller: textEditingController,
                  currentFocus: focusNode,
                  errorText: error,
                  onChanged: (v) {
                    setState(() {
                      error = null;
                      girildi = true;
                    });
                  },
                ),
              ),
              SizedBox(
                height: 80,
                width: MediaQuery.of(context).size.width,
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.end,
                  crossAxisAlignment: CrossAxisAlignment.end,
                  children: [
                    DefaultButton(
                      onPressed: () {
                        _kaydet();
                      },
                      background: Islemler.arkaRenk("bg-success", alpha: 1),
                      text: "Kaydet",
                    ),
                    SizedBox(width: 8),
                    DefaultButton(
                      onPressed: () {
                        Navigator.pop(context);
                      },
                      background: Islemler.arkaRenk("bg-danger", alpha: 1),
                      text: "İptal",
                    ),
                    SizedBox(width: 8),
                  ],
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  Future<void> _kaydet() async {
    String aciklama = textEditingController.text;
    if (aciklama.isNotEmpty) {
      setState(() {
        girildi = false;
      });
      NavigatorState navigatorState = Navigator.of(context);
      bool duzenle = false;
      if (widget.not != null) {
        duzenle = await BiltekPost.notDuzenle(
          id: widget.not!.id,
          aciklama: aciklama,
          kullaniciID: widget.kullanici.id,
        );
      } else {
        duzenle = await BiltekPost.notEkle(
          aciklama: aciklama,
          kullaniciID: widget.kullanici.id,
        );
      }
      if (duzenle) {
        widget.notlariYenile?.call();
        navigatorState.pop();
      } else {
        if (mounted) {
          showDialog(
            context: context,
            builder:
                (context) => AlertDialog(
                  title: Text(
                    widget.not != null ? "Not Düzenlenemedi" : "Not Eklenemedi",
                  ),
                  content: Text(
                    "Not ${widget.not != null ? "düzenlenirken" : "eklenirken"} bir hata oluştu. Lütfen daha sonra tekrar deneyin!",
                  ),
                  actions: [
                    TextButton(
                      onPressed: () {
                        Navigator.pop(context);
                      },
                      child: Text("Kapat"),
                    ),
                  ],
                ),
          );
        }
      }
    } else {
      setState(() {
        error = "Lütfen bir not metni girin";
      });
    }
  }

  void cik() {
    widget.notlariYenile?.call();
  }
}
