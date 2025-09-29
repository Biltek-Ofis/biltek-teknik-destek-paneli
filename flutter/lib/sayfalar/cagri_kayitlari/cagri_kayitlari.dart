import 'package:biltekteknikservis/models/cagri_kaydi.dart';
import 'package:biltekteknikservis/models/kullanici.dart';
import 'package:flutter/material.dart';

import '../../models/cihaz.dart';
import '../../utils/buttons.dart';
import '../../utils/islemler.dart';
import '../../utils/post.dart';
import '../../utils/shared_preferences.dart';
import '../ayarlar/ayarlar.dart';
import '../cihazlar.dart';
import '../giris_sayfasi.dart';

class CagriKayitlariSayfasi extends StatefulWidget {
  const CagriKayitlariSayfasi({super.key, required this.kullanici});

  final KullaniciAuthModel kullanici;
  @override
  State<CagriKayitlariSayfasi> createState() => _CagriKayitlariSayfasiState();
}

class _CagriKayitlariSayfasiState extends State<CagriKayitlariSayfasi> {
  List<CagriKaydiModel>? cagriKayitlari;
  ScrollController scrollController = ScrollController();

  @override
  void initState() {
    Future.delayed(Duration.zero, () async {
      await cagriKayitlariniGetir();
    });
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title:
            widget.kullanici.musteri
                ? Text("Biltek Çağrı Kayıtları")
                : Text("Çağrı Kayıtları"),

        actions: [
          PopupMenuButton(
            itemBuilder:
                (context) => [
                  PopupMenuItem(
                    onTap: () {
                      Navigator.of(context).push(
                        MaterialPageRoute(
                          builder:
                              (context) => AyarlarSayfasi(
                                pcYenile: () {},
                                kullanici: widget.kullanici,
                              ),
                        ),
                      );
                    },
                    child: Row(
                      children: [
                        Icon(
                          Icons.settings,
                          color: Theme.of(context).textTheme.bodySmall?.color,
                        ),
                        SizedBox(width: 10),
                        const Text("Ayarlar"),
                      ],
                    ),
                  ),
                  PopupMenuItem(
                    onTap: () async {
                      NavigatorState navigatorState = Navigator.of(context);
                      await SharedPreference.remove(
                        SharedPreference.authString,
                      );
                      String? fcmToken = await SharedPreference.getString(
                        SharedPreference.fcmTokenString,
                      );
                      await BiltekPost.fcmTokenSifirla(fcmToken: fcmToken);
                      navigatorState.pushAndRemoveUntil(
                        MaterialPageRoute(
                          builder:
                              (context) => GirisSayfasi(
                                kullaniciAdi: widget.kullanici.kullaniciAdi,
                              ),
                        ),
                        (route) => false,
                      );
                    },
                    child: Row(
                      children: [
                        Icon(
                          Icons.logout,
                          color: Theme.of(context).textTheme.bodySmall?.color,
                        ),
                        SizedBox(width: 10),
                        const Text("Çıkış Yap"),
                      ],
                    ),
                  ),
                ],
          ),
        ],
      ),
      drawer: biltekDrawer(
        context,
        kullanici: widget.kullanici,
        seciliSayfa: "Çağrı Kayıtları",
      ),
      /*floatingActionButton: FloatingActionButton(
        onPressed: () {},
        child: Icon(Icons.add),
      ),*/
      body:
          cagriKayitlari == null
              ? Center(child: CircularProgressIndicator())
              : RefreshIndicator(
                onRefresh: () async {
                  await cagriKayitlariniGetir();
                },
                child: ListView.builder(
                  itemCount: cagriKayitlari!.length,
                  controller: scrollController,
                  physics: AlwaysScrollableScrollPhysics(),
                  itemBuilder: (context, index) {
                    CagriKaydiModel cagrikaydi = cagriKayitlari![index];
                    Cihaz? cihaz = cagrikaydi.cihazBilgileri;
                    String renk =
                        cihaz != null ? cihaz.guncelDurumRenk : "bg-warning";
                    Color? renkTemp = Islemler.yaziRengi(renk);
                    return Container(
                      decoration: BoxDecoration(
                        color: Islemler.arkaRenk(renk),
                        border: Border.all(color: Colors.black, width: 1),
                      ),
                      child: ListTile(
                        textColor: renkTemp,
                        title: RichText(
                          text: TextSpan(
                            children: <TextSpan>[
                              TextSpan(
                                text: "Çağrı Kodu: ",
                                style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  color: renkTemp,
                                ),
                              ),
                              TextSpan(
                                text: cagrikaydi.id,
                                style: TextStyle(color: renkTemp),
                              ),
                              if (!widget.kullanici.musteri)
                                TextSpan(
                                  text: "\nMüşteri: ",
                                  style: TextStyle(
                                    fontWeight: FontWeight.bold,
                                    color: renkTemp,
                                  ),
                                ),
                              if (!widget.kullanici.musteri)
                                TextSpan(
                                  text:
                                      "${cagrikaydi.bolge} ${cagrikaydi.birim}",
                                  style: TextStyle(color: renkTemp),
                                ),
                              if (cihaz != null)
                                TextSpan(
                                  text: "\nServis No: ",
                                  style: TextStyle(
                                    fontWeight: FontWeight.bold,
                                    color: renkTemp,
                                  ),
                                ),
                              if (cihaz != null)
                                TextSpan(
                                  text: cihaz.servisNo.toString(),
                                  style: TextStyle(color: renkTemp),
                                ),
                              TextSpan(
                                text: "\nCihaz Türü: ",
                                style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  color: renkTemp,
                                ),
                              ),
                              TextSpan(
                                text:
                                    cihaz != null
                                        ? cihaz.cihazTuru
                                        : cagrikaydi.cihazTuru,
                                style: TextStyle(color: renkTemp),
                              ),
                              TextSpan(
                                text: "\nCihaz Marka - Model: ",
                                style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  color: renkTemp,
                                ),
                              ),
                              TextSpan(
                                text:
                                    cihaz != null
                                        ? "${cihaz.cihaz}${cihaz.cihazModeli.isNotEmpty ? " ${cihaz.cihazModeli}" : ""}"
                                        : "${cagrikaydi.cihaz}${cagrikaydi.cihazModeli.isNotEmpty ? " ${cagrikaydi.cihazModeli}" : ""}",
                                style: TextStyle(color: renkTemp),
                              ),
                              TextSpan(
                                text: "\nKayıt Tarihi: ",
                                style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  color: renkTemp,
                                ),
                              ),
                              TextSpan(
                                text: cagrikaydi.tarih,
                                style: TextStyle(color: renkTemp),
                              ),
                            ],
                          ),
                        ),
                        subtitle: Text(
                          cihaz != null
                              ? cihaz.guncelDurumText.toString()
                              : "İşlem Bekleniyor",
                        ),
                        /*trailing: DefaultButton(
                          onPressed: () {},
                          text: "Detaylar",
                        ),*/
                      ),
                    );
                  },
                ),
              ),
    );
  }

  Future<void> cagriKayitlariniGetir() async {
    List<CagriKaydiModel> cagriKayitlariTemp = await BiltekPost.cagriKayitlari(
      kullaniciID: widget.kullanici.musteri ? widget.kullanici.id : 0,
    );
    setState(() {
      cagriKayitlari = cagriKayitlariTemp;
    });
  }
}
