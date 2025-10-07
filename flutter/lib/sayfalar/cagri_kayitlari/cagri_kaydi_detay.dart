import 'package:biltekteknikservis/models/ayarlar.dart';
import 'package:biltekteknikservis/models/cagri_kaydi.dart';
import 'package:biltekteknikservis/models/kullanici.dart';
import 'package:biltekteknikservis/utils/buttons.dart';
import 'package:biltekteknikservis/utils/post.dart';
import 'package:flutter/gestures.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:overlay_support/overlay_support.dart';
import 'package:url_launcher/url_launcher_string.dart';

import '../../utils/islemler.dart';

class CagriKaydiDetaySayfasi extends StatefulWidget {
  const CagriKaydiDetaySayfasi({
    super.key,
    required this.kullanici,
    required this.id,
  });

  final KullaniciAuthModel kullanici;
  final String id;

  @override
  State<CagriKaydiDetaySayfasi> createState() => _CagriKaydiDetaySayfasiState();
}

class _CagriKaydiDetaySayfasiState extends State<CagriKaydiDetaySayfasi> {
  CagriKaydiModel? cagri;
  AyarlarModel? ayarlarModel;
  @override
  void initState() {
    Future.delayed(Duration.zero, () async {
      AyarlarModel? ayarlarModelTemp = await BiltekPost.ayarlar();
      setState(() {
        ayarlarModel = ayarlarModelTemp;
      });
      await cagriKaydiGetir();
    });
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    Color? yaziRengi = Theme.of(context).textTheme.bodySmall?.color;
    return Scaffold(
      appBar: AppBar(title: Text("Çağrı Kodu: ${widget.id}")),
      body: SizedBox(
        width: MediaQuery.of(context).size.width,
        height: MediaQuery.of(context).size.height,
        child:
            cagri != null
                ? RefreshIndicator(
                  onRefresh: () async {
                    await cagriKaydiGetir();
                  },
                  child: SingleChildScrollView(
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.start,
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        RichText(
                          text: TextSpan(
                            children: <TextSpan>[
                              TextSpan(
                                text: "Çağrı Kodu: ",
                                style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  color: yaziRengi,
                                ),
                              ),
                              TextSpan(
                                text: cagri!.id,
                                style: TextStyle(color: yaziRengi),
                              ),
                              if (!widget.kullanici.musteri)
                                TextSpan(
                                  text: "\nMüşteri: ",
                                  style: TextStyle(
                                    fontWeight: FontWeight.bold,
                                    color: yaziRengi,
                                  ),
                                ),
                              if (!widget.kullanici.musteri)
                                TextSpan(
                                  text: "${cagri!.bolge} ${cagri!.birim}",
                                  style: TextStyle(color: yaziRengi),
                                ),
                              if (cagri!.cihazBilgileri != null)
                                TextSpan(
                                  text: "\nServis No: ",
                                  style: TextStyle(
                                    fontWeight: FontWeight.bold,
                                    color: yaziRengi,
                                  ),
                                ),
                              if (cagri!.cihazBilgileri != null)
                                TextSpan(
                                  text:
                                      cagri!.cihazBilgileri!.servisNo
                                          .toString(),
                                  style: TextStyle(color: yaziRengi),
                                ),
                              TextSpan(
                                text: "\nCihaz Türü: ",
                                style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  color: yaziRengi,
                                ),
                              ),
                              TextSpan(
                                text:
                                    cagri!.cihazBilgileri != null
                                        ? cagri!.cihazBilgileri!.cihazTuru
                                        : cagri!.cihazTuru,
                                style: TextStyle(color: yaziRengi),
                              ),
                              TextSpan(
                                text: "\nCihaz Marka - Model: ",
                                style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  color: yaziRengi,
                                ),
                              ),
                              TextSpan(
                                text:
                                    cagri!.cihazBilgileri != null
                                        ? "${cagri!.cihazBilgileri!.cihaz}${cagri!.cihazBilgileri!.cihazModeli.isNotEmpty ? " ${cagri!.cihazBilgileri!.cihazModeli}" : ""}"
                                        : "${cagri!.cihaz}${cagri!.cihazModeli.isNotEmpty ? " ${cagri!.cihazModeli}" : ""}",
                                style: TextStyle(color: yaziRengi),
                              ),
                              TextSpan(
                                text: "\nKayıt Tarihi: ",
                                style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  color: yaziRengi,
                                ),
                              ),
                              TextSpan(
                                text: Islemler.tarihGoruntule(
                                  cagri!.tarih,
                                  Islemler.tarihSQLFormat,
                                  Islemler.tarihFormat,
                                ),
                                style: TextStyle(color: yaziRengi),
                              ),

                              TextSpan(
                                text: "\nDurum: ",
                                style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  color: yaziRengi,
                                ),
                              ),
                              if (cagri!.cihazBilgileri != null)
                                TextSpan(
                                  text:
                                      cagri!.cihazBilgileri!.guncelDurumText
                                          .toString(),
                                  style: TextStyle(color: yaziRengi),
                                ),
                              TextSpan(
                                text: "\nYapılan İşlem Açıklaması: ",
                                style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  color: yaziRengi,
                                ),
                              ),
                              if (cagri!.cihazBilgileri != null)
                                TextSpan(
                                  text:
                                      cagri!
                                          .cihazBilgileri!
                                          .yapilanIslemAciklamasi
                                          .toString(),
                                  style: TextStyle(color: yaziRengi),
                                ),
                            ],
                          ),
                        ),
                        if (cagri!.cihazBilgileri == null)
                          Container(
                            decoration: BoxDecoration(color: Colors.white),
                            child: Container(
                              decoration: BoxDecoration(
                                color: Islemler.arkaRenk("bg-warning"),
                              ),
                              child: Text(
                                "Çağrı kaydınızın yetkili tarafından işleme alınması bekleniyor.",
                                style: TextStyle(color: Colors.black),
                              ),
                            ),
                          ),
                        if (cagri!.cihazBilgileri != null &&
                            cagri!.cihazBilgileri!.islemler.isNotEmpty)
                          Islemler.liste(cagri!.cihazBilgileri!.islemler),
                        if (cagri!.cihazBilgileri != null &&
                            cagri!.cihazBilgileri!.guncelDurumText ==
                                "Fiyat Onayı Bekleniyor")
                          Row(
                            mainAxisAlignment: MainAxisAlignment.spaceBetween,
                            children: [
                              DefaultButton(
                                onPressed: () async {
                                  setState(() {
                                    cagri = null;
                                  });
                                  await BiltekPost.fiyatiOnayla(id: widget.id);
                                  await cagriKaydiGetir();
                                },
                                background: Islemler.arkaRenk(
                                  "bg-success",
                                  alpha: 1,
                                ),
                                text: "Fiyatı Onayla",
                              ),
                              DefaultButton(
                                onPressed: () async {
                                  setState(() {
                                    cagri = null;
                                  });
                                  await BiltekPost.fiyatiReddet(id: widget.id);
                                  await cagriKaydiGetir();
                                },
                                background: Islemler.arkaRenk(
                                  "bg-danger",
                                  alpha: 1,
                                ),
                                text: "Fiyatı Reddet",
                              ),
                            ],
                          ),
                        if (ayarlarModel != null &&
                            ayarlarModel!.sirketTelefonu.isNotEmpty)
                          SizedBox(height: 10),
                        if (ayarlarModel != null &&
                            ayarlarModel!.sirketTelefonu.isNotEmpty)
                          Container(
                            width: MediaQuery.of(context).size.width,
                            decoration: BoxDecoration(color: Colors.white),
                            child: Container(
                              padding: EdgeInsets.all(5),
                              alignment: Alignment.center,
                              decoration: BoxDecoration(
                                color: Islemler.arkaRenk("bg-success"),
                              ),
                              child: RichText(
                                text: TextSpan(
                                  children: <TextSpan>[
                                    TextSpan(
                                      text:
                                          "Çağrı kaydınız hakkında bilgi almak (istek, fiyat onayı, iade talebi vb) için ",
                                      style: TextStyle(color: Colors.black),
                                    ),
                                    TextSpan(
                                      text: ayarlarModel!.sirketTelefonu,
                                      style: TextStyle(
                                        fontWeight: FontWeight.bold,
                                        color: Colors.black,
                                        decoration: TextDecoration.underline,
                                      ),
                                      recognizer:
                                          TapGestureRecognizer()
                                            ..onTap = () {
                                              String telefon = Islemler.telNo(
                                                ayarlarModel!.sirketTelefonu,
                                              );
                                              showDialog(
                                                context: context,
                                                builder: (context) {
                                                  return AlertDialog(
                                                    title: Text(
                                                      ayarlarModel!
                                                          .sirketTelefonu,
                                                    ),
                                                    actions: [
                                                      TextButton(
                                                        onPressed: () async {
                                                          NavigatorState
                                                          navigatorState =
                                                              Navigator.of(
                                                                context,
                                                              );
                                                          await Clipboard.setData(
                                                            ClipboardData(
                                                              text:
                                                                  ayarlarModel!
                                                                      .sirketTelefonu,
                                                            ),
                                                          );
                                                          navigatorState.pop();
                                                          toast(
                                                            "Telefon numarası panoya kopyalandı",
                                                          );
                                                        },
                                                        child: Text("Kopyala"),
                                                      ),
                                                      TextButton(
                                                        onPressed: () {
                                                          launchUrlString(
                                                            "tel://$telefon",
                                                          );
                                                          Navigator.of(
                                                            context,
                                                          ).pop();
                                                        },
                                                        child: Text("Ara"),
                                                      ),
                                                    ],
                                                  );
                                                },
                                              );
                                            },
                                    ),
                                    TextSpan(
                                      text:
                                          " numarasından bize ulaşabilirsiniz.",
                                      style: TextStyle(color: Colors.black),
                                    ),
                                  ],
                                ),
                              ),
                            ),
                          ),
                      ],
                    ),
                  ),
                )
                : Center(child: CircularProgressIndicator()),
      ),
    );
  }

  Future<void> cagriKaydiGetir() async {
    CagriKaydiModel? cagriKaydiModel = await BiltekPost.cagriKaydi(
      id: widget.id,
    );

    setState(() {
      cagri = cagriKaydiModel;
    });
  }
}
