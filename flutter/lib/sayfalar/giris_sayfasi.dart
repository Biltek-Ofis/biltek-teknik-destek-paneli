import 'dart:async';
import 'dart:convert';

import 'package:app_links/app_links.dart';
import 'package:biltekteknikservis/sayfalar/cihazlar.dart';
import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:local_auth/local_auth.dart';
import 'package:local_auth_android/local_auth_android.dart';
import 'package:local_auth_darwin/local_auth_darwin.dart';
import 'package:provider/provider.dart';

import '../ayarlar.dart';
import '../models/giris.dart';
import '../utils/alerts.dart';
import '../utils/assets.dart';
import '../utils/buttons.dart';
import '../utils/islemler.dart';
import '../utils/my_notifier.dart';
import '../utils/post.dart';
import '../utils/shared_preferences.dart';
import '../widgets/dizayn.dart';
import '../widgets/input.dart';
import 'anasayfa.dart';
import 'cihaz_durumu/cihaz_durumu_giris.dart';

class GirisSayfasi extends StatefulWidget {
  const GirisSayfasi({super.key, this.spKullanici});

  final SPKullanici? spKullanici;

  @override
  State<GirisSayfasi> createState() => _GirisSayfasiState();
}

class _GirisSayfasiState extends State<GirisSayfasi>
    with SingleTickerProviderStateMixin {
  CihazNo? cihazNoCls;
  StreamSubscription? _deepLinkSubscription;

  final TextEditingController _kullaniciAdiCtrl = TextEditingController();
  final TextEditingController _sifreCtrl = TextEditingController();
  final FocusNode _kullaniciAdiFocus = FocusNode();
  final FocusNode _sifreFocus = FocusNode();

  bool _beniHatirla = true;
  bool _yukleniyor = false;
  bool _canAuthBio = false;

  String? _kullaniciAdiError;
  String? _sifreError;
  String _hataMesaji = "";

  final LocalAuthentication _localAuth = LocalAuthentication();

  late final AnimationController _fadeCtrl;
  late final Animation<double> _fadeAnim;

  static const _accent = Color(0xFF00E676);
  static const _textSub = Color(0xFF6B7080);

  @override
  void initState() {
    super.initState();

    _fadeCtrl = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 900),
    );
    _fadeAnim = CurvedAnimation(parent: _fadeCtrl, curve: Curves.easeOut);

    Future.delayed(Duration.zero, () async {
      if (mounted) {
        cihazNoCls = CihazNo.of(context);
        await _initDeepLinks();
      }
      if (widget.spKullanici != null) {
        final sp = widget.spKullanici!..sifreyiCoz();
        _kullaniciAdiCtrl.text = sp.kullaniciAdi;
        if (sp.sifre.isNotEmpty && !kIsWeb) {
          final canBio = await _localAuth.canCheckBiometrics;
          _canAuthBio = canBio || await _localAuth.isDeviceSupported();
        }
      }
      final hatirla =
          await SharedPreference.getBool(SharedPreference.beniHatirlaString) ??
          true;
      if (mounted) {
        setState(() => _beniHatirla = hatirla);

        if (widget.spKullanici == null) {
          FocusScope.of(context).requestFocus(_kullaniciAdiFocus);
        } else if (!_canAuthBio) {
          FocusScope.of(context).requestFocus(_sifreFocus);
        }

        final alerts = Alerts.of(context);
        if (await BiltekPost.guncellemeGerekli()) alerts.guncelleme();
      }
      _fadeCtrl.forward();
    });
  }

  @override
  void dispose() {
    _deepLinkSubscription?.cancel();
    _fadeCtrl.dispose();
    _kullaniciAdiCtrl.dispose();
    _sifreCtrl.dispose();
    _kullaniciAdiFocus.dispose();
    _sifreFocus.dispose();
    super.dispose();
  }

  // ══════════════════════════════════════════════════════════════════════════
  // BUILD
  // ══════════════════════════════════════════════════════════════════════════
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      resizeToAvoidBottomInset: false,
      body: SafeArea(
        child: Consumer<MyNotifier>(
          builder: (ctx, notifier, _) {
            return SafeArea(
              child: Center(
                child: SingleChildScrollView(
                  padding: const EdgeInsets.symmetric(
                    horizontal: 28,
                    vertical: 32,
                  ),
                  child: FadeTransition(
                    opacity: _fadeAnim,
                    child: ConstrainedBox(
                      constraints: const BoxConstraints(maxWidth: 420),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          _buildHeader(),
                          const SizedBox(height: 40),
                          _buildForm(notifier),
                          const SizedBox(height: 28),
                          _buildActions(notifier),
                        ],
                      ),
                    ),
                  ),
                ),
              ),
            );
          },
        ),
      ),
    );
  }

  Widget _buildHeader() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Image.asset(
          BiltekAssets.logo,
          width: MediaQuery.of(context).size.width,
          height: 100,
        ),
        const SizedBox(height: 24),
        Container(width: 32, height: 2, color: _accent),
        const SizedBox(height: 14),
        Container(
          width: MediaQuery.of(context).size.width,
          alignment: Alignment.center,
          child: Column(
            children: [
              const Text(
                "Teknik servis paneline hoş geldiniz.",
                style: TextStyle(fontSize: 13, color: _textSub),
              ),
            ],
          ),
        ),
        if (_hataMesaji.isNotEmpty) ...[
          const SizedBox(height: 14),
          ErrorBanner(message: _hataMesaji),
        ],
      ],
    );
  }

  Widget _buildForm(MyNotifier notifier) {
    return AutofillGroup(
      child: Column(
        children: [
          BiltekTextField(
            controller: _kullaniciAdiCtrl,
            currentFocus: _kullaniciAdiFocus,
            nextFocus: _sifreFocus,
            label: "Kullanıcı Adı",
            prefixIcon: Icons.person_outline_rounded,
            autofillHints: const [AutofillHints.username],
            errorText: _kullaniciAdiError,
            textInputAction: TextInputAction.next,
            onChanged:
                (_) => setState(() {
                  _kullaniciAdiError = null;
                  _hataMesaji = "";
                }),
            onEditingComplete:
                () => FocusScope.of(context).requestFocus(_sifreFocus),
          ),
          const SizedBox(height: 16),
          BiltekSifre(
            controller: _sifreCtrl,
            currentFocus: _sifreFocus,
            label: "Şifre",
            prefixIcon: Icons.lock_outline_rounded,
            autofillHints: const [AutofillHints.password],
            errorText: _sifreError,
            textInputAction: TextInputAction.done,
            onChanged:
                (_) => setState(() {
                  _sifreError = null;
                  _hataMesaji = "";
                }),
            onSubmitted: (_) async {
              TextInput.finishAutofillContext();
              await _girisYap(notifier);
            },
            onEditingComplete: () => TextInput.finishAutofillContext(),
          ),
          const SizedBox(height: 14),
          GestureDetector(
            onTap: () => setState(() => _beniHatirla = !_beniHatirla),
            child: Row(
              children: [
                AnimatedCheckbox(
                  value: _beniHatirla,
                  onChanged: (v) => setState(() => _beniHatirla = v),
                ),
                const SizedBox(width: 10),
                const Text(
                  "Beni Hatırla",
                  style: TextStyle(color: _textSub, fontSize: 13),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildActions(MyNotifier notifier) {
    return Column(
      children: [
        PrimaryButton(
          label: "Giriş Yap",
          loading: _yukleniyor,
          onPressed: () async => await _girisYap(notifier),
        ),
        if (_canAuthBio && widget.spKullanici != null) ...[
          const SizedBox(height: 10),
          SecondaryButton(
            label: "Biyometrik Giriş",
            icon: Icons.fingerprint_rounded,
            onPressed: () => _biyometricGiris(notifier),
          ),
        ],
        const SizedBox(height: 10),
        PrimaryButton(
          backgroundColor: const Color(0xFF00E676),
          label: "Cihaz Durumunu Görüntüle",
          icon: Icons.search_rounded,
          onPressed:
              () => Navigator.of(
                context,
              ).push(MaterialPageRoute(builder: (_) => CihazDurumuGiris())),
        ),
      ],
    );
  }

  Future<void> _girisYap(MyNotifier? myNotifier) async {
    setState(() {
      _kullaniciAdiError = null;
      _sifreError = null;
      _hataMesaji = "";
      _yukleniyor = true;
    });

    final nav = Navigator.of(context);
    bool kapatildi = false;
    final kullaniciAdi = _kullaniciAdiCtrl.text;
    final sifre = _sifreCtrl.text;

    if (kullaniciAdi.isEmpty && sifre.isEmpty) {
      setState(() {
        _kullaniciAdiError = "Kullanıcı Adı boş olamaz!";
        _sifreError = "Şifre boş olamaz!";
        _yukleniyor = false;
      });
      return;
    }
    if (kullaniciAdi.isEmpty) {
      setState(() {
        _kullaniciAdiError = "Kullanıcı Adı boş olamaz!";
        _yukleniyor = false;
      });
      return;
    }
    if (sifre.isEmpty) {
      setState(() {
        _sifreError = "Şifre boş olamaz!";
        _yukleniyor = false;
      });
      return;
    }

    final cihazID = await Islemler.getId();
    if (cihazID == null) {
      setState(() {
        _hataMesaji = "Uygulama şuanda bu platformda desteklenmiyor.";
        _yukleniyor = false;
      });
      return;
    }

    final postData = <String, String>{
      "kullaniciAdi": kullaniciAdi,
      "sifre": sifre,
      "cihazID": cihazID,
    };
    final fcmToken = await SharedPreference.getString(
      SharedPreference.fcmTokenString,
    );
    if (fcmToken != null) postData["fcmToken"] = fcmToken;

    final response = await BiltekPost.post(Ayarlar.girisYap, postData);

    if (response.statusCode == 201) {
      final resp = await response.stream.bytesToString();
      try {
        final girisDurumu = GirisDurumu.fromJson(
          jsonDecode(resp) as Map<String, dynamic>,
        );
        if (girisDurumu.durum && girisDurumu.auth.isNotEmpty) {
          await SharedPreference.setString(
            SharedPreference.authString,
            girisDurumu.auth,
          );
          final kullaniciModel = await BiltekPost.kullaniciGetir(
            girisDurumu.auth,
          );
          if (kullaniciModel != null) {
            kapatildi = true;
            if (myNotifier != null) {
              myNotifier.kullanici =
                  _beniHatirla
                      ? SPKullanici.create(
                        isim: kullaniciModel.adSoyad,
                        kullaniciAdi: kullaniciAdi,
                        sifre: sifre,
                      )
                      : null;
            }
            await SharedPreference.setBool(
              SharedPreference.beniHatirlaString,
              _beniHatirla,
            );
            nav.pushAndRemoveUntil(
              MaterialPageRoute(
                builder:
                    (_) => Anasayfa(
                      sayfa:
                          kullaniciModel.musteri
                              ? "cagri"
                              : (kullaniciModel.teknikservis
                                  ? "cihazlarim"
                                  : "anasayfa"),
                      kullanici: kullaniciModel,
                    ),
              ),
              (_) => false,
            );
          } else {
            setState(
              () =>
                  _hataMesaji =
                      "Bir hata oluştu. Lütfen daha sonra tekrar deneyin.",
            );
          }
        } else {
          setState(() => _hataMesaji = "Kullanıcı adı veya şifre yanlış.");
        }
      } on Exception {
        try {
          final hata = HataDurumu.fromJson(
            jsonDecode(resp) as Map<String, dynamic>,
          );
          setState(() => _hataMesaji = hata.mesaj);
        } on Exception {
          setState(
            () =>
                _hataMesaji =
                    "Bir hata oluştu. Lütfen daha sonra tekrar deneyin.",
          );
        }
      }
    } else {
      setState(
        () =>
            _hataMesaji = "Bir hata oluştu. Lütfen daha sonra tekrar deneyin.",
      );
    }

    if (!kapatildi) setState(() => _yukleniyor = false);
  }

  Future<void> _biyometricGiris(MyNotifier? myNotifier) async {
    try {
      final canBio = await _localAuth.canCheckBiometrics;
      final canAuth = canBio || await _localAuth.isDeviceSupported();
      if (canAuth) {
        final ok = await _localAuth.authenticate(
          localizedReason:
              'Daha önce giriş yapılmış bir hesabınız bulunuyor. Biyometrik kimliğinizi doğrulayarak tekrar giriş yapabilirsiniz.',
          authMessages: const <AuthMessages>[
            AndroidAuthMessages(
              signInTitle: 'Biyometrik Doğrulama ile Giriş Yapın',
              cancelButton: 'Hayır Teşekkürler',
            ),
            IOSAuthMessages(cancelButton: 'Hayır Teşekkürler'),
          ],
        );
        if (ok) {
          _sifreCtrl.text = widget.spKullanici!.sifre;
          if (myNotifier != null && !_beniHatirla) {
            myNotifier.kullanici = null;
          }
          await _girisYap(null);
        }
      }
    } on LocalAuthException catch (e) {
      debugPrint("LocalAuth Hatası.\n${e.description}");
    }
  }

  Future<void> _initDeepLinks() async {
    try {
      final appLinks = AppLinks();
      _deepLinkSubscription = appLinks.uriLinkStream.listen((uri) {
        cihazNoCls?.qrAcMusteri(qr: uri.toString());
      });
    } on PlatformException catch (e) {
      debugPrint("Deep link hatası: $e");
    }
  }
}
