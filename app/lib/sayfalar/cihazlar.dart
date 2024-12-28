import 'dart:async';

import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/material.dart';
import 'package:simple_barcode_scanner/simple_barcode_scanner.dart';
import 'package:universal_io/io.dart';

import '../models/cihaz.dart';
import '../models/kullanici.dart';
import '../utils/buttons.dart';
import '../utils/post.dart';
import '../utils/islemler.dart';
import '../widgets/scaffold.dart';
import 'detaylar.dart';

class CihazlarSayfasi extends StatefulWidget {
  const CihazlarSayfasi({
    super.key,
    required this.kullanici,
    required this.seciliSayfa,
    this.sorumlu,
  });
  final KullaniciModel kullanici;
  final String seciliSayfa;
  final int? sorumlu;

  @override
  State<CihazlarSayfasi> createState() => _CihazlarSayfasiState();
}

class _CihazlarSayfasiState extends State<CihazlarSayfasi> {
  FocusNode searchbarFocus = FocusNode();

  String arama = "";

  List<Cihaz>? cihazlar;

  ScrollController scrollController = ScrollController();
  int suankiIndex = 0;

  bool aramaEtkin = false;

  bool yukariKaydir = false;

  StreamSubscription<String>? fcmStream;

  @override
  void initState() {
    Future.delayed(Duration.zero, () async {
      if (Platform.isAndroid) {
        await FirebaseMessaging.instance.requestPermission(provisional: true);
        fcmStream =
            FirebaseMessaging.instance.onTokenRefresh.listen((fcmToken) async {
          BiltekPost.fcmTokenGuncelle(widget.kullanici.auth, fcmToken);
        });
        fcmStream?.onError((err) {
          debugPrint("Failed to get fcm token");
        });
        String? token = await FirebaseMessaging.instance.getToken();

        BiltekPost.fcmTokenGuncelle(widget.kullanici.auth, token);
      }
    });
    scrollController.addListener(() async {
      if (scrollController.position.pixels > 50) {
        setState(() {
          yukariKaydir = true;
        });
      } else {
        setState(() {
          yukariKaydir = false;
        });
      }
      if (scrollController.position.pixels ==
          scrollController.position.maxScrollExtent) {
        debugPrint("Max scroll");
        setState(() {
          suankiIndex += 1;
        });
        await _cihazlariYenile(
          sifirla: false,
        );
      }
    });
    Future.delayed(Duration.zero, () async {
      await _cihazlariYenile();
    });
    super.initState();
  }

  @override
  void dispose() {
    scrollController.dispose();
    fcmStream?.cancel();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      drawer: aramaEtkin
          ? null
          : biltekDrawer(
              context,
              kullanici: widget.kullanici,
              seciliSayfa: widget.seciliSayfa,
            ),
      appBar: aramaEtkin
          ? AppBar(
              flexibleSpace: Builder(
                builder: (context) {
                  WidgetStateProperty<Color?>? color =
                      WidgetStateProperty.resolveWith<Color?>(
                    (Set<WidgetState> states) {
                      return Colors.transparent; // Use the component's default.
                    },
                  );

                  FocusScope.of(context).requestFocus(searchbarFocus);
                  return SearchBar(
                    focusNode: searchbarFocus,
                    padding: const WidgetStatePropertyAll<EdgeInsets>(
                        EdgeInsets.symmetric(horizontal: 16.0)),
                    backgroundColor: color,
                    shadowColor: color,
                    overlayColor: color,
                    surfaceTintColor: color,
                    hintText: "Cihaz Ara...",
                    hintStyle: WidgetStateProperty.resolveWith<TextStyle?>(
                      (Set<WidgetState> states) {
                        return TextStyle(
                            color: Theme.of(context)
                                .textTheme
                                .bodySmall
                                ?.color
                                ?.withAlpha(100));
                      },
                    ),
                    onTap: () {
                      ////controller.openView();
                    },
                    onChanged: (value) async {
                      setState(() {
                        arama = value;
                      });
                      await _cihazlariYenile();
                    },
                    leading: IconButton(
                      onPressed: () {
                        setState(() {
                          aramaEtkin = false;
                        });
                      },
                      icon: Icon(Icons.arrow_back),
                    ),
                    trailing: <Widget>[],
                  );
                },
              ),
            )
          : biltekAppBar(
              context,
              actions: [
                IconButton(
                  onPressed: () {
                    setState(() {
                      aramaEtkin = true;
                    });
                  },
                  icon: Icon(Icons.search),
                ),
                IconButton(
                  onPressed: () async {
                    NavigatorState navigatorState = Navigator.of(context);
                    String? res = await SimpleBarcodeScanner.scanBarcode(
                      context,
                      barcodeAppBar: const BarcodeAppBar(
                        appBarTitle: 'Barkod Tara',
                        centerTitle: false,
                        enableBackButton: true,
                        backButtonIcon: Icon(Icons.arrow_back_ios),
                      ),
                      cancelButtonText: "İptal",
                      isShowFlashIcon: true,
                      delayMillis: 2000,
                      cameraFace: CameraFace.back,
                    );
                    if (res != null) {
                      int servisNo = int.parse(res);
                      await BiltekPost.bilgisayardaAc(
                        kullaniciID: widget.kullanici.id,
                        servisNo: servisNo,
                      );
                      navigatorState.push(
                        MaterialPageRoute(
                          builder: (context) => DetaylarSayfasi(
                            kullanici: widget.kullanici,
                            servisNo: servisNo,
                          ),
                        ),
                      );
                    }
                  },
                  icon: Icon(Icons.photo_camera),
                ),
              ],
            ),
      floatingActionButton: yukariKaydir
          ? FloatingActionButton(
              onPressed: () {
                scrollController.animateTo(
                  0,
                  duration: Duration(seconds: 1),
                  curve: Curves.bounceIn,
                );
              },
              child: Icon(
                Icons.arrow_upward,
                color: Colors.white,
              ),
            )
          : null,
      body: Container(
        decoration: BoxDecoration(
          color: Colors.white,
        ),
        width: MediaQuery.of(context).size.width,
        child: cihazlar == null
            ? Center(
                child: CircularProgressIndicator(),
              )
            : RefreshIndicator(
                onRefresh: () async {
                  setState(() {
                    arama = "";
                  });
                  await _cihazlariYenile();
                },
                child: ListView.builder(
                  itemCount: cihazlar!.length,
                  controller: scrollController,
                  physics: AlwaysScrollableScrollPhysics(),
                  itemBuilder: (context, index) {
                    Cihaz cihaz = cihazlar![index];
                    Color? renkTemp = Islemler.yaziRengi(cihaz.guncelDurumRenk);
                    return Container(
                      decoration: BoxDecoration(
                        color: Islemler.arkaRenk(cihaz.guncelDurumRenk),
                        border: Border.all(color: Colors.black, width: 1),
                      ),
                      child: ListTile(
                        textColor: renkTemp,
                        title: RichText(
                          text: TextSpan(
                            children: <TextSpan>[
                              TextSpan(
                                text: "\nServis No: ",
                                style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  color: renkTemp,
                                ),
                              ),
                              TextSpan(
                                text: cihaz.servisNo.toString(),
                                style: TextStyle(
                                  color: renkTemp,
                                ),
                              ),
                              TextSpan(
                                text: "\nMüşteri Adı: ",
                                style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  color: renkTemp,
                                ),
                              ),
                              TextSpan(
                                text: cihaz.musteriAdi,
                                style: TextStyle(
                                  color: renkTemp,
                                ),
                              ),
                              TextSpan(
                                text: "\nCihaz Tür: ",
                                style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  color: renkTemp,
                                ),
                              ),
                              TextSpan(
                                text: cihaz.cihazTuru,
                                style: TextStyle(
                                  color: renkTemp,
                                ),
                              ),
                              if (widget.sorumlu == null)
                                TextSpan(
                                  text: "\nSorumlu: ",
                                  style: TextStyle(
                                    fontWeight: FontWeight.bold,
                                    color: renkTemp,
                                  ),
                                ),
                              if (widget.sorumlu == null)
                                TextSpan(
                                  text: cihaz.sorumlu,
                                  style: TextStyle(
                                    color: renkTemp,
                                  ),
                                ),
                              TextSpan(
                                text: "\nCihaz: ",
                                style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  color: renkTemp,
                                ),
                              ),
                              TextSpan(
                                text:
                                    "${cihaz.cihaz}${(cihaz.cihazModeli.isNotEmpty ? " ${cihaz.cihazModeli}" : "")}",
                                style: TextStyle(
                                  color: renkTemp,
                                ),
                              ),
                              TextSpan(
                                text: "\nGiriş Tarihi: ",
                                style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  color: renkTemp,
                                ),
                              ),
                              TextSpan(
                                text: cihaz.tarih,
                                style: TextStyle(
                                  color: renkTemp,
                                ),
                              ),
                            ],
                          ),
                        ),
                        subtitle: Text(cihaz.guncelDurumText.toString()),
                        trailing: DefaultButton(
                          onPressed: () {
                            Navigator.of(context).push(MaterialPageRoute(
                              builder: (context) => DetaylarSayfasi(
                                kullanici: widget.kullanici,
                                servisNo: cihaz.servisNo,
                              ),
                            ));
                          },
                          text: "Detaylar",
                        ),
                      ),
                    );
                  },
                ),
              ),
      ),
    );
  }

  Future<void> _cihazlariYenile({
    bool sifirla = true,
  }) async {
    if (sifirla) {
      setState(() {
        suankiIndex = 0;
      });
    }
    List<Cihaz> cihazlarTemp = await BiltekPost.cihazlariGetir(
      sorumlu: widget.sorumlu,
      arama: arama.isNotEmpty ? arama : null,
      offset: suankiIndex * 50,
    );
    if (mounted) {
      setState(() {
        if (sifirla) {
          cihazlar = cihazlarTemp;
        } else {
          cihazlar ??= [];
          cihazlar?.addAll(cihazlarTemp);
        }
      });
    } else {
      if (sifirla) {
        cihazlar = cihazlarTemp;
      } else {
        cihazlar ??= [];
        cihazlar?.addAll(cihazlarTemp);
      }
    }
  }
}
