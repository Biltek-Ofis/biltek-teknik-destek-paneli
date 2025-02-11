import 'package:flutter/material.dart';

import '../../models/cihaz.dart';
import '../../models/cihaz_duzenleme/cihaz_duzenleme.dart';
import '../../utils/alerts.dart';
import '../../utils/buttons.dart';
import '../../utils/desen.dart';
import '../../utils/islemler.dart';
import '../../utils/post.dart';
import '../../widgets/input.dart';

class DetayDuzenle extends StatefulWidget {
  const DetayDuzenle({
    super.key,
    required this.cihaz,
    required this.cihazlariYenile,
  });

  final Cihaz cihaz;
  final VoidCallback cihazlariYenile;
  @override
  State<DetayDuzenle> createState() => _DetayDuzenleState();
}

class _DetayDuzenleState extends State<DetayDuzenle> {
  bool girildi = false;

  TextEditingController musteriAdiController = TextEditingController();
  FocusNode musteriAdiFocus = FocusNode();
  String? musteriAdiHata;

  TextEditingController teslimEdenController = TextEditingController();
  FocusNode teslimEdenFocus = FocusNode();

  TextEditingController teslimAlanController = TextEditingController();
  FocusNode teslimAlanFocus = FocusNode();

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

  CihazDuzenlemeModel cihazDuzenleme = CihazDuzenlemeModel.bos();

  String? sifreTuru;
  String? sifreTuruHata;

  TextEditingController sifreTuruPinController = TextEditingController();
  String? sifreTuruPinHata;

  GlobalKey<DesenState> desenKey = GlobalKey();
  String gecerliDesen = "";
  List<int> gecerliDesenList = [];
  List<int> gecerliDesenListTemp = [];
  String desenHataMesaji = "Lütfen geçerli bir desen seçin";

  int cihazdakiHasar = 0;

  TextEditingController hasarTespitiController = TextEditingController();
  FocusNode hasarTespitiFocus = FocusNode();

  TextEditingController arizaAciklamasiController = TextEditingController();
  FocusNode arizaAciklamasiFocus = FocusNode();
  String? arizaAciklamasiHata;

  TextEditingController teslimAlinanlarController = TextEditingController();
  FocusNode teslimAlinanlarFocus = FocusNode();

  int servisTuru = 0;
  int yedekDurumu = 0;

  bool sayfaYukleniyor = true;
  @override
  void initState() {
    super.initState();
    Future.delayed(Duration.zero, () async {
      await _cihazDuzenlemeGetir();
      musteriAdiController.text = widget.cihaz.musteriAdi;
      teslimEdenController.text = widget.cihaz.teslimEden;
      teslimAlanController.text = widget.cihaz.teslimAlan;
      adresController.text = widget.cihaz.adres;
      if (Islemler.telNo(widget.cihaz.telefonNumarasi)
          .replaceAll("+90", "")
          .trim()
          .isEmpty) {
        gsmController.text = "+90";
      } else {
        gsmController.text = widget.cihaz.telefonNumarasi;
      }
      int cihazTuruIndex = cihazDuzenleme.cihazTurleri
          .indexWhere((ct) => ct.id == widget.cihaz.cihazTuruVal);
      if (cihazTuruIndex >= 0) {
        cihazTuru = widget.cihaz.cihazTuruVal;
      }
      int sorumluIndex = cihazDuzenleme.sorumlular
          .indexWhere((s) => s.id == widget.cihaz.sorumluVal);
      if (sorumluIndex >= 0) {
        sorumlu = widget.cihaz.sorumluVal;
      }
      cihazController.text = widget.cihaz.cihaz;
      cihazModeliController.text = widget.cihaz.cihazModeli;
      seriNoController.text = widget.cihaz.seriNo;
      if (widget.cihaz.cihazDeseni.isNotEmpty) {
        sifreTuru = "Desen";
        gecerliDesen = widget.cihaz.cihazDeseni;
        List<int> desen = Islemler.desenDonusturFlutter(gecerliDesen);
        gecerliDesenList = gecerliDesenListTemp = desen;
      } else if (widget.cihaz.cihazSifresi.toLowerCase() == "yok") {
        sifreTuru = "Yok";
        sifreTuruPinController.text = widget.cihaz.cihazSifresi;
      } else {
        sifreTuru = "Pin";
        sifreTuruPinController.text = widget.cihaz.cihazSifresi;
      }

      if (widget.cihaz.cihazdakiHasar < Islemler.cihazdakiHasarlar.length) {
        cihazdakiHasar = widget.cihaz.cihazdakiHasar;
      }
      if (widget.cihaz.servisTuru < Islemler.servisTurleri.length) {
        servisTuru = widget.cihaz.servisTuru;
      }
      if (widget.cihaz.yedekDurumu < Islemler.evetHayirlar.length) {
        yedekDurumu = widget.cihaz.yedekDurumu;
      }
      hasarTespitiController.text = widget.cihaz.hasarTespiti;
      arizaAciklamasiController.text = widget.cihaz.arizaAciklamasi;
      teslimAlinanlarController.text = widget.cihaz.teslimAlinanlar;
      setState(() {
        sayfaYukleniyor = false;
      });
    });
  }

  @override
  void dispose() {
    musteriAdiController.dispose();
    musteriAdiFocus.dispose();
    teslimEdenController.dispose();
    teslimEdenFocus.dispose();
    teslimAlanController.dispose();
    teslimAlanFocus.dispose();
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
        cikisKontrol();
      },
      child: DefaultTabController(
        length: 2,
        child: Scaffold(
          appBar: AppBar(
            title: Text("${widget.cihaz.servisNo} Düzenle"),
            bottom: TabBar(
              labelColor: Colors.white,
              unselectedLabelColor: Colors.white,
              tabs: [
                Tab(
                  text: "Genel",
                ),
                Tab(
                  text: "Yapılan İşlemler",
                ),
              ],
            ),
          ),
          body: SizedBox(
            width: MediaQuery.of(context).size.width,
            height: MediaQuery.of(context).size.height,
            child: Column(
              children: [
                Expanded(
                  child: TabBarView(
                    children: [
                      SizedBox(
                        child: sayfaYukleniyor
                            ? Center(
                                child: CircularProgressIndicator(),
                              )
                            : SingleChildScrollView(
                                child: Column(
                                  children: [
                                    Text(
                                        "Gerekli alanlar * ile belirtilmiştir."),
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
                                      nextFocus: teslimAlanFocus,
                                      label: "Teslim Eden Kişi",
                                      onChanged: (value) {
                                        setState(() {
                                          girildi = true;
                                        });
                                      },
                                    ),
                                    BiltekTextField(
                                      controller: teslimAlanController,
                                      currentFocus: teslimAlanFocus,
                                      nextFocus: adresFocus,
                                      label: "Teslim Alan Kişi",
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
                                          child:
                                              Text("Sorumlu Personel Seçin *"),
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
                                          width: sifreTuru != null &&
                                                  sifreTuru != "Yok"
                                              ? (MediaQuery.of(context)
                                                          .size
                                                          .width /
                                                      2) -
                                                  10
                                              : null,
                                          value: sifreTuru,
                                          items: [
                                            DropdownMenuItem(
                                              value: null,
                                              child: Text("Belirtilmemiş *"),
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
                                              sifreTuruPinController.text =
                                                  "Yok";
                                            }
                                          },
                                          errorText: sifreTuruHata,
                                        ),
                                        if (sifreTuru == "Pin" ||
                                            sifreTuru == "Desen")
                                          SizedBox(
                                            width: 10,
                                          ),
                                        if (sifreTuru == "Pin")
                                          Expanded(
                                            child: BiltekTextField(
                                              controller:
                                                  sifreTuruPinController,
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
                                            width: MediaQuery.of(context)
                                                    .size
                                                    .width /
                                                2,
                                            background:
                                                Islemler.arkaRenk("bg-primary"),
                                            onPressed: () async {
                                              _desenSec();
                                            },
                                            text: "Düzenle",
                                          ),
                                      ],
                                    ),
                                    BiltekSelect<int>(
                                      title: "Hasar Türü",
                                      value: cihazdakiHasar,
                                      items: [
                                        for (int i = 0;
                                            i <
                                                Islemler
                                                    .cihazdakiHasarlar.length;
                                            i++)
                                          DropdownMenuItem<int>(
                                            value: i,
                                            child: Text(
                                              i == 0
                                                  ? "Belirtilmemiş"
                                                  : Islemler
                                                      .cihazdakiHasarlar[i],
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
                                    BiltekTextField(
                                      controller: hasarTespitiController,
                                      currentFocus: hasarTespitiFocus,
                                      nextFocus: arizaAciklamasiFocus,
                                      label:
                                          "Teslim alınırken yapılan hasar tespiti",
                                      keyboardType: TextInputType.multiline,
                                      onChanged: (value) {
                                        setState(() {
                                          girildi = true;
                                        });
                                      },
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
                                      label: "Teslim Alınanlar",
                                      keyboardType: TextInputType.multiline,
                                      onChanged: (value) {
                                        setState(() {
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
                                                  ? "Belirtilmemiş"
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
                                                  ? "Belirtilmemiş"
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
                        child: sayfaYukleniyor
                            ? Center(
                                child: CircularProgressIndicator(),
                              )
                            : Center(),
                      ),
                    ],
                  ),
                ),
                sayfaYukleniyor
                    ? SizedBox()
                    : SizedBox(
                        width: MediaQuery.of(context).size.width,
                        child: Row(
                          mainAxisSize: MainAxisSize.max,
                          mainAxisAlignment: MainAxisAlignment.end,
                          children: [
                            SizedBox(),
                            DefaultButton(
                              width: MediaQuery.of(context).size.width / 3,
                              background: Islemler.arkaRenk("bg-primary"),
                              onPressed: () async {
                                await _kaydetGenel();
                              },
                              text: "Kaydet",
                            ),
                            SizedBox(
                              width: 10,
                            ),
                            DefaultButton(
                              width: MediaQuery.of(context).size.width / 3,
                              background: Islemler.arkaRenk("bg-danger"),
                              onPressed: () {
                                cikisKontrol();
                              },
                              text: "İptal",
                            ),
                          ],
                        ),
                      )
              ],
            ),
          ),
        ),
      ),
    );
  }

  Future<void> cikisKontrol() async {
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
  }

  void cik() {
    widget.cihazlariYenile.call();
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
                String gecerliDesenTemp = "";
                for (var desen in gecerliDesenList) {
                  gecerliDesenTemp += (desen + 1).toString();
                }
                setState(() {
                  gecerliDesen = gecerliDesenTemp;
                });
                debugPrint("Desen: $gecerliDesen");
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

  Future<void> _kaydetGenel() async {
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
        "teslim_eden": teslimEdenController.text,
        "teslim_alan": teslimAlanController.text,
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
      };
      if (gsm.isNotEmpty && gsm != "+90") {
        postData.addAll({
          "telefon_numarasi": gsm,
        });
      }

      bool sonuc = await BiltekPost.cihazDuzenle(
        id: widget.cihaz.id,
        postData: postData,
      );
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
                content: Text("Cihaz kaydedilirken bir hata oluştu"),
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
}
