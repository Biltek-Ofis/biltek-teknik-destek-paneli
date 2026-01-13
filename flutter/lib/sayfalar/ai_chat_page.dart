import 'dart:convert';

import 'package:biltekteknikservis/models/ai_chat.dart';
import 'package:biltekteknikservis/models/ai_resp.dart';
import 'package:biltekteknikservis/models/kullanici.dart';
import 'package:biltekteknikservis/widgets/input.dart';
import 'package:firebase_ai/firebase_ai.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import 'package:markdown_widget/markdown_widget.dart';
import 'package:speech_to_text/speech_to_text.dart' as stt;

import '../models/cihaz.dart';
import '../utils/alerts.dart';
import '../utils/assets.dart';
import '../utils/firebase.dart';
import '../utils/islemler.dart';
import '../utils/post.dart';
import '../utils/shared_preferences.dart';
import 'detaylar/detaylar.dart';

class AIChatPage extends StatefulWidget {
  const AIChatPage({super.key, required this.kullanici});

  final KullaniciAuthModel kullanici;

  @override
  State<AIChatPage> createState() => _AIChatPageState();
}

class _AIChatPageState extends State<AIChatPage> {
  List<AiChatModel> aiChatList = [];
  List<Content> aiChatHistory = [];
  TextEditingController mesajController = TextEditingController();
  String? mesajError;
  bool mesajReadOnly = false;
  bool botYaziyor = false;

  Map<String, AiChatModel> seciliMesajlar = {};

  ScrollController scrollController = ScrollController();

  Content yzPrompt = Content('user', [
    TextPart(
      "Senin adın Biltek Yapay Zeka. Biltek'in yapay zeka destekli asistanısın. Bilgisayar, telefon, yazıcı hakkındaki sorular, hatalar konusunda yardımcı olabilirsin.",
    ),
    TextPart("Sana sorulan sorulara net, kısa ve anlaşılır cevaplar ver."),
    TextPart(
      'Sana şu kişinin cihazlarını göster ve benzeri bir şey denildiğinde bir json formatında cevap ver. Mesela ahmetin cihazlarını göster denildiğinde cevabın şu şekilde olsun: { "type":"cihazAra","query":"ahmet"}',
    ),
  ]);

  stt.SpeechToText speech = stt.SpeechToText();
  bool sttAvailable = false;
  bool dinliyor = false;

  @override
  initState() {
    super.initState();
    Future.delayed(const Duration(seconds: 1), () async {
      _yukleniyorGoster();
      final aiChatHistoryString = await SharedPreference.getStringList(
        'ai_chat_history',
      );
      aiChatList =
          aiChatHistoryString
              .map((e) => AiChatModel.fromJson(jsonDecode(e)))
              .toList();
      aiChatHistory = _aiChatHistory(aiChatList);
      bool available = await speech.initialize(
        onStatus: (status) {
          debugPrint("SpeechToText Status: $status");
          if (status == stt.SpeechToText.listeningStatus) {
            mesajError = null;
            dinliyor = true;
          } else if (status == stt.SpeechToText.notListeningStatus) {
            dinliyor = false;
          }
          setState(() {});
        },
        onError: (error) {
          debugPrint("SpeechToText Error: ${error.errorMsg}");
          setState(() {
            mesajError = "Sesli mesaj dinleme hatası: Lütfen tekrar deneyin.";
            dinliyor = false;
          });
        },
      );
      sttAvailable = available;
      setState(() {});
      _altaKaydir();
      _yukleniyorGizle();
    });
  }

  @override
  dispose() {
    mesajController.dispose();
    scrollController.dispose();
    speech.stop();
    speech.cancel();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Biltek Yapay Zeka'),
        actions: [
          if (seciliMesajlar.isNotEmpty)
            IconButton(
              icon: const Icon(CupertinoIcons.delete),
              onPressed: () {
                showDialog(
                  context: context,
                  builder: (context) {
                    return AlertDialog(
                      title: const Text('Mesajları Sil'),
                      content: const Text(
                        'Seçili mesajları silmek istediğinize emin misiniz?',
                      ),
                      actions: [
                        TextButton(
                          onPressed: () {
                            _yukleniyorGoster();
                            setState(() {
                              aiChatList.removeWhere(
                                (chat) => seciliMesajlar.containsKey(chat.id),
                              );
                              seciliMesajlar.clear();
                              aiChatHistory = _aiChatHistory(aiChatList);
                              SharedPreference.setStringList(
                                'ai_chat_history',
                                aiChatList
                                    .map((e) => jsonEncode(e.toJson()))
                                    .toList(),
                              );
                            });
                            _yukleniyorGizle();
                            Navigator.pop(context);
                          },
                          child: const Text('Evet'),
                        ),
                        TextButton(
                          onPressed: () => Navigator.pop(context),
                          child: const Text('Hayır'),
                        ),
                      ],
                    );
                  },
                );
              },
            ),
        ],
      ),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Expanded(
              child: ListView.builder(
                controller: scrollController,
                itemCount:
                    botYaziyor ? aiChatList.length + 1 : aiChatList.length,
                itemBuilder: (context, index) {
                  if (index == aiChatList.length && botYaziyor) {
                    return mesaj(
                      AiChatModel(
                        id: "",
                        mesaj: "Yazıyor...",
                        tarih: null,
                        isUser: false,
                      ),
                      icon: const CircularProgressIndicator(),
                    );
                  }
                  return mesaj(aiChatList[index]);
                },
              ),
            ),
            Container(
              height: 80,
              padding: const EdgeInsets.all(8.0),
              decoration: BoxDecoration(
                color: Theme.of(context).colorScheme.surface,
              ),
              child: Row(
                children: [
                  Expanded(
                    child: BiltekTextField(
                      controller: mesajController,
                      onChanged:
                          (value) => setState(() {
                            mesajError = null;
                          }),
                      onSubmitted: (message) async {
                        await _mesajControl(message);
                      },
                      errorText: mesajError,
                      hint: 'Mesajınızı yazın',
                    ),
                  ),

                  if (sttAvailable)
                    InkWell(
                      onTap:
                          mesajReadOnly
                              ? null
                              : () async {
                                if (!dinliyor) {
                                  speech.listen(
                                    onResult: (result) {
                                      debugPrint(
                                        "SpeechToText Result: ${result.recognizedWords}",
                                      );

                                      _insertText(result.recognizedWords);
                                      if (result.finalResult) {
                                        setState(() {
                                          dinliyor = false;
                                        });
                                      }
                                    },
                                  );
                                } else {
                                  speech.stop();
                                  speech.cancel();
                                }
                              },
                      child: Container(
                        decoration: BoxDecoration(
                          borderRadius: BorderRadius.all(Radius.circular(100)),
                          color: mesajReadOnly ? Colors.grey : Colors.blue,
                        ),
                        width: 40,
                        height: 40,
                        child: Icon(
                          dinliyor
                              ? CupertinoIcons.mic
                              : CupertinoIcons.mic_off,
                          color: Colors.white,
                          size: 20,
                        ),
                      ),
                    ),
                  if (sttAvailable) SizedBox(width: 8),
                  InkWell(
                    onTap:
                        mesajReadOnly || dinliyor
                            ? null
                            : () async {
                              await _mesajControl(mesajController.text);
                            },
                    child: Container(
                      decoration: BoxDecoration(
                        borderRadius: BorderRadius.all(Radius.circular(100)),
                        color:
                            mesajReadOnly || dinliyor
                                ? Colors.grey
                                : Colors.blue,
                      ),
                      width: 40,
                      height: 40,
                      child: Icon(
                        CupertinoIcons.paperplane_fill,
                        color: Colors.white,
                        size: 20,
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Future<void> _mesajControl(String message) async {
    if (mesajReadOnly) {
      setState(() {
        mesajError = "Yeni mesaj göndermek için bekleyin.";
      });
      return;
    }
    if (message.trim().isEmpty) {
      setState(() {
        mesajError = "Mesaj boş olamaz!";
      });
      return;
    }
    final response = await sendMessage(message);
    if (response.isNotEmpty) {
      setState(() {});
    }
  }

  Future<String> sendMessage(String message) async {
    if (message.isEmpty) {
      return "";
    }
    scrollController.jumpTo(scrollController.position.maxScrollExtent);
    final userMessage = Content('user', [TextPart(message)]);
    setState(() {
      mesajReadOnly = true;
      mesajError = null;
      botYaziyor = true;
      aiChatHistory.add(userMessage);
      aiChatList.add(AiChatModel.create(mesaj: message, isUser: true));
      mesajController.text = "";
    });
    _altaKaydir();
    final generationConfig = GenerationConfig(responseMimeType: 'text/plain');

    final ai = FirebaseAI.googleAI(
      app: FirebaseApi.instance,
      appCheck: FirebaseApi.appCheck,
    );

    final model = ai.generativeModel(
      model: 'gemma-3-27b-it',
      generationConfig: generationConfig,
    );

    final chat = model.startChat(history: aiChatHistory);

    final response = await chat.sendMessage(userMessage);
    if (response.text != null && response.text!.isNotEmpty) {
      debugPrint("AI Response: ${response.text}");
      if (response.text!.startsWith("```json")) {
        String responseText =
            response.text!
                .replaceAll("```json", "")
                .replaceAll("```", "")
                .trim();
        AiResponseModel aiResponseModel = AiResponseModel.fromJson(
          jsonDecode(responseText),
        );
        switch (aiResponseModel.type) {
          case "cihazAra":
            List<Cihaz> cihazlarTemp = await BiltekPost.cihazlariGetir(
              arama: aiResponseModel.query,
              limit: 10,
            );
            if (cihazlarTemp.isEmpty) {
              aiChatList.add(
                AiChatModel.create(
                  mesaj: "**${aiResponseModel.query} cihazı bulunamadı**",
                  isUser: false,
                ),
              );
            } else {
              String cihazlarText =
                  "${aiResponseModel.query} sorgusuna ait son 10 cihaz:\n";
              for (var i = 0; i < cihazlarTemp.length; i++) {
                final cihaz = cihazlarTemp[i];
                cihazlarText += "**-----------------------------**";
                cihazlarText +=
                    "\n[Servis No: ${cihaz.servisNo}\nMüşteri Adı: ${cihaz.musteriAdi}\nCihaz: ${cihaz.cihaz} ${cihaz.cihazModeli}\nTarih: ${cihaz.tarih}](servisNo:${cihaz.servisNo})";
              }
              aiChatHistory.add(Content('model', [TextPart(cihazlarText)]));
              aiChatList.add(
                AiChatModel.create(mesaj: cihazlarText, isUser: false),
              );
            }
            break;
          default:
            aiChatHistory.add(
              Content('model', [
                TextPart(
                  "**Bir hata oluştu. Lütfen daha sonra tekrar deneyin**",
                ),
              ]),
            );
            aiChatList.add(
              AiChatModel.create(
                mesaj: "**Bir hata oluştu. Lütfen daha sonra tekrar deneyin**",
                isUser: false,
              ),
            );
            break;
        }
      } else {
        aiChatHistory.add(Content('model', [TextPart(response.text!)]));
        aiChatList.add(
          AiChatModel.create(mesaj: response.text!, isUser: false),
        );
      }
    } else {
      debugPrint("AI Response is empty or null");
      aiChatHistory.add(
        Content('model', [
          TextPart("**Bir hata oluştu. Lütfen daha sonra tekrar deneyin**"),
        ]),
      );
      aiChatList.add(
        AiChatModel.create(
          mesaj: "**Bir hata oluştu. Lütfen daha sonra tekrar deneyin**",
          isUser: false,
        ),
      );
    }

    setState(() {
      mesajReadOnly = false;
      botYaziyor = false;
      mesajError = null;
    });
    await SharedPreference.setStringList(
      'ai_chat_history',
      aiChatList.map((e) => jsonEncode(e.toJson())).toList(),
    );
    return response.text ?? "";
  }

  Widget mesaj(AiChatModel chat, {Widget? icon}) {
    // if (index > 0) SizedBox(height: 10),
    final userIcon = Container(
      padding: const EdgeInsets.all(4),
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(100),
        color: Colors.grey[200],
      ),
      child:
          icon ??
          (chat.isUser
              ? Icon(
                Icons.person,
                color: Colors.blue,
                size: 20, // ufak tutunca balonu taşırmaz
              )
              : Image.asset(BiltekAssets.icon, width: 20, height: 20)),
    );
    return GestureDetector(
      behavior: HitTestBehavior.translucent,
      onLongPress: () {
        _sec(chat);
      },
      onTap: () {
        if (seciliMesajlar.isNotEmpty) {
          _sec(chat);
        }
      },
      child: Stack(
        children: [
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
            child: Row(
              mainAxisAlignment:
                  chat.isUser ? MainAxisAlignment.end : MainAxisAlignment.start,
              crossAxisAlignment: CrossAxisAlignment.start, // <‑‑ ikon tepede
              children: [
                // Bot mesajıysa: ikon solda
                if (!chat.isUser) ...[userIcon, const SizedBox(width: 4)],

                // Balon
                Flexible(
                  child: ConstrainedBox(
                    constraints: BoxConstraints(
                      maxWidth: MediaQuery.of(context).size.width * 0.7,
                    ),
                    child: DecoratedBox(
                      decoration: BoxDecoration(
                        color: chat.isUser ? Colors.blue[50] : Colors.green[50],
                        borderRadius: BorderRadius.only(
                          topLeft: Radius.circular(12),
                          topRight: Radius.circular(12),
                          bottomLeft:
                              chat.isUser ? Radius.circular(12) : Radius.zero,
                          bottomRight:
                              chat.isUser ? Radius.zero : Radius.circular(12),
                        ),
                      ),
                      child: Padding(
                        padding: const EdgeInsets.all(10),
                        child: Column(
                          crossAxisAlignment:
                              chat.isUser
                                  ? CrossAxisAlignment.end
                                  : CrossAxisAlignment.start,
                          children: [
                            MarkdownWidget(
                              data: chat.mesaj,
                              shrinkWrap: true,
                              physics: NeverScrollableScrollPhysics(),
                              selectable: false,
                              config: MarkdownConfig(
                                configs: [
                                  LinkConfig(
                                    style: TextStyle(
                                      color: Colors.blue,
                                      decoration: TextDecoration.underline,
                                    ),
                                    onTap: (url) {
                                      if (url.isNotEmpty) {
                                        if (url.startsWith("servisNo:") &&
                                            !chat.isUser) {
                                          Navigator.of(context).push(
                                            MaterialPageRoute(
                                              builder:
                                                  (context) => DetaylarSayfasi(
                                                    kullanici: widget.kullanici,
                                                    servisNo: int.parse(
                                                      url.replaceAll(
                                                        "servisNo:",
                                                        "",
                                                      ),
                                                    ),
                                                    cihazlariYenile: () {},
                                                  ),
                                            ),
                                          );
                                        }
                                      }
                                    },
                                  ),
                                ],
                              ),
                            ),
                            if (chat.tarih != null) ...[
                              const SizedBox(height: 4),
                              Text(
                                DateFormat(
                                  Islemler.tarihFormat,
                                ).format(DateTime.parse(chat.tarih!)),
                                style: TextStyle(
                                  fontSize: 10,
                                  color: Colors.grey,
                                ),
                              ),
                            ],
                          ],
                        ),
                      ),
                    ),
                  ),
                ),

                // Kullanıcı mesajıysa: ikon sağda
                if (chat.isUser) ...[const SizedBox(width: 4), userIcon],
              ],
            ),
          ),
          if (seciliMesajlar.containsKey(chat.id))
            Positioned.fill(
              child: IgnorePointer(
                child: DecoratedBox(
                  decoration: BoxDecoration(
                    color: Colors.amber.withAlpha(50),
                    borderRadius: BorderRadius.only(
                      topLeft: Radius.circular(12),
                      topRight: Radius.circular(12),
                      bottomLeft:
                          chat.isUser ? Radius.circular(12) : Radius.zero,
                      bottomRight:
                          chat.isUser ? Radius.zero : Radius.circular(12),
                    ),
                  ),
                ),
              ),
            ),
        ],
      ),
    );
  }

  void _altaKaydir() {
    WidgetsBinding.instance.addPostFrameCallback((_) {
      if (scrollController.hasClients) {
        scrollController.animateTo(
          scrollController.position.maxScrollExtent,
          duration: const Duration(milliseconds: 300),
          curve: Curves.easeOut,
        );
      }
    });
  }

  void _sec(AiChatModel chat) {
    if (seciliMesajlar.containsKey(chat.id)) {
      seciliMesajlar.remove(chat.id);
    } else {
      seciliMesajlar[chat.id] = chat;
    }
    setState(() {});
  }

  bool yukleniyorAcik = false;
  void _yukleniyorGoster() {
    if (mounted && !yukleniyorAcik) {
      setState(() {
        yukleniyorAcik = true;
      });
      yukleniyor(context);
    }
  }

  void _yukleniyorGizle() {
    if (mounted && yukleniyorAcik) {
      Navigator.pop(context);
      setState(() {
        yukleniyorAcik = false;
      });
    }
  }

  List<Content> _aiChatHistory(List<AiChatModel> aiChatList) {
    return [
      yzPrompt,
      ...aiChatList.map(
        (e) => Content(e.isUser ? "user" : "model", [TextPart(e.mesaj)]),
      ),
    ];
  }

  void _insertText(String inserted) {
    final text = mesajController.text;
    final selection = mesajController.selection;
    final newText = text.replaceRange(selection.start, selection.end, inserted);
    mesajController.value = TextEditingValue(
      text: newText,
      selection: TextSelection.collapsed(
        offset: selection.baseOffset + inserted.length,
      ),
    );
    setState(() {});
  }
}
