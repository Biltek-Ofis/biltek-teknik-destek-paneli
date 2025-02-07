import 'dart:typed_data';

import 'package:flutter/material.dart';
import 'package:pro_image_editor/pro_image_editor.dart';

typedef ImageEditingCompleteCallback = Future<void> Function(Uint8List bytes);

class ResimDuzenle extends StatefulWidget {
  const ResimDuzenle({
    super.key,
    required this.resim,
    required this.onEditComplete,
  });
  final Uint8List resim;
  final ImageEditingCompleteCallback onEditComplete;

  @override
  State<ResimDuzenle> createState() => _ResimDuzenleState();
}

class _ResimDuzenleState extends State<ResimDuzenle> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SizedBox(
        width: MediaQuery.of(context).size.width,
        height: MediaQuery.of(context).size.height,
        child: ProImageEditor.memory(
          widget.resim,
          callbacks: ProImageEditorCallbacks(
            onImageEditingComplete: (bytes) async {
              widget.onEditComplete.call(bytes);
            },
          ),
          configs: ProImageEditorConfigs(
            i18n: I18n(
              layerInteraction: I18nLayerInteraction(
                remove: "Sil",
                edit: "Düzenle",
                rotateScale: "Çevir ve Yeniden Boyutlandır",
              ),
              paintEditor: I18nPaintEditor(
                moveAndZoom: "Yakınlatır",
                bottomNavigationBarText: "Çiz",
                freestyle: "Serbest",
                arrow: "Ok",
                line: "Çizgi",
                rectangle: "Kare",
                circle: "Daire",
                dashLine: "Kesik Çizgi",
                lineWidth: "Çizgi Boyutu",
                eraser: "Silgi",
                toggleFill: "Doldurmayı Aç/Kapat",
                changeOpacity: "Opaklığı Değiştir",
                undo: "Geri AL",
                redo: "İleri Al",
                done: "Bitti",
                back: "Geri",
                smallScreenMoreTooltip: "Daha Fazla",
              ),
              textEditor: I18nTextEditor(
                inputHintText: "Yazı Girin",
                bottomNavigationBarText: "Yazı",
                back: "Back",
                done: "Bitti",
                textAlign: "Yazıyı Hizala",
                fontScale: "Font Boyutu",
                backgroundMode: "Arkaplan Modu",
                smallScreenMoreTooltip: "Daha Fazla",
              ),
              cropRotateEditor: I18nCropRotateEditor(
                bottomNavigationBarText: "Kıpr / Döndür",
                rotate: "Döndür",
                flip: "Çevir",
                ratio: "Oran",
                back: "Geri",
                done: "Bitti",
                cancel: "İptal",
                undo: "Geri Al",
                redo: "İleri Al",
                smallScreenMoreTooltip: "Daha Fazla",
                reset: "Sıfırla",
              ),
              tuneEditor: I18nTuneEditor(
                bottomNavigationBarText: "Tonlar",
                back: "Geri",
                done: "Bitti",
                brightness: "Parlaklık",
                contrast: "Kontrast",
                saturation: "Saturasyon",
                exposure: "Exposure",
                hue: "Hue",
                temperature: "Sıcaklık",
                sharpness: "Keskinlik",
                fade: "Fade",
                luminance: "Luminance",
                undo: "Geri Al",
                redo: "İleri Al",
              ),
              filterEditor: I18nFilterEditor(
                bottomNavigationBarText: "Filtre",
                back: "Geri",
                done: "Bitti",
                filters: const I18nFilters(
                  none: "Filtre Yok",
                  addictiveBlue: "AddictiveBlue",
                  addictiveRed: "AddictiveRed",
                  aden: "Aden",
                  amaro: "Amaro",
                  ashby: "Ashby",
                  brannan: "Brannan",
                  brooklyn: "Brooklyn",
                  charmes: "Charmes",
                  clarendon: "Clarendon",
                  crema: "Crema",
                  dogpatch: "Dogpatch",
                  earlybird: "Earlybird",
                  f1977: "1977",
                  gingham: "Gingham",
                  ginza: "Ginza",
                  hefe: "Hefe",
                  helena: "Helena",
                  hudson: "Hudson",
                  inkwell: "Inkwell",
                  juno: "Juno",
                  kelvin: "Kelvin",
                  lark: "Lark",
                  loFi: "Lo-Fi",
                  ludwig: "Ludwig",
                  maven: "Maven",
                  mayfair: "Mayfair",
                  moon: "Moon",
                  nashville: "Nashville",
                  perpetua: "Perpetua",
                  reyes: "Reyes",
                  rise: "Rise",
                  sierra: "Sierra",
                  skyline: "Skyline",
                  slumber: "Slumber",
                  stinson: "Stinson",
                  sutro: "Sutro",
                  toaster: "Toaster",
                  valencia: "Valencia",
                  vesper: "Vesper",
                  walden: "Walden",
                  willow: "Willow",
                  xProII: "X-Pro II",
                ),
              ),
              blurEditor: I18nBlurEditor(
                bottomNavigationBarText: "Bulanıklık",
                back: "Geri",
                done: "Bitti",
              ),
              emojiEditor: I18nEmojiEditor(
                bottomNavigationBarText: "Emoji",
                search: "Ara",
                categoryRecent: "Sık Kullanılan",
                categorySmileys: "Gülümseme & İnsan",
                categoryAnimals: "Hayvan & Doğa",
                categoryFood: "Yiyecek & İçecek",
                categoryActivities: "Aktiviteler",
                categoryTravel: "Yolculuk & Mekanlar",
                categoryObjects: "Eşyalar",
                categorySymbols: "Semboller",
                categoryFlags: "Bayraklar",
              ),
              stickerEditor: I18nStickerEditor(
                bottomNavigationBarText: "Çıkartmalar",
              ),
              various: I18nVarious(
                loadingDialogMsg: "Lütfen bekleyin...",
                closeEditorWarningTitle: "Resim düzenlemeyi iptal et?",
                closeEditorWarningMessage:
                    "Resim düzenlemeyin kapatmak istediğine emin misin? Resim kaydedilmeyecek",
                closeEditorWarningConfirmBtn: "Çık",
                closeEditorWarningCancelBtn: "İptal",
              ),
              importStateHistoryMsg: "Düzenleyiciyi Başlat",
              cancel: "İptal",
              undo: "Geri Al",
              redo: "İleri Al",
              done: "Bitti",
              remove: "Sil",
              doneLoadingMsg: "Değişiklikler kaydediliyor.",
            ),
          ),
        ),
      ),
    );
  }
}
