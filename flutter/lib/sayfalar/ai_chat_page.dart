import 'dart:convert';

import 'package:biltekteknikservis/models/ai_chat.dart';
import 'package:biltekteknikservis/widgets/input.dart';
import 'package:firebase_ai/firebase_ai.dart';
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import 'package:markdown_widget/markdown_widget.dart';

import '../utils/alerts.dart';
import '../utils/assets.dart';
import '../utils/firebase.dart';
import '../utils/islemler.dart';
import '../utils/shared_preferences.dart';

class AIChatPage extends StatefulWidget {
  const AIChatPage({super.key});

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

  Content yzPrompt = Content('model', [
    TextPart(
      "Senin adın Biltek Yapay Zeka. Biltek'in yapay zeka destekli asistanısın. Bilgisayar, telefon, yazıcı hakkındaki sorular, hatalar konusunda yardımcı olabilirsin.",
    ),
  ]);

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

      setState(() {});
      _altaKaydir();
      _yukleniyorGizle();
    });
  }

  @override
  dispose() {
    mesajController.dispose();
    scrollController.dispose();
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
              icon: const Icon(Icons.delete),
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
                  InkWell(
                    onTap:
                        mesajReadOnly
                            ? null
                            : () async {
                              await _mesajControl(mesajController.text);
                            },
                    child: Container(
                      decoration: BoxDecoration(
                        borderRadius: BorderRadius.all(Radius.circular(100)),
                        color: mesajReadOnly ? Colors.grey : Colors.blue,
                      ),
                      width: 60,
                      height: 60,
                      child: Icon(Icons.send, color: Colors.white, size: 30),
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
      aiChatHistory.add(Content('model', [TextPart(response.text!)]));
      aiChatList.add(AiChatModel.create(mesaj: response.text!, isUser: false));
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
}
