import 'dart:async';

import 'package:flutter/cupertino.dart';
import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:flutter_contacts/flutter_contacts.dart';
import 'package:permission_handler/permission_handler.dart';
import 'package:url_launcher/url_launcher_string.dart';

import '../../ayarlar.dart';
import '../../models/cihaz.dart';
import '../../models/cihaz_duzenleme/cihaz_duzenleme.dart';
import '../../models/kullanici.dart';
import '../../utils/alerts.dart';
import '../../utils/assets.dart';
import '../../utils/desen.dart';
import '../../utils/islemler.dart';
import '../../utils/post.dart';
import '../../widgets/dizayn.dart';
import '../../widgets/input.dart';
import '../../widgets/navigators.dart';
import '../../widgets/overlay_notification.dart';
import '../imza.dart';
import '../webview.dart';
import 'duzenle.dart';
import 'galery.dart';

class DetaylarSayfasi extends StatefulWidget {
  const DetaylarSayfasi({
    super.key,
    required this.kullanici,
    required this.no,
    required this.cihazlariYenile,
  });

  final KullaniciAuthModel kullanici;
  final int no;
  final VoidCallback cihazlariYenile;

  @override
  State<DetaylarSayfasi> createState() => _DetaylarSayfasiState();
}

class _DetaylarSayfasiState extends State<DetaylarSayfasi> {
  Cihaz? cihaz;
  bool detaylarYukleniyor = true;
  CihazDuzenlemeModel cihazDuzenleme = CihazDuzenlemeModel.bos();
  int seciliIndex = 0;
  PageController pageController = PageController(initialPage: 0);

  static const _accent = Colors.greenAccent;

  @override
  void initState() {
    Future.delayed(Duration.zero, () async {
      await _cihazDuzenlemeGetir();
      await _cihaziYenile();
    });
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    //final cs = Theme.of(context).colorScheme;

    return PopScope(
      canPop: false,
      onPopInvokedWithResult: (didPop, result) {
        if (didPop) return;
        widget.cihazlariYenile.call();
        Navigator.pop(context);
      },
      child: Scaffold(
        appBar: AppBar(
          title:
              cihaz != null
                  ? Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        "Servis #${cihaz!.servisNo}",
                        style: const TextStyle(
                          fontWeight: FontWeight.bold,
                          fontSize: 16,
                        ),
                      ),
                      if (cihaz!.guncelDurumText.isNotEmpty)
                        Text(
                          cihaz!.guncelDurumText,
                          style: TextStyle(
                            fontSize: 11,
                            color: _accent,
                            fontWeight: FontWeight.w500,
                          ),
                        ),
                    ],
                  )
                  : null,
        ),

        floatingActionButton: Builder(
          builder: (context) {
            final fabBtns = <_FabItem>[
              _FabItem(
                tag: "Signature",
                icon: CupertinoIcons.signature,
                label: "İmza",
                onPressed: () async {
                  Navigator.of(context).push(
                    MaterialPageRoute(
                      builder:
                          (context) => ImzaSayfasi(
                            id: cihaz!.id,
                            points: cihaz!.imzaJsonToPoint(),
                            kullanici: widget.kullanici,
                            teslimAlan: cihaz!.teslimAlan,
                            onYuklendi: () async {
                              await _cihaziYenile();
                            },
                          ),
                    ),
                  );
                },
              ),
              _FabItem(
                tag: "Print",
                icon: CupertinoIcons.printer,
                label: "Yazdır",
                onPressed: () async {
                  String url = Ayarlar.teknikservisformu(
                    auth: widget.kullanici.auth,
                    cihazID: cihaz!.id,
                  );
                  if (kIsWeb) {
                    launchUrlString(url);
                  } else {
                    Navigator.of(context).push(
                      MaterialPageRoute(
                        builder: (context) => WebviewPage(url: url),
                      ),
                    );
                  }
                },
              ),
              if (duzenlenebilir())
                _FabItem(
                  tag: "Edit",
                  icon: CupertinoIcons.pen,
                  label: "Düzenle",
                  onPressed: () async {
                    final nav = Navigator.of(context);
                    await _cihaziYenile();
                    nav.push(
                      MaterialPageRoute(
                        builder:
                            (context) => DetayDuzenle(
                              cihaz: cihaz!,
                              cihazlariYenile: () async {
                                await _cihaziYenile();
                              },
                            ),
                      ),
                    );
                  },
                ),
            ];

            return Column(
              mainAxisSize: MainAxisSize.min,
              crossAxisAlignment: CrossAxisAlignment.end,
              children:
                  fabBtns.reversed
                      .map(
                        (f) => Padding(
                          padding: const EdgeInsets.only(bottom: 8),
                          child: FloatingActionButton.small(
                            heroTag: f.tag,
                            onPressed: f.onPressed,
                            tooltip: f.label,
                            child: Icon(
                              f.icon,
                              color:
                                  Theme.of(
                                    context,
                                  ).appBarTheme.iconTheme?.color,
                            ),
                          ),
                        ),
                      )
                      .toList(),
            );
          },
        ),
        bottomNavigationBar: BiltekBottomNavigationBar(
          items: const [
            BottomNavigationBarItem(
              icon: Icon(CupertinoIcons.info),
              label: "Genel",
            ),
            BottomNavigationBarItem(
              icon: Icon(CupertinoIcons.device_laptop),
              label: "Servis",
            ),
            BottomNavigationBarItem(
              icon: Icon(CupertinoIcons.wrench),
              label: "İşlemler",
            ),
            BottomNavigationBarItem(
              icon: Icon(CupertinoIcons.photo),
              label: "Galeri",
            ),
          ],
          selectedItemColor: _accent,
          currentIndex: seciliIndex,
          onTap: (index) {
            if (index == 3) {
              _galeriyiAc();
            } else {
              pageController.animateToPage(
                index,
                duration: const Duration(milliseconds: 400),
                curve: Curves.easeInOut,
              );
              setState(() => seciliIndex = index);
            }
          },
        ),
        body: RefreshIndicator(
          color: _accent,
          onRefresh: () async => await _cihaziYenile(),
          child: PageView(
            controller: pageController,
            onPageChanged: (index) {
              if (index == 3) {
                pageController.jumpToPage(2);
                _galeriyiAc();
              } else {
                setState(() => seciliIndex = index);
              }
            },
            children: [
              _genel(),
              _cihazBilgileri(),
              _islemler(),
              const SizedBox(),
            ],
          ),
        ),
      ),
    );
  }

  Widget _genel() {
    if (cihaz == null) return _yukleniyor();

    return SingleChildScrollView(
      physics: const AlwaysScrollableScrollPhysics(),
      padding: const EdgeInsets.fromLTRB(16, 16, 16, 100),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          SectionCard(
            icon: CupertinoIcons.person_circle_fill,
            title: "Müşteri Bilgileri",
            child: Column(
              children: [
                _InfoTile(label: "Müşteri Adı", value: cihaz!.musteriAdi),
                _InfoTile(label: "Teslim Eden", value: cihaz!.teslimEden),
                _InfoTile(label: "Teslim Alan", value: cihaz!.teslimAlan),
                _InfoTile(label: "Adres", value: cihaz!.adres),
                _divider(),
                Padding(
                  padding: const EdgeInsets.symmetric(vertical: 4),
                  child: Row(
                    children: [
                      Icon(
                        CupertinoIcons.phone,
                        size: 14,
                        color: Colors.grey.shade500,
                      ),
                      const SizedBox(width: 6),
                      Text(
                        "GSM",
                        style: TextStyle(
                          fontSize: 12,
                          color: Colors.grey.shade500,
                          fontWeight: FontWeight.w500,
                        ),
                      ),
                      const Spacer(),
                      SelectableText(
                        cihaz!.telefonNumarasi,
                        style: const TextStyle(
                          fontSize: 14,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                    ],
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.only(top: 8),
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                    children: [
                      _PhoneActionBtn(
                        icon: CupertinoIcons.phone_fill,
                        label: "Ara",
                        color: Colors.green,
                        onTap: _ara,
                      ),
                      if (!kIsWeb)
                        _PhoneActionBtn(
                          icon: CupertinoIcons.person_badge_plus_fill,
                          label: "Kaydet",
                          color: Colors.blue,
                          onTap: _kisiEkle,
                        ),
                      _PhoneActionBtn(
                        iconAsset: BiltekAssets.sms,
                        label: "SMS",
                        color: Colors.orange,
                        onTap: _sms,
                      ),
                      _PhoneActionBtn(
                        iconAsset: BiltekAssets.whatsapp,
                        label: "WhatsApp",
                        color: const Color(0xFF25D366),
                        onTap: _whatsapp,
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
          const SizedBox(height: 12),
          SectionCard(
            icon: CupertinoIcons.doc_text_fill,
            title: "Servis Kimliği",
            child: Column(
              children: [
                _InfoTile(
                  label: "Servis No",
                  value: cihaz!.servisNo.toString(),
                  selectable: true,
                  badge: true,
                ),
                _InfoTile(
                  label: "Takip No",
                  value: cihaz!.takipNumarasi.toString(),
                  selectable: true,
                ),
              ],
            ),
          ),
          const SizedBox(height: 12),
          SectionCard(
            icon: CupertinoIcons.calendar,
            title: "Tarihler",
            child: Column(
              children: [
                _InfoTile(
                  label: "Giriş Tarihi",
                  value: cihaz!.tarih,
                  icon: CupertinoIcons.arrow_down_circle_fill,
                  iconColor: Colors.green,
                ),
                _InfoTile(
                  label: "Çıkış Tarihi",
                  value: cihaz!.cikisTarihi,
                  icon: CupertinoIcons.arrow_up_circle_fill,
                  iconColor: Colors.red,
                ),
                _InfoTile(
                  label: "Bildirim Tarihi",
                  value: cihaz!.bildirimTarihi,
                  icon: CupertinoIcons.bell_fill,
                  iconColor: Colors.amber,
                ),
              ],
            ),
          ),
          const SizedBox(height: 12),
          _StatusCard(
            durum: cihaz!.guncelDurumText,
            renk: cihaz!.guncelDurumRenk,
          ),
        ],
      ),
    );
  }

  Widget _cihazBilgileri() {
    if (cihaz == null) return _yukleniyor();

    return SingleChildScrollView(
      physics: const AlwaysScrollableScrollPhysics(),
      padding: const EdgeInsets.fromLTRB(16, 16, 16, 100),
      child: Column(
        children: [
          SectionCard(
            icon: CupertinoIcons.device_laptop,
            title: "Cihaz",
            child: Column(
              children: [
                _InfoTile(label: "Cihaz Türü", value: cihaz!.cihazTuru),
                _InfoTile(label: "Markası", value: cihaz!.cihaz),
                _InfoTile(label: "Modeli", value: cihaz!.cihazModeli),
                _InfoTile(
                  label: "Seri No",
                  value: cihaz!.seriNo,
                  selectable: true,
                ),
                _InfoTile(
                  label: "Teslim Alınanlar",
                  value: cihaz!.teslimAlinanlar,
                ),
              ],
            ),
          ),
          const SizedBox(height: 12),
          SectionCard(
            icon: CupertinoIcons.lock_fill,
            title: "Cihaz Şifresi",
            child:
                cihaz!.cihazDeseni.isNotEmpty
                    ? SizedBox(
                      height: 200,
                      child: Desen(
                        initDesen: Islemler.desenDonusturFlutter(
                          cihaz!.cihazDeseni,
                        ),
                        duzenlenebilir: false,
                        pointRadius: 8,
                        showInput: true,
                        dimension: 3,
                        relativePadding: 0.7,
                        selectThreshold: 25,
                        fillPoints: true,
                        onInputComplete: (list) {},
                      ),
                    )
                    : Padding(
                      padding: const EdgeInsets.symmetric(vertical: 4),
                      child: Row(
                        children: [
                          const Icon(
                            CupertinoIcons.lock_open_fill,
                            size: 16,
                            color: Colors.amber,
                          ),
                          const SizedBox(width: 8),
                          Text(
                            cihaz!.cihazSifresi.isEmpty
                                ? "Belirtilmemiş"
                                : cihaz!.cihazSifresi,
                            style: const TextStyle(
                              fontSize: 14,
                              fontWeight: FontWeight.w500,
                              letterSpacing: 1.5,
                            ),
                          ),
                        ],
                      ),
                    ),
          ),
        ],
      ),
    );
  }

  Widget _islemler() {
    if (cihaz == null) return _yukleniyor();

    return SingleChildScrollView(
      physics: const AlwaysScrollableScrollPhysics(),
      padding: const EdgeInsets.fromLTRB(16, 16, 16, 100),
      child: Column(
        children: [
          SectionCard(
            icon: CupertinoIcons.exclamationmark_triangle_fill,
            title: "Hasar & Arıza",
            iconColor: Colors.orange,
            child: Column(
              children: [
                _InfoTile(
                  label: "Hasar Tespiti",
                  value: cihaz!.hasarTespiti,
                  multiline: true,
                ),
                _InfoTile(
                  label: "Arıza Açıklaması",
                  value: cihaz!.arizaAciklamasi,
                  multiline: true,
                ),
              ],
            ),
          ),
          const SizedBox(height: 12),
          SectionCard(
            icon: CupertinoIcons.wrench_fill,
            title: "Servis Detayları",
            child: Column(
              children: [
                _InfoTile(
                  label: "Servis Türü",
                  value: Islemler.servisTuru(cihaz!.servisTuru),
                ),
                _InfoTile(
                  label: "Yedek Alınacak mı?",
                  value:
                      cihaz!.yedekDurumu == 1
                          ? "Evet"
                          : (cihaz!.yedekDurumu == 0
                              ? "Hayır"
                              : "Belirtilmemiş"),
                  icon:
                      cihaz!.yedekDurumu == 1
                          ? CupertinoIcons.checkmark_circle_fill
                          : CupertinoIcons.xmark_circle_fill,
                  iconColor:
                      cihaz!.yedekDurumu == 1 ? Colors.green : Colors.red,
                ),
                _InfoTile(label: "Güncel Durum", value: cihaz!.guncelDurumText),
                _InfoTile(
                  label: "Bildirim Tarihi",
                  value: cihaz!.bildirimTarihi,
                ),
                _InfoTile(
                  label: "Sorumlu Personel",
                  value: cihaz!.sorumlu,
                  icon: CupertinoIcons.person_fill,
                ),
                _InfoTile(
                  label: "Yapılan İşlem",
                  value: cihaz!.yapilanIslemAciklamasi,
                  multiline: true,
                ),
                _InfoTile(
                  label: "Notlar",
                  value: cihaz!.notlar,
                  multiline: true,
                ),
              ],
            ),
          ),
          const SizedBox(height: 12),
          Islemler.liste(cihaz!.islemler, maliyetGosterButon: true),
          const SizedBox(height: 12),
          SectionCard(
            icon: CupertinoIcons.creditcard_fill,
            title: "Ödeme",
            iconColor: Colors.greenAccent,
            child: Column(
              children: [
                _InfoTile(label: "Tahsilat Şekli", value: cihaz!.tahsilatSekli),
                _InfoTile(
                  label: "Fatura Durumu",
                  value: Islemler.faturaDurumu(cihaz!.faturaDurumu),
                ),
                _InfoTile(
                  label: "Fiş No",
                  value: cihaz!.fisNo,
                  selectable: true,
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _yukleniyor() =>
      const Center(child: CircularProgressIndicator(color: _accent));

  Widget _divider() =>
      Divider(height: 16, thickness: 0.5, color: Colors.grey.withAlpha(80));

  Future<void> _cihaziYenile() async {
    _yukleniyorGoster();
    Cihaz? cihazTemp = await BiltekPost.cihazGetir(no: widget.no);
    if (mounted) {
      setState(() => cihaz = cihazTemp);
    } else {
      cihaz = cihazTemp;
    }

    if (cihaz == null) {
      if (mounted) {
        showDialog(
          context: context,
          builder:
              (context) => AlertDialog(
                title: const Text("Cihaz Bulunamadı"),
                content: const Text("Cihaz bulunamadı. Silinmiş olabilir."),
                actions: [
                  TextButton(
                    onPressed: () {
                      Navigator.pop(context);
                      Navigator.pop(context);
                    },
                    child: const Text("Geri"),
                  ),
                ],
              ),
        );
      }
      return;
    }
    setState(() => detaylarYukleniyor = false);
    _yukleniyorGizle();
  }

  Future<void> _ara() async {
    final t = telefonNumarasi();
    if (telefonGecerli(t)) {
      launchUrlString("tel://$t");
    } else {
      _gecersizTelefonDialog();
    }
  }

  void kisiIzniUyari() {
    showDialog(
      context: context,
      builder:
          (context) => AlertDialog(
            title: const Text("Kişi İzni Reddedildi"),
            content: const Text(
              "Kişiler izni reddedilmiş. Bu işleme devam edebilmek için izin vermelisiniz. Ayarlardan izin verebilirsiniz.",
            ),
            actions: [
              TextButton(
                onPressed: () {
                  Navigator.pop(context);
                  openAppSettings();
                },
                child: const Text("Ayarları Aç"),
              ),
              TextButton(
                onPressed: () => Navigator.pop(context),
                child: const Text("İptal"),
              ),
            ],
          ),
    );
  }

  bool yukleniyorGosterildi = false;
  void _yukleniyorGoster() {
    if (!yukleniyorGosterildi) {
      setState(() => yukleniyorGosterildi = true);
      yukleniyor(context);
    }
  }

  void _yukleniyorGizle() {
    if (yukleniyorGosterildi) {
      setState(() => yukleniyorGosterildi = false);
      Navigator.pop(context);
    }
  }

  Future<void> _kisiEkle() async {
    final t = telefonNumarasi();
    if (!telefonGecerli(t)) {
      _gecersizTelefonDialog();
      return;
    }
    if (await Permission.contacts.isPermanentlyDenied) {
      kisiIzniUyari();
      return;
    }
    if (await Permission.contacts.request().isGranted) {
      if (!mounted) return;
      final isimC = TextEditingController(text: cihaz!.musteriAdi);
      final telC = TextEditingController(text: t);
      showModalBottomSheet(
        context: context,
        constraints: const BoxConstraints(minWidth: double.infinity),
        builder:
            (ctx) => SafeArea(
              child: Padding(
                padding: const EdgeInsets.all(16),
                child: Column(
                  mainAxisSize: MainAxisSize.min,
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    const Text(
                      "Rehbere Ekle",
                      style: TextStyle(
                        fontSize: 20,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                    const SizedBox(height: 12),
                    BiltekTextField(label: "İsim", controller: isimC),
                    const SizedBox(height: 8),
                    BiltekTextField(
                      label: "Telefon Numarası",
                      controller: telC,
                    ),
                    const SizedBox(height: 8),
                    Row(
                      mainAxisAlignment: MainAxisAlignment.end,
                      children: [
                        TextButton(
                          onPressed: () {
                            Navigator.pop(ctx);
                            try {
                              FlutterContacts.create(
                                Contact(
                                  phones: [Phone(number: telC.text)],
                                  name: Name(first: isimC.text),
                                ),
                              );
                              showNotification(body: "Müşteri kaydedildi.");
                            } catch (e) {
                              showNotification(
                                body: "Müşteri kaydedilirken bir hata oluştu.",
                              );
                            }
                          },
                          child: const Text("Kaydet"),
                        ),
                        TextButton(
                          onPressed: () {
                            Navigator.pop(ctx);
                            showNotification(
                              body: "Müşteri kaydetme iptal edildi.",
                            );
                          },
                          child: const Text("İptal"),
                        ),
                      ],
                    ),
                  ],
                ),
              ),
            ),
      );
    } else {
      kisiIzniUyari();
    }
  }

  Future<void> _sms() async {
    final t = telefonNumarasi();
    if (telefonGecerli(t)) {
      launchUrlString("sms:$t");
    } else {
      _gecersizTelefonDialog();
    }
  }

  Future<void> _whatsapp() async {
    final t = telefonNumarasi();
    if (telefonGecerli(t)) {
      launchUrlString("https://wa.me/$t");
    } else {
      _gecersizTelefonDialog();
    }
  }

  void _gecersizTelefonDialog() {
    showDialog(
      context: context,
      builder:
          (context) => AlertDialog(
            title: const Text("Geçersiz Telefon"),
            content: const Text("Telefon numarası geçersiz"),
            actions: [
              TextButton(
                onPressed: () => Navigator.pop(context),
                child: const Text("Kapat"),
              ),
            ],
          ),
    );
  }

  String telefonNumarasi() {
    if (cihaz != null) return Islemler.telNo(cihaz!.telefonNumarasi);
    return "";
  }

  bool telefonGecerli(String t) => t.isNotEmpty && t != "+90" && t != "+9";

  Future<void> _cihazDuzenlemeGetir() async {
    final tmp = await BiltekPost.cihazDuzenlemeGetir();
    setState(() => cihazDuzenleme = tmp);
  }

  bool duzenlenebilir() {
    return cihaz != null &&
        cihazDuzenleme.cihazDurumlari.indexWhere(
              (e) => e.id == cihaz!.guncelDurum && e.kilitle,
            ) <
            0;
  }

  void _galeriyiAc() {
    Navigator.of(context).push(
      MaterialPageRoute(
        builder:
            (context) => DetaylarGaleri(
              duzenle: duzenlenebilir(),
              id: cihaz!.id,
              servisNo: cihaz!.servisNo,
            ),
      ),
    );
  }
}

class _InfoTile extends StatelessWidget {
  const _InfoTile({
    required this.label,
    required this.value,
    this.icon,
    this.iconColor,
    this.selectable = false,
    this.badge = false,
    this.multiline = false,
  });

  final String label;
  final String value;
  final IconData? icon;
  final Color? iconColor;
  final bool selectable;
  final bool badge;
  final bool multiline;

  @override
  Widget build(BuildContext context) {
    final empty = value.trim().isEmpty;
    final displayValue = empty ? "—" : value;

    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 5),
      child:
          multiline
              ? Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  _labelWidget(),
                  const SizedBox(height: 3),
                  Text(
                    displayValue,
                    style: TextStyle(
                      fontSize: 14,
                      color: empty ? Colors.grey : null,
                    ),
                  ),
                  Divider(
                    height: 12,
                    thickness: 0.4,
                    color: Colors.grey.withAlpha(80),
                  ),
                ],
              )
              : Row(
                crossAxisAlignment: CrossAxisAlignment.center,
                children: [
                  if (icon != null) ...[
                    Icon(icon, size: 14, color: iconColor ?? Colors.grey),
                    const SizedBox(width: 4),
                  ],
                  _labelWidget(),
                  const Spacer(),
                  if (badge)
                    Container(
                      padding: const EdgeInsets.symmetric(
                        horizontal: 10,
                        vertical: 3,
                      ),
                      decoration: BoxDecoration(
                        color: Colors.greenAccent.withAlpha(30),
                        borderRadius: BorderRadius.circular(20),
                        border: Border.all(
                          color: Colors.greenAccent.withAlpha(100),
                        ),
                      ),
                      child: SelectableText(
                        displayValue,
                        style: const TextStyle(
                          fontSize: 13,
                          fontWeight: FontWeight.bold,
                          color: Colors.greenAccent,
                        ),
                      ),
                    )
                  else if (selectable)
                    SelectableText(
                      displayValue,
                      style: TextStyle(
                        fontSize: 14,
                        color: empty ? Colors.grey : null,
                      ),
                    )
                  else
                    Flexible(
                      child: Text(
                        displayValue,
                        textAlign: TextAlign.end,
                        style: TextStyle(
                          fontSize: 14,
                          color: empty ? Colors.grey : null,
                        ),
                      ),
                    ),
                ],
              ),
    );
  }

  Widget _labelWidget() => Text(
    label,
    style: TextStyle(
      fontSize: 12,
      color: Colors.grey.shade500,
      fontWeight: FontWeight.w500,
    ),
  );
}

class _StatusCard extends StatelessWidget {
  const _StatusCard({required this.durum, required this.renk});
  final String durum;
  final String renk;

  @override
  Widget build(BuildContext context) {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(16),
        color: Islemler.arkaRenk(renk)?.withValues(alpha: 0.7),
        border: Border.all(color: Colors.greenAccent.withAlpha(80)),
      ),
      child: Row(
        children: [
          Container(
            width: 13,
            height: 13,
            decoration: BoxDecoration(
              color: Islemler.arkaRenk(renk),
              shape: BoxShape.circle,
              border: Border.all(color: Colors.black),
            ),
          ),
          const SizedBox(width: 10),
          Text(
            durum.isEmpty ? "—" : durum,
            style: TextStyle(
              fontWeight: FontWeight.bold,
              fontSize: 15,
              color: Islemler.yaziRengi(renk),
            ),
          ),
        ],
      ),
    );
  }
}

class _PhoneActionBtn extends StatelessWidget {
  const _PhoneActionBtn({
    this.icon,
    this.iconAsset,
    required this.label,
    required this.color,
    required this.onTap,
  }) : assert(icon != null || iconAsset != null);

  final IconData? icon;
  final String? iconAsset;
  final String label;
  final Color color;
  final VoidCallback onTap;

  @override
  Widget build(BuildContext context) {
    return InkWell(
      borderRadius: BorderRadius.circular(12),
      onTap: onTap,
      child: Container(
        padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 8),
        decoration: BoxDecoration(
          color: color.withAlpha(30),
          borderRadius: BorderRadius.circular(12),
          border: Border.all(color: color.withAlpha(80)),
        ),
        child: Column(
          children: [
            if (icon != null)
              Icon(icon, size: 20, color: color)
            else
              Image.asset(iconAsset!, width: 20, height: 20),
            const SizedBox(height: 3),
            Text(
              label,
              style: TextStyle(
                fontSize: 10,
                color: color,
                fontWeight: FontWeight.w600,
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class _FabItem {
  const _FabItem({
    required this.tag,
    required this.icon,
    required this.label,
    required this.onPressed,
  });
  final String tag;
  final IconData icon;
  final String label;
  final VoidCallback onPressed;
}
