import 'package:flutter/material.dart';
import 'package:intl/intl.dart';

import '../models/cihaz_duzenleme/cihaz_duzenleme.dart';
import '../utils/alerts.dart';
import '../utils/buttons.dart';
import '../utils/desen.dart';
import '../utils/islemler.dart';
import '../utils/post.dart';
import '../widgets/input.dart';
import '../widgets/takvim/dialog.dart';

class YeniCihazSayfasi extends StatefulWidget {
  const YeniCihazSayfasi({
    super.key,
    required this.cihazlariYenile,
  });

  final VoidCallback cihazlariYenile;

  @override
  State<YeniCihazSayfasi> createState() => _YeniCihazSayfasiState();
}

class _YeniCihazSayfasiState extends State<YeniCihazSayfasi> {
  bool girildi = false;

  String tarihGirisi = "oto";

  TextEditingController tarihController = TextEditingController();

  TextEditingController musteriAdiController = TextEditingController();
  FocusNode musteriAdiFocus = FocusNode();
  String? musteriAdiHata;

  bool musteriyiKaydet = true;

  TextEditingController teslimEdenController = TextEditingController();
  FocusNode teslimEdenFocus = FocusNode();

  TextEditingController adresController = TextEditingController();
  FocusNode adresFocus = FocusNode();

  TextEditingController gsmController = TextEditingController();

  FocusNode gsmFocus = FocusNode();

  int? cihazTuru;
  String? cihazTuruHata;

  int? sorumlu;
  String? sorumluHata;

  TextEditingController cihazController = TextEditingController();
  FocusNode cihazFocus = FocusNode();
  String? cihazHata;

  TextEditingController cihazModeliController = TextEditingController();
  FocusNode cihazModeliFocus = FocusNode();

  TextEditingController seriNoController = TextEditingController();
  FocusNode seriNoFocus = FocusNode();

  String? sifreTuru;
  String? sifreTuruHata;

  TextEditingController sifreTuruPinController = TextEditingController();
  String? sifreTuruPinHata;

  GlobalKey<DesenState> desenKey = GlobalKey();
  String gecerliDesen = "";
  List<int> gecerliDesenList = [];
  List<int> gecerliDesenListTemp = [];
  String desenHataMesaji = "Lütfen geçerli bir desen seçin";

  TextEditingController arizaAciklamasiController = TextEditingController();
  FocusNode arizaAciklamasiFocus = FocusNode();
  String? arizaAciklamasiHata;

  TextEditingController teslimAlinanlarController = TextEditingController();
  FocusNode teslimAlinanlarFocus = FocusNode();

  TextEditingController hasarTespitiController = TextEditingController();
  FocusNode hasarTespitiFocus = FocusNode();

  int cihazdakiHasar = 0;
  int servisTuru = 0;
  int yedekDurumu = 0;

  bool sayfaYukleniyor = true;

  CihazDuzenlemeModel cihazDuzenleme = CihazDuzenlemeModel.bos();

  @override
  void initState() {
    super.initState();

    tarihGuncelle(DateTime.now().toLocal());
    gsmController.text = "+90";
    Future.delayed(Duration.zero, () async {
      if (mounted) {
        FocusScope.of(context).requestFocus(musteriAdiFocus);
      }
      await _cihazDuzenlemeGetir();
      setState(() {
        sayfaYukleniyor = false;
        girildi = false;
      });
    });
  }

  @override
  void dispose() {
    tarihController.dispose();
    musteriAdiController.dispose();
    musteriAdiFocus.dispose();
    teslimEdenController.dispose();
    teslimEdenFocus.dispose();
    adresController.dispose();
    adresFocus.dispose();
    gsmController.dispose();
    gsmFocus.dispose();
    cihazController.dispose();
    cihazFocus.dispose();
    cihazModeliController.dispose();
    cihazModeliFocus.dispose();
    seriNoController.dispose();
    seriNoFocus.dispose();
    sifreTuruPinController.dispose();
    arizaAciklamasiController.dispose();
    arizaAciklamasiFocus.dispose();
    teslimAlinanlarController.dispose();
    teslimAlinanlarFocus.dispose();
    hasarTespitiController.dispose();
    hasarTespitiFocus.dispose();
    super.dispose();
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
                    "Kaydedilmeyen değişiklikleriniz var. Çıkmak istediğinize emin misiniz?"),
                actions: [
                  TextButton(
                    onPressed: () {
                      navigatorState.pop(true);
                    },
                    child: Text(
                      "İptal Et ve Çık",
                      style: TextStyle(
                        color: Colors.red,
                      ),
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
          title: Text("Yeni Cihaz Girişi"),
        ),
        body: SizedBox(
          width: MediaQuery.of(context).size.width,
          height: MediaQuery.of(context).size.height,
          child: sayfaYukleniyor
              ? Center(
                  child: CircularProgressIndicator(),
                )
              : Column(
                  children: [
                    Expanded(
                      child: SingleChildScrollView(
                        child: Column(
                          children: [
                            Text("Gerekli alanlar * ile belirtilmiştir."),
                            BiltekSelect(
                              title: "Giriş Tarihi",
                              value: tarihGirisi,
                              items: [
                                DropdownMenuItem(
                                  value: "oto",
                                  child: Text("Otomatik (Güncel Tarih)"),
                                ),
                                DropdownMenuItem(
                                  value: "el",
                                  child: Text("El ile Giriş"),
                                ),
                              ],
                              onChanged: (value) {
                                setState(() {
                                  tarihGirisi = value!;
                                  girildi = true;
                                });
                              },
                            ),
                            if (tarihGirisi == "el")
                              TextField(
                                controller: tarihController,
                                decoration: InputDecoration(
                                  labelText: "Tarih",
                                ),
                                readOnly: true,
                                onTap: () {
                                  showTakvim(
                                    context,
                                    initialDate:
                                        DateFormat(Islemler.tarihFormat)
                                            .parse(tarihController.text),
                                    onConfirm: (date) {
                                      tarihGuncelle(date!);
                                    },
                                  );
                                },
                                onChanged: (value) {
                                  setState(() {
                                    girildi = true;
                                  });
                                },
                              ),
                            BiltekTextField(
                              controller: musteriAdiController,
                              currentFocus: musteriAdiFocus,
                              nextFocus: teslimEdenFocus,
                              label: "Müşteri Adı *",
                              errorText: musteriAdiHata,
                              onChanged: (value) {
                                setState(() {
                                  girildi = true;
                                  musteriAdiHata = null;
                                });
                              },
                            ),
                            BiltekTextField(
                              controller: teslimEdenController,
                              currentFocus: teslimEdenFocus,
                              nextFocus: adresFocus,
                              label: "Teslim Eden Kişi",
                              onChanged: (value) {
                                setState(() {
                                  girildi = true;
                                });
                              },
                            ),
                            BiltekTextField(
                              controller: adresController,
                              currentFocus: adresFocus,
                              nextFocus: gsmFocus,
                              label: "Adresi",
                              onChanged: (value) {
                                setState(() {
                                  girildi = true;
                                });
                              },
                            ),
                            BiltekCheckbox(
                              label: "Müşteri bilgilerini kaydet",
                              value: musteriyiKaydet,
                              onChanged: (value) {
                                setState(() {
                                  musteriyiKaydet = value ?? true;
                                });
                              },
                            ),
                            BiltekTextField(
                              controller: gsmController,
                              currentFocus: gsmFocus,
                              label: "GSM",
                              keyboardType: TextInputType.phone,
                              onChanged: (value) {
                                setState(() {
                                  girildi = true;
                                });
                              },
                              inputFormatters: [Islemler.gsmFormatter],
                            ),
                            BiltekSelect<int?>(
                              title: "Cihaz Türü",
                              value: cihazTuru,
                              items: [
                                DropdownMenuItem(
                                  value: null,
                                  child: Text("Cihaz Türü Seçin *"),
                                ),
                                ...cihazDuzenleme.cihazTurleri.map(
                                  (e) => DropdownMenuItem(
                                    value: e.id,
                                    child: Text(e.isim),
                                  ),
                                )
                              ],
                              onChanged: (value) {
                                setState(() {
                                  cihazTuru = value;
                                  cihazTuruHata = null;
                                  girildi = true;
                                });
                              },
                              errorText: cihazTuruHata,
                            ),
                            BiltekSelect<int?>(
                              title: "Sorumlu Personel",
                              value: sorumlu,
                              items: [
                                DropdownMenuItem(
                                  value: null,
                                  child: Text("Sorumlu Personel Seçin *"),
                                ),
                                ...cihazDuzenleme.sorumlular.map(
                                  (e) => DropdownMenuItem(
                                    value: e.id,
                                    child: Text(e.adSoyad),
                                  ),
                                )
                              ],
                              onChanged: (value) {
                                setState(() {
                                  sorumlu = value;
                                  sorumluHata = null;
                                  girildi = true;
                                });
                              },
                              errorText: sorumluHata,
                            ),
                            BiltekTextField(
                              controller: cihazController,
                              currentFocus: cihazFocus,
                              nextFocus: cihazModeliFocus,
                              label: "Marka *",
                              errorText: cihazHata,
                              onChanged: (value) {
                                setState(() {
                                  girildi = true;
                                  cihazHata = null;
                                });
                              },
                            ),
                            BiltekTextField(
                              controller: cihazModeliController,
                              currentFocus: cihazModeliFocus,
                              nextFocus: seriNoFocus,
                              label: "Model",
                              onChanged: (value) {
                                setState(() {
                                  girildi = true;
                                });
                              },
                            ),
                            BiltekTextField(
                              controller: seriNoController,
                              currentFocus: seriNoFocus,
                              label: "Seri No",
                              onChanged: (value) {
                                setState(() {
                                  girildi = true;
                                });
                              },
                            ),
                            Row(
                              children: [
                                BiltekSelect<String?>(
                                  title: "Şifre Türü",
                                  width: sifreTuru != null && sifreTuru != "Yok"
                                      ? (MediaQuery.of(context).size.width /
                                              2) -
                                          10
                                      : null,
                                  value: sifreTuru,
                                  items: [
                                    DropdownMenuItem(
                                      value: null,
                                      child: Text("Şifre Türü Belirtin *"),
                                    ),
                                    DropdownMenuItem(
                                      value: "Pin",
                                      child: Text("Pin"),
                                    ),
                                    DropdownMenuItem(
                                      value: "Desen",
                                      child: Text("Desen"),
                                    ),
                                    DropdownMenuItem(
                                      value: "Yok",
                                      child: Text("Yok"),
                                    ),
                                  ],
                                  onChanged: (value) {
                                    setState(() {
                                      sifreTuru = value;
                                      sifreTuruHata = null;
                                      girildi = true;
                                      gecerliDesen = "";
                                      gecerliDesenList =
                                          gecerliDesenListTemp = [];
                                      sifreTuruPinController.text = "";
                                    });
                                    if (value == "Desen") {
                                      _desenSec();
                                    } else if (value == "Yok") {
                                      sifreTuruPinController.text = "Yok";
                                    }
                                  },
                                  errorText: sifreTuruHata,
                                ),
                                if (sifreTuru == "Pin" || sifreTuru == "Desen")
                                  SizedBox(
                                    width: 10,
                                  ),
                                if (sifreTuru == "Pin")
                                  Expanded(
                                    child: BiltekTextField(
                                      controller: sifreTuruPinController,
                                      nextFocus: null,
                                      label: "Cihaz Şifresi *",
                                      onChanged: (value) {
                                        setState(() {
                                          sifreTuruPinHata = null;
                                          girildi = true;
                                        });
                                      },
                                      errorText: sifreTuruPinHata,
                                    ),
                                  ),
                                if (sifreTuru == "Desen")
                                  DefaultButton(
                                    width:
                                        MediaQuery.of(context).size.width / 2,
                                    background: Islemler.arkaRenk("bg-primary"),
                                    onPressed: () async {
                                      _desenSec();
                                    },
                                    text: "Düzenle",
                                  ),
                              ],
                            ),
                            BiltekTextField(
                              controller: arizaAciklamasiController,
                              currentFocus: arizaAciklamasiFocus,
                              nextFocus: teslimAlinanlarFocus,
                              label: "Belirtilen arıza açıklaması *",
                              keyboardType: TextInputType.multiline,
                              onChanged: (value) {
                                setState(() {
                                  arizaAciklamasiHata = null;
                                  girildi = true;
                                });
                              },
                              errorText: arizaAciklamasiHata,
                            ),
                            BiltekTextField(
                              controller: teslimAlinanlarController,
                              currentFocus: teslimAlinanlarFocus,
                              nextFocus: hasarTespitiFocus,
                              label: "Teslim Alınanlar",
                              keyboardType: TextInputType.multiline,
                              onChanged: (value) {
                                setState(() {
                                  girildi = true;
                                });
                              },
                            ),
                            BiltekTextField(
                              controller: hasarTespitiController,
                              currentFocus: hasarTespitiFocus,
                              label: "Teslim alınırken yapılan hasar tespiti",
                              keyboardType: TextInputType.multiline,
                              onChanged: (value) {
                                setState(() {
                                  girildi = true;
                                });
                              },
                            ),
                            BiltekSelect<int>(
                              title: "Hasar Türü",
                              value: cihazdakiHasar,
                              items: [
                                for (int i = 0;
                                    i < Islemler.cihazdakiHasarlar.length;
                                    i++)
                                  DropdownMenuItem<int>(
                                    value: i,
                                    child: Text(
                                      i == 0
                                          ? "Belirtilmedi"
                                          : Islemler.cihazdakiHasarlar[i],
                                    ),
                                  ),
                              ],
                              onChanged: (value) {
                                setState(() {
                                  cihazdakiHasar = value!;
                                  girildi = true;
                                });
                              },
                            ),
                            BiltekSelect<int>(
                              title: "Servis Türü",
                              value: servisTuru,
                              items: [
                                for (int i = 0;
                                    i < Islemler.servisTurleri.length;
                                    i++)
                                  DropdownMenuItem<int>(
                                    value: i,
                                    child: Text(
                                      i == 0
                                          ? "Belirtilmedi"
                                          : Islemler.servisTurleri[i],
                                    ),
                                  ),
                              ],
                              onChanged: (value) {
                                setState(() {
                                  servisTuru = value!;
                                  girildi = true;
                                });
                              },
                            ),
                            BiltekSelect<int>(
                              title: "Yedek alınacak mı?",
                              value: yedekDurumu,
                              items: [
                                for (int i = 0;
                                    i < Islemler.evetHayirlar.length;
                                    i++)
                                  DropdownMenuItem<int>(
                                    value: i,
                                    child: Text(
                                      i == 0
                                          ? "Belirtilmedi"
                                          : Islemler.evetHayirlar[i],
                                    ),
                                  ),
                              ],
                              onChanged: (value) {
                                setState(() {
                                  yedekDurumu = value!;
                                  girildi = true;
                                });
                              },
                            ),
                          ],
                        ),
                      ),
                    ),
                    SizedBox(
                      width: MediaQuery.of(context).size.width,
                      child: Row(
                        mainAxisSize: MainAxisSize.max,
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          SizedBox(),
                          DefaultButton(
                            width: MediaQuery.of(context).size.width / 2,
                            background: Islemler.arkaRenk("bg-primary"),
                            onPressed: () async {
                              await _cihazEkle();
                            },
                            text: "Ekle",
                          ),
                        ],
                      ),
                    )
                  ],
                ),
        ),
      ),
    );
  }

  void cik() {
    widget.cihazlariYenile.call();
  }

  void tarihGuncelle(DateTime tarih) {
    tarihController.text = DateFormat(Islemler.tarihFormat).format(tarih);
  }

  Future<void> _cihazEkle() async {
    yukleniyor(context);
    NavigatorState navigatorState = Navigator.of(context);
    String musteriAdi = musteriAdiController.text;
    String cihaz = cihazController.text;
    String gsm = gsmController.text;
    bool hataVar = false;
    String cihazSifresi = sifreTuruPinController.text;
    String arizaAciklamasi = arizaAciklamasiController.text;
    if (musteriAdi.isEmpty) {
      setState(() {
        musteriAdiHata = "Müşteri Adı boş olamaz";
      });
      hataVar = true;
    }
    if (cihazTuru == null) {
      setState(() {
        cihazTuruHata = "Lütfen bir cihaz türü seçin";
      });
      hataVar = true;
    }
    if (sorumlu == null) {
      setState(() {
        sorumluHata = "Lütfen Sorumlu Personel seçin";
      });
      hataVar = true;
    }
    if (cihaz.isEmpty) {
      setState(() {
        cihazHata = "Lütfen bir marka girin.";
      });
      hataVar = true;
    }
    if (sifreTuru == null) {
      setState(() {
        sifreTuruHata = "Lütfen şifre türü belirtin!";
      });
      hataVar = true;
    }
    if (sifreTuru == "Pin" && cihazSifresi.isEmpty) {
      setState(() {
        sifreTuruPinHata = "Lütfen bir şifre girin!";
      });
      hataVar = true;
    }
    bool desenHata = false;
    if (sifreTuru == "Desen" && gecerliDesen.isEmpty) {
      navigatorState.pop();
      _desenSec(hata: desenHataMesaji);
      desenHata = true;
      hataVar = true;
    }

    if (sifreTuru == "Yok") {
      cihazSifresi = "Yok";
      gecerliDesen = "";
    }
    if (arizaAciklamasi.isEmpty) {
      setState(() {
        arizaAciklamasiHata = "Lütfen bir arıza açıklaması girin";
      });
      hataVar = true;
    }
    if (!hataVar) {
      Map<String, String> postData = {
        "musteri_kod": "",
        //TODO: Musteri bilgileri otomatik getirilecek.
        "musteri_adi": musteriAdi,
        "musteriyi_kaydet": musteriyiKaydet ? "1" : "0",
        "teslim_eden": teslimEdenController.text,
        "adres": adresController.text,
        "cihaz_turu": cihazTuru.toString(),
        "sorumlu": sorumlu.toString(),
        "cihaz": cihaz,
        "cihaz_modeli": cihazModeliController.text,
        "seri_no": seriNoController.text,
        "cihaz_sifresi": cihazSifresi,
        "cihaz_deseni": gecerliDesen,
        "ariza_aciklamasi": arizaAciklamasi,
        "teslim_alinanlar": teslimAlinanlarController.text,
        "hasar_tespiti": hasarTespitiController.text,
        "cihazdaki_hasar": cihazdakiHasar.toString(),
        "servis_turu": servisTuru.toString(),
        "yedek_durumu": yedekDurumu.toString(),
        "tarih_girisi": tarihGirisi,
      };
      if (tarihGirisi == "el") {
        postData.addAll({
          "tarih": tarihController.text,
        });
      }
      if (gsm.isNotEmpty && gsm != "+90") {
        postData.addAll({
          "telefon_numarasi": gsm,
        });
      }

      bool sonuc = await BiltekPost.cihazEkle(postData: postData);
      if (sonuc) {
        widget.cihazlariYenile.call();
        navigatorState.pop();
        navigatorState.pop();
      } else {
        navigatorState.pop();
        if (mounted) {
          showDialog(
            context: context,
            builder: (context) {
              return AlertDialog(
                title: Text("Hata"),
                content: Text("Cihaz eklenirken bir hata oluştu"),
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
    } else {
      if (!desenHata) {
        navigatorState.pop();
      }
    }
  }

  Future<void> _cihazDuzenlemeGetir() async {
    CihazDuzenlemeModel cihazDuzenlemeTemp =
        await BiltekPost.cihazDuzenlemeGetir();
    setState(() {
      cihazDuzenleme = cihazDuzenlemeTemp;
    });
  }

  void _desenSec({String? hata}) {
    showDialog(
      context: context,
      builder: (context) {
        return AlertDialog(
          title: Text("Desen Seç"),
          content: SizedBox(
            width: MediaQuery.of(context).size.width,
            height: 300,
            child: Desen(
              key: desenKey,
              hata: hata ?? "",
              initDesen: gecerliDesenList,
              pointRadius: 8,
              showInput: true,
              dimension: 3,
              relativePadding: 0.7,
              selectThreshold: 25,
              fillPoints: true,
              onInputComplete: (List<int> input) {
                debugPrint("Desen: $input");
                desenKey.currentState?.hataGoster("");
                setState(() {
                  gecerliDesenListTemp = input;
                });
              },
            ),
          ),
          actions: [
            TextButton(
              onPressed: () {
                if (gecerliDesenListTemp.isEmpty) {
                  desenKey.currentState?.hataGoster(desenHataMesaji);
                  return;
                }
                setState(() {
                  gecerliDesenList = gecerliDesenListTemp;
                });
                String gecerliDesenTemp =
                    Islemler.desenDonusturSQL(gecerliDesenList);
                setState(() {
                  gecerliDesen = gecerliDesenTemp;
                });
                Navigator.pop(context);
              },
              child: Text("Onayla"),
            ),
            TextButton(
              onPressed: () {
                Navigator.pop(context);
              },
              child: Text("İptal"),
            ),
          ],
        );
      },
    );
  }
}
