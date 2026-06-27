import 'dart:async';

import 'package:biltekteknikservis/widgets/input.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutter_keyboard_visibility/flutter_keyboard_visibility.dart';

import '../../models/kullanici.dart';
import '../../models/sifre.dart';
import '../../utils/post.dart';
import '../../utils/types.dart';
import 'sifre_ekle_duzenle.dart';

class SifrelerSayfasi extends StatefulWidget {
  const SifrelerSayfasi({super.key, required this.kullanici});

  final KullaniciAuthModel kullanici;

  @override
  State<SifrelerSayfasi> createState() => _SifrelerSayfasiState();
}

class _SifrelerSayfasiState extends State<SifrelerSayfasi> {
  List<SifreModel>? sifreler;

  FocusNode searchbarFocus = FocusNode();

  String arama = "";
  bool aramaEtkin = false;

  Timer? debounce;

  AramaAppBar? aramaAppBar;

  StreamSubscription<bool>? keyboardSubscription;
  bool klavyeAcik = false;

  @override
  void initState() {
    super.initState();
    Future.delayed(Duration.zero, () async {
      await _sifreleriGetir();
    });
    var keyboardVisibilityController = KeyboardVisibilityController();

    keyboardSubscription = keyboardVisibilityController.onChange.listen((
      bool visible,
    ) {
      setState(() {
        klavyeAcik = visible;
      });
      debugPrint("Klavye Durumu: $visible");
      if (!visible) {
        _aramaDurumuDuzenle(false, klavyeYoluyla: true);
      }
    });
  }

  @override
  void dispose() {
    keyboardSubscription?.cancel();
    debounce?.cancel();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    aramaAppBar = AramaAppBar(
      searchbarFocus: searchbarFocus,
      aramaText: (value) async {
        debounce?.cancel();
        debounce = Timer(const Duration(milliseconds: 400), () async {
          setState(() {
            arama = value;
          });
          await _sifreleriGetir();
        });
      },
      aramaDurumu: (durum) {
        _aramaDurumuDuzenle(durum);
      },
    );
    return PopScope(
      canPop: false,
      onPopInvokedWithResult: (didPop, result) async {
        if (didPop) {
          return;
        }
        NavigatorState navigatorState = Navigator.of(context);
        bool kapat = true;
        if (aramaEtkin || arama.isNotEmpty) {
          _aramaDurumuDuzenle(false);
          kapat = false;
          await _sifreleriGetir();
        }

        if (kapat) {
          //SystemChannels.platform.invokeMethod('SystemNavigator.pop');
          navigatorState.pop(result);
        }
      },
      child: Scaffold(
        appBar:
            aramaEtkin
                ? AppBar(
                  automaticallyImplyLeading: false,
                  flexibleSpace: aramaAppBar,
                )
                : AppBar(
                  title: Text(
                    arama.isNotEmpty
                        ? "\"$arama\" Arama Sonuçları"
                        : "Şifreler",
                  ),
                  actions: [
                    IconButton(
                      icon: Icon(CupertinoIcons.search),
                      onPressed: () {
                        _aramaDurumuDuzenle(true);
                      },
                    ),
                  ],
                ),
        floatingActionButton: FloatingActionButton(
          onPressed: () {
            Navigator.of(context).push(
              MaterialPageRoute(
                builder:
                    (context) => SifreEkleDuzenleSayfasi(
                      kullanici: widget.kullanici,
                      sifreleriYenile: () async {
                        await _sifreleriGetir();
                      },
                    ),
              ),
            );
          },
          child: Icon(Icons.add),
        ),
        resizeToAvoidBottomInset: false,
        body: SafeArea(
          child: SizedBox(
            width: MediaQuery.of(context).size.width,
            height: MediaQuery.of(context).size.height,
            child:
                sifreler != null
                    ? RefreshIndicator(
                      onRefresh: () async {
                        setState(() {
                          arama = "";
                        });
                        await _sifreleriGetir();
                      },
                      child:
                          sifreler!.isEmpty
                              ? ListView.builder(
                                itemCount: 1,
                                itemBuilder: (context, index) {
                                  return SizedBox(
                                    width: MediaQuery.of(context).size.width,
                                    height: MediaQuery.of(context).size.height,
                                    child: Center(
                                      child: Text(
                                        "Henüz bir şifre eklenmemiş.",
                                      ),
                                    ),
                                  );
                                },
                              )
                              : ListView.builder(
                                itemCount: sifreler!.length,
                                itemBuilder: (context, index) {
                                  SifreModel sifre = sifreler![index];
                                  Color? renk =
                                      Theme.of(
                                        context,
                                      ).textTheme.bodyMedium?.color;
                                  TextEditingController
                                  sifreTextEditingController =
                                      TextEditingController(text: sifre.sifre);
                                  return ListTile(
                                    shape: RoundedRectangleBorder(
                                      side: BorderSide(
                                        color: Colors.black,
                                        width: 1,
                                      ),
                                      borderRadius: BorderRadius.circular(5),
                                    ),
                                    title: RichText(
                                      text: TextSpan(
                                        children: <TextSpan>[
                                          TextSpan(
                                            text: "Müşteri İsmi: ",
                                            style: TextStyle(
                                              fontWeight: FontWeight.bold,
                                              color: renk,
                                            ),
                                          ),
                                          TextSpan(
                                            text: sifre.musteriAdi,
                                            style: TextStyle(color: renk),
                                          ),
                                        ],
                                      ),
                                    ),
                                    subtitle: RichText(
                                      text: TextSpan(
                                        children: <InlineSpan>[
                                          TextSpan(
                                            text: "\nAçıklama: ",
                                            style: TextStyle(
                                              fontWeight: FontWeight.bold,
                                              color: renk,
                                            ),
                                          ),
                                          TextSpan(
                                            text: sifre.aciklama,
                                            style: TextStyle(color: renk),
                                          ),
                                          TextSpan(
                                            text: "\nKullanıcı Adı: ",
                                            style: TextStyle(
                                              fontWeight: FontWeight.bold,
                                              color: renk,
                                            ),
                                          ),
                                          TextSpan(
                                            text: sifre.kAdi,
                                            style: TextStyle(color: renk),
                                          ),

                                          WidgetSpan(
                                            alignment:
                                                PlaceholderAlignment.middle,
                                            child: IconButton(
                                              icon: const Icon(
                                                Icons.copy,
                                                color: Colors.green,
                                              ),
                                              onPressed: () async {
                                                await Clipboard.setData(
                                                  ClipboardData(
                                                    text: sifre.kAdi,
                                                  ),
                                                );
                                                if (context.mounted) {
                                                  ScaffoldMessenger.of(
                                                    context,
                                                  ).showSnackBar(
                                                    const SnackBar(
                                                      content: Text(
                                                        'Kopyalandı!',
                                                      ),
                                                    ),
                                                  );
                                                }
                                              },
                                              constraints:
                                                  const BoxConstraints(),
                                              padding: EdgeInsets.zero,
                                            ),
                                          ),
                                          TextSpan(
                                            text: "\nŞifre: ",
                                            style: TextStyle(
                                              fontWeight: FontWeight.bold,
                                              color: renk,
                                            ),
                                          ),
                                          WidgetSpan(
                                            alignment:
                                                PlaceholderAlignment
                                                    .middle, // Vertically centers the button with text
                                            child: BiltekSifre(
                                              controller:
                                                  sifreTextEditingController,
                                              readOnly: true,
                                              canCopy: true,
                                            ),
                                          ),
                                          TextSpan(
                                            text: "\nOluşturan: ",
                                            style: TextStyle(
                                              fontWeight: FontWeight.bold,
                                              color: renk,
                                            ),
                                          ),
                                          TextSpan(
                                            text: sifre.olusturan,
                                            style: TextStyle(color: renk),
                                          ),
                                          TextSpan(
                                            text: "\nDüzenleyen: ",
                                            style: TextStyle(
                                              fontWeight: FontWeight.bold,
                                              color: renk,
                                            ),
                                          ),
                                          TextSpan(
                                            text:
                                                sifre.sonDuzenleme ==
                                                        sifre.tarih
                                                    ? "-"
                                                    : sifre.duzenleyen,
                                            style: TextStyle(color: renk),
                                          ),
                                        ],
                                      ),
                                    ),
                                    trailing: Row(
                                      mainAxisSize: MainAxisSize.min,
                                      mainAxisAlignment: MainAxisAlignment.end,
                                      children: [
                                        IconButton(
                                          onPressed: () {
                                            Navigator.push(
                                              context,
                                              MaterialPageRoute(
                                                builder:
                                                    (
                                                      context,
                                                    ) => SifreEkleDuzenleSayfasi(
                                                      kullanici:
                                                          widget.kullanici,
                                                      sifre: sifre,
                                                      sifreleriYenile: () async {
                                                        await _sifreleriGetir();
                                                      },
                                                    ),
                                              ),
                                            );
                                          },
                                          icon: Icon(CupertinoIcons.pen),
                                        ),
                                        IconButton(
                                          onPressed: () {
                                            _sifreSil(sifre.id);
                                          },
                                          icon: Icon(CupertinoIcons.delete),
                                        ),
                                      ],
                                    ),
                                  );
                                },
                              ),
                    )
                    : Center(child: CircularProgressIndicator()),
          ),
        ),
      ),
    );
  }

  Future<void> _sifreleriGetir() async {
    setState(() {
      sifreler = null;
    });
    List<SifreModel> sifrelerTemp = await BiltekPost.of(
      widget.kullanici.auth,
    ).sifreleriGetir(arama: arama.isNotEmpty ? arama : null);

    setState(() {
      sifreler = sifrelerTemp;
    });
  }

  void _sifreSil(int id) {
    showDialog(
      context: context,
      builder: (context) {
        return AlertDialog(
          title: Text("Şifre Sil"),
          content: Text("Bu şifreyi silmek istediğinize emin misiniz?"),
          actions: [
            TextButton(
              onPressed: () async {
                NavigatorState navigatorState = Navigator.of(context);
                navigatorState.pop();
                bool sil = await BiltekPost.of(
                  widget.kullanici.auth,
                ).sifreSil(id: id);
                if (sil) {
                  await _sifreleriGetir();
                } else {
                  if (context.mounted) {
                    showDialog(
                      context: context,
                      builder:
                          (context) => AlertDialog(
                            title: Text("Şifre silinemedi."),
                            content: Text(
                              "Şifre silinirken bir hata oluştu. Lütfen daha sonra tekrar deneyin.",
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
              },
              child: Text("Evet"),
            ),
            TextButton(
              onPressed: () {
                Navigator.pop(context);
              },
              child: Text("Hayır"),
            ),
          ],
        );
      },
    );
  }

  void _aramaDurumuDuzenle(bool durum, {bool klavyeYoluyla = false}) async {
    setState(() {
      aramaEtkin = durum;
    });
    if (durum) {
      Future.delayed(Duration(milliseconds: 100), () {
        if (mounted) {
          FocusScopeNode focusScopeNode = FocusScope.of(context);
          if (focusScopeNode.hasFocus) {
            SystemChannels.textInput.invokeMethod("TextInput.show");
          }
          focusScopeNode.requestFocus(aramaAppBar?.searchbarFocus);
        }
      });
    } else {
      if (klavyeYoluyla) {
      } else {
        setState(() {
          arama = "";
        });
        await _sifreleriGetir();
      }
    }
  }
}
