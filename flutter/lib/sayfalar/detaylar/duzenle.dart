import 'package:biltekteknikservis/models/islemler_model.dart';
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';

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

  TextEditingController tarihController = TextEditingController();
  TextEditingController bildirimTarihiController = TextEditingController();
  TextEditingController cikisTarihiController = TextEditingController();

  int guncelDurum = 0;
  int tahsilatSekli = 0;

  int faturaDurumu = 0;
  TextEditingController fisNoController = TextEditingController();
  String? fisNoHata;

  List<IslemlerModel> islemler = [];

  String toplam = "0 TL";
  String kdv = "0 TL";
  String genelToplam = "0 TL";

  TextEditingController yapilanIslemAciklamasiController =
      TextEditingController();

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

      // Yapılan İşlemler
      tarihController.text = widget.cihaz.tarih;
      bildirimTarihiController.text = widget.cihaz.bildirimTarihi;
      cikisTarihiController.text = widget.cihaz.cikisTarihi;
      guncelDurum = widget.cihaz.guncelDurum;
      tahsilatSekli = widget.cihaz.tahsilatSekliVal;
      faturaDurumu = widget.cihaz.faturaDurumu;
      fisNoController.text = widget.cihaz.fisNo;
      for (int i = 0; i < widget.cihaz.islemler.length; i++) {
        YapilanIslem yapilanIslem = widget.cihaz.islemler[i];
        IslemlerModel islemlerModel = IslemlerModel.of(
          islem: yapilanIslem.ad,
          miktar: yapilanIslem.miktar,
          birimFiyati: yapilanIslem.birimFiyati.toStringAsFixed(2),
          kdv: yapilanIslem.kdv.toStringAsFixed(2),
        );
        islemlerModel.islemController.text = islemlerModel.islem;
        islemlerModel.miktarController.text = islemlerModel.miktar.toString();
        islemlerModel.birimFiyatiController.text = islemlerModel.birimFiyati;
        islemlerModel.kdvController.text = islemlerModel.kdv;
        islemler.add(islemlerModel);
      }
      _fiyatlariGuncelle();
      yapilanIslemAciklamasiController.text =
          widget.cihaz.yapilanIslemAciklamasi;
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
    tarihController.dispose();
    bildirimTarihiController.dispose();
    cikisTarihiController.dispose();
    fisNoController.dispose();
    for (int i = 0; i < islemler.length; i++) {
      islemler[i].islemController.dispose();
      islemler[i].islemFocusNode.dispose();
      islemler[i].miktarController.dispose();
      islemler[i].miktarFocusNode.dispose();
      islemler[i].birimFiyatiController.dispose();
      islemler[i].birimFiyatiFocusNode.dispose();
      islemler[i].kdvController.dispose();
      islemler[i].kdvFocusNode.dispose();
    }
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
                            : SingleChildScrollView(
                                child: Column(
                                  children: [
                                    BiltekTarih(
                                      controller: tarihController,
                                      label: "Giriş Tarihi",
                                      onConfirm: (date) {
                                        girisTarihiGuncelle(date!);
                                      },
                                      onChanged: (value) {
                                        setState(() {
                                          girildi = true;
                                        });
                                      },
                                    ),
                                    BiltekTarih(
                                      controller: bildirimTarihiController,
                                      label: "Bildirim Tarihi",
                                      onConfirm: (date) {
                                        bildirimTarihiGuncelle(date!);
                                        setState(() {
                                          girildi = true;
                                        });
                                      },
                                      onChanged: (value) {
                                        setState(() {
                                          girildi = true;
                                        });
                                      },
                                    ),
                                    BiltekTarih(
                                      controller: cikisTarihiController,
                                      label: "Çıkış Tarihi",
                                      onConfirm: (date) {
                                        cikisTarihiGuncelle(date!);
                                        setState(() {
                                          girildi = true;
                                        });
                                      },
                                      onChanged: (value) {
                                        setState(() {
                                          girildi = true;
                                        });
                                      },
                                    ),
                                    BiltekSelect<int>(
                                      title: "Güncel DUrum",
                                      value: guncelDurum,
                                      items: [
                                        ...cihazDuzenleme.cihazDurumlari.map(
                                          (e) => DropdownMenuItem(
                                            value: e.id,
                                            child: Text(e.durum),
                                          ),
                                        )
                                      ],
                                      onChanged: (value) {
                                        setState(() {
                                          guncelDurum = value!;
                                          girildi = true;
                                        });
                                      },
                                    ),
                                    BiltekSelect<int>(
                                      title: "Tahsilat Şekli",
                                      value: tahsilatSekli,
                                      items: [
                                        DropdownMenuItem(
                                          value: 0,
                                          child: Text("Tahsilat Şekli Seçin"),
                                        ),
                                        ...cihazDuzenleme.tahsilatSekilleri.map(
                                          (e) => DropdownMenuItem(
                                            value: e.id,
                                            child: Text(e.isim),
                                          ),
                                        )
                                      ],
                                      onChanged: (value) {
                                        setState(() {
                                          tahsilatSekli = value!;
                                          girildi = true;
                                        });
                                      },
                                    ),
                                    Row(
                                      children: [
                                        BiltekSelect<int>(
                                          title: "Fatura Durumu",
                                          width: faturaDurumu ==
                                                  Islemler.faturaDurumlari
                                                      .indexWhere((ft) =>
                                                          ft ==
                                                          "Fatura Kesildi")
                                              ? (MediaQuery.of(context)
                                                          .size
                                                          .width /
                                                      2) -
                                                  10
                                              : null,
                                          value: faturaDurumu,
                                          items: [
                                            for (int i = 0;
                                                i <
                                                    Islemler
                                                        .faturaDurumlari.length;
                                                i++)
                                              DropdownMenuItem(
                                                value: i,
                                                child: Text(Islemler
                                                    .faturaDurumlari[i]),
                                              ),
                                          ],
                                          onChanged: (value) {
                                            setState(() {
                                              faturaDurumu = value!;
                                              girildi = true;
                                            });
                                          },
                                          errorText: sifreTuruHata,
                                        ),
                                        if (faturaDurumu ==
                                            Islemler.faturaDurumlari.indexWhere(
                                                (ft) => ft == "Fatura Kesildi"))
                                          SizedBox(
                                            width: 10,
                                          ),
                                        if (faturaDurumu ==
                                            Islemler.faturaDurumlari.indexWhere(
                                                (ft) => ft == "Fatura Kesildi"))
                                          Expanded(
                                            child: BiltekTextField(
                                              controller: fisNoController,
                                              nextFocus: null,
                                              label: "Fiş Numarası *",
                                              onChanged: (value) {
                                                setState(() {
                                                  fisNoHata = null;
                                                  girildi = true;
                                                });
                                              },
                                              errorText: fisNoHata,
                                            ),
                                          ),
                                      ],
                                    ),
                                    Text(
                                      "Yapılan İşlemler",
                                      style: TextStyle(
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                    for (int i = 0; i < islemler.length; i++)
                                      Column(
                                        children: [
                                          SizedBox(
                                            height: 10,
                                          ),
                                          Row(
                                            mainAxisAlignment:
                                                MainAxisAlignment.start,
                                            crossAxisAlignment:
                                                CrossAxisAlignment.start,
                                            children: [
                                              Expanded(
                                                child: Column(
                                                  mainAxisAlignment:
                                                      MainAxisAlignment.start,
                                                  crossAxisAlignment:
                                                      CrossAxisAlignment.center,
                                                  children: [
                                                    Text(
                                                      (i + 1).toString(),
                                                      style: TextStyle(
                                                        fontWeight:
                                                            FontWeight.bold,
                                                      ),
                                                    ),
                                                    BiltekTextField(
                                                      controller: islemler[i]
                                                          .islemController,
                                                      currentFocus: islemler[i]
                                                          .islemFocusNode,
                                                      nextFocus: islemler[i]
                                                          .miktarFocusNode,
                                                      label:
                                                          "Malzeme / İşçilik",
                                                      errorText:
                                                          islemler[i].islemHata,
                                                      onChanged: (value) {
                                                        setState(() {
                                                          girildi = true;
                                                          islemler[i]
                                                              .islemHata = null;

                                                          islemler[i].islem =
                                                              value;
                                                        });
                                                      },
                                                    ),
                                                    BiltekTextField(
                                                      controller: islemler[i]
                                                          .miktarController,
                                                      currentFocus: islemler[i]
                                                          .miktarFocusNode,
                                                      nextFocus: islemler[i]
                                                          .birimFiyatiFocusNode,
                                                      keyboardType: TextInputType
                                                          .numberWithOptions(
                                                        decimal: false,
                                                      ),
                                                      label: "Miktar",
                                                      errorText: islemler[i]
                                                          .miktarHata,
                                                      onChanged: (value) {
                                                        setState(() {
                                                          girildi = true;
                                                          islemler[i]
                                                                  .miktarHata =
                                                              null;
                                                          if (value
                                                              .isNotEmpty) {
                                                            islemler[i].miktar =
                                                                int.parse(
                                                                    value);
                                                          } else {
                                                            islemler[i].miktar =
                                                                0;
                                                          }
                                                        });
                                                        _fiyatlariGuncelle();
                                                      },
                                                    ),
                                                    BiltekTextField(
                                                      controller: islemler[i]
                                                          .birimFiyatiController,
                                                      currentFocus: islemler[i]
                                                          .birimFiyatiFocusNode,
                                                      nextFocus: islemler[i]
                                                          .kdvFocusNode,
                                                      keyboardType: TextInputType
                                                          .numberWithOptions(
                                                        decimal: true,
                                                      ),
                                                      label: "Birim Fiyatı",
                                                      errorText: islemler[i]
                                                          .birimFiyatiHata,
                                                      onChanged: (value) {
                                                        setState(() {
                                                          girildi = true;
                                                          islemler[i]
                                                                  .birimFiyatiHata =
                                                              null;
                                                          if (value
                                                              .isNotEmpty) {
                                                            islemler[i]
                                                                .birimFiyati = double
                                                                    .parse(
                                                                        value)
                                                                .toStringAsFixed(
                                                                    2);
                                                          } else {
                                                            islemler[i]
                                                                    .birimFiyati =
                                                                "0.00";
                                                          }
                                                        });
                                                        _fiyatlariGuncelle();
                                                      },
                                                    ),
                                                    BiltekTextField(
                                                      controller: islemler[i]
                                                          .kdvController,
                                                      currentFocus: islemler[i]
                                                          .kdvFocusNode,
                                                      nextFocus: islemler
                                                                  .length >
                                                              i + 1
                                                          ? islemler[i + 1]
                                                              .islemFocusNode
                                                          : null,
                                                      keyboardType: TextInputType
                                                          .numberWithOptions(
                                                        decimal: true,
                                                      ),
                                                      label: "KDV",
                                                      onChanged: (value) {
                                                        setState(() {
                                                          girildi = true;
                                                          if (value
                                                              .isNotEmpty) {
                                                            islemler[i]
                                                                .kdv = double
                                                                    .parse(
                                                                        value)
                                                                .toStringAsFixed(
                                                                    2);
                                                          } else {
                                                            islemler[i].kdv =
                                                                "0.00";
                                                          }
                                                        });
                                                        _fiyatlariGuncelle();
                                                      },
                                                    ),
                                                    Row(
                                                      mainAxisAlignment:
                                                          MainAxisAlignment
                                                              .spaceBetween,
                                                      children: [
                                                        Text("KDV:"),
                                                        Text(
                                                            islemler[i].kdvStr),
                                                      ],
                                                    ),
                                                    Row(
                                                      mainAxisAlignment:
                                                          MainAxisAlignment
                                                              .spaceBetween,
                                                      children: [
                                                        Text(
                                                            "Tutar (KDV'siz):"),
                                                        Text(islemler[i]
                                                            .kdvsizStr),
                                                      ],
                                                    ),
                                                    Row(
                                                      mainAxisAlignment:
                                                          MainAxisAlignment
                                                              .spaceBetween,
                                                      children: [
                                                        Text("Toplam:"),
                                                        Text(islemler[i]
                                                            .toplamStr),
                                                      ],
                                                    ),
                                                  ],
                                                ),
                                              ),
                                              SizedBox(
                                                width: 50,
                                                child: IconButton(
                                                  onPressed: () {
                                                    islemler[i]
                                                        .islemController
                                                        .dispose();
                                                    islemler[i]
                                                        .islemFocusNode
                                                        .dispose();
                                                    islemler[i]
                                                        .miktarController
                                                        .dispose();
                                                    islemler[i]
                                                        .miktarFocusNode
                                                        .dispose();
                                                    islemler[i]
                                                        .birimFiyatiController
                                                        .dispose();
                                                    islemler[i]
                                                        .birimFiyatiFocusNode
                                                        .dispose();
                                                    islemler[i]
                                                        .kdvController
                                                        .dispose();
                                                    islemler[i]
                                                        .kdvFocusNode
                                                        .dispose();
                                                    setState(() {
                                                      islemler.removeAt(i);
                                                      girildi = true;
                                                    });
                                                    _fiyatlariGuncelle();
                                                  },
                                                  icon: Icon(
                                                    Icons.remove,
                                                  ),
                                                ),
                                              )
                                            ],
                                          ),
                                        ],
                                      ),
                                    if (islemler.isEmpty)
                                      Text("Henüz yapılan bir işlem yok"),
                                    if (islemler.length <=
                                        Islemler.maxIslemSayisi)
                                      SizedBox(
                                        width:
                                            MediaQuery.of(context).size.width,
                                        child: Row(
                                          mainAxisSize: MainAxisSize.max,
                                          mainAxisAlignment:
                                              MainAxisAlignment.end,
                                          children: [
                                            IconButton(
                                              onPressed: () {
                                                IslemlerModel islemlerModel =
                                                    IslemlerModel.of(
                                                        islem: "",
                                                        miktar: 1,
                                                        birimFiyati: "0.00",
                                                        kdv: "0.00");
                                                islemlerModel.miktarController
                                                    .text = islemlerModel.islem;
                                                islemlerModel
                                                        .miktarController.text =
                                                    islemlerModel.miktar
                                                        .toString();
                                                islemlerModel
                                                        .birimFiyatiController
                                                        .text =
                                                    islemlerModel.birimFiyati;
                                                islemlerModel.kdvController
                                                    .text = islemlerModel.kdv;
                                                setState(() {
                                                  islemler.add(islemlerModel);
                                                  girildi = true;
                                                });
                                              },
                                              icon: Icon(Icons.add),
                                            ),
                                          ],
                                        ),
                                      ),
                                    Row(
                                      mainAxisAlignment:
                                          MainAxisAlignment.spaceBetween,
                                      children: [
                                        Text("Toplam:"),
                                        Text(toplam),
                                      ],
                                    ),
                                    Row(
                                      mainAxisAlignment:
                                          MainAxisAlignment.spaceBetween,
                                      children: [
                                        Text("KDV:"),
                                        Text(kdv),
                                      ],
                                    ),
                                    Row(
                                      mainAxisAlignment:
                                          MainAxisAlignment.spaceBetween,
                                      children: [
                                        Text("Genel Toplam:"),
                                        Text(genelToplam),
                                      ],
                                    ),
                                    BiltekTextField(
                                      controller:
                                          yapilanIslemAciklamasiController,
                                      label: "Yapılan İşlem Açıklaması",
                                      onChanged: (value) {
                                        setState(() {
                                          fisNoHata = null;
                                          girildi = true;
                                        });
                                      },
                                      errorText: fisNoHata,
                                    ),
                                  ],
                                ),
                              ),
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
                              background: Islemler.arkaRenk("bg-secondary"),
                              onPressed: () {
                                cikisKontrol();
                              },
                              text: "Kapat",
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

  void girisTarihiGuncelle(DateTime tarih) {
    tarihController.text = DateFormat(Islemler.tarihFormat).format(tarih);
  }

  void bildirimTarihiGuncelle(DateTime tarih) {
    bildirimTarihiController.text =
        DateFormat(Islemler.tarihFormat).format(tarih);
  }

  void cikisTarihiGuncelle(DateTime tarih) {
    cikisTarihiController.text = DateFormat(Islemler.tarihFormat).format(tarih);
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
    String fisNo = fisNoController.text;
    if (faturaDurumu ==
            Islemler.faturaDurumlari
                .indexWhere((ft) => ft == "Fatura Kesildi") &&
        fisNo.isEmpty) {
      setState(() {
        fisNoHata = "Lütfen bir fiş numarası girin";
      });
      hataVar = true;
    }
    for (int i = 0; i < islemler.length; i++) {
      if (islemler[i].islemController.text.isEmpty) {
        setState(() {
          islemler[i].islemHata = "Malzeme / İşçilik Boş Olamaz";
        });
        hataVar = true;
      }
      int? miktar = int.tryParse(islemler[i].miktarController.text) ?? 0;
      if (islemler[i].miktarController.text.isEmpty || miktar <= 0) {
        setState(() {
          islemler[i].miktarHata = "Miktar boş veya 0'dan küçük olamaz";
        });
        hataVar = true;
      }
      if (islemler[i].birimFiyatiController.text.isEmpty) {
        setState(() {
          islemler[i].birimFiyatiHata = "Birim Fiyatı boş olamaz";
        });
        hataVar = true;
      }
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
        "tarih": tarihController.text,
        "bildirim_tarihi": bildirimTarihiController.text,
        "cikis_tarihi": cikisTarihiController.text,
        "guncel_durum": guncelDurum.toString(),
        "tahsilat_sekli": tahsilatSekli.toString(),
        "fatura_durumu": faturaDurumu.toString(),
        "fis_no": fisNoController.text,
        "yapilan_islem_aciklamasi": yapilanIslemAciklamasiController.text,
      };

      if (gsm.isNotEmpty && gsm != "+90") {
        postData.addAll({
          "telefon_numarasi": gsm,
        });
      }
      for (int i = 0; i < islemler.length; i++) {
        postData.addAll({
          "islem${(i + 1)}": islemler[i].islemController.text,
          "miktar${(i + 1)}": islemler[i].miktar.toString(),
          "birim_fiyati${(i + 1)}": islemler[i].birimFiyati,
          "kdv_${(i + 1)}": islemler[i].kdv,
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

  void _fiyatlariGuncelle() {
    double toplamTemp = 0;
    double kdvTemp = 0;
    double genelToplamTemp = 0;
    for (int i = 0; i < islemler.length; i++) {
      if (islemler[i].miktarController.text.isNotEmpty) {
        double yerelToplamTemp = islemler[i].miktar *
            (double.tryParse(islemler[i].birimFiyati) ?? 0);
        double k = double.tryParse(islemler[i].kdv) ?? 0;
        double yerelKDVTemp = (yerelToplamTemp / 100) * k;
        double yerelGenelToplam = yerelToplamTemp + yerelKDVTemp;
        toplamTemp += yerelToplamTemp;
        kdvTemp += yerelKDVTemp;
        setState(() {
          islemler[i].kdvStr = "${yerelKDVTemp.toStringAsFixed(2)} TL ($k%)";
          islemler[i].kdvsizStr = "${yerelToplamTemp.toStringAsFixed(2)} TL";
          islemler[i].toplamStr = "${yerelGenelToplam.toStringAsFixed(2)} TL";
        });
      }
    }
    genelToplamTemp = toplamTemp + kdvTemp;

    setState(() {
      toplam = "${toplamTemp.toStringAsFixed(2)} TL";
      kdv = "${kdvTemp.toStringAsFixed(2)} TL";
      genelToplam = "${genelToplamTemp.toStringAsFixed(2)} TL";
    });
  }
}
