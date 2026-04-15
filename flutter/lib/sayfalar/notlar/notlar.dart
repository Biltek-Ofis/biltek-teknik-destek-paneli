import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

import '../../models/kullanici.dart';
import '../../models/not.dart';
import '../../utils/post.dart';
import 'not_ekle_duzenle.dart';

class NotlarSayfasi extends StatefulWidget {
  const NotlarSayfasi({super.key, required this.kullanici});

  final KullaniciAuthModel kullanici;

  @override
  State<NotlarSayfasi> createState() => _NotlarSayfasiState();
}

class _NotlarSayfasiState extends State<NotlarSayfasi> {
  List<NotModel>? notlar;

  @override
  void initState() {
    super.initState();
    Future.delayed(Duration.zero, () async {
      await notlariGetir();
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("Notlar")),
      floatingActionButton: FloatingActionButton(
        onPressed: () {
          Navigator.of(context).push(
            MaterialPageRoute(
              builder:
                  (context) => NotEkleDuzenleSayfasi(
                    kullanici: widget.kullanici,
                    notlariYenile: () async {
                      await notlariGetir();
                    },
                  ),
            ),
          );
        },
        child: Icon(Icons.add),
      ),
      resizeToAvoidBottomInset: false,
      body: SafeArea(
        child: SizedBox(
          width: MediaQuery.of(context).size.width,
          height: MediaQuery.of(context).size.height,
          child:
              notlar != null
                  ? RefreshIndicator(
                    onRefresh: () async {
                      await notlariGetir();
                    },
                    child:
                        notlar!.isEmpty
                            ? ListView.builder(
                              itemCount: 1,
                              itemBuilder: (context, index) {
                                return SizedBox(
                                  width: MediaQuery.of(context).size.width,
                                  height: MediaQuery.of(context).size.height,
                                  child: Center(
                                    child: Text("Henüz bir not eklenmemiş."),
                                  ),
                                );
                              },
                            )
                            : ListView.builder(
                              itemCount: notlar!.length,
                              itemBuilder: (context, index) {
                                NotModel not = notlar![index];
                                Color? renk =
                                    Theme.of(
                                      context,
                                    ).textTheme.bodyMedium?.color;
                                return ListTile(
                                  shape: RoundedRectangleBorder(
                                    side: BorderSide(
                                      color: Colors.black,
                                      width: 1,
                                    ),
                                    borderRadius: BorderRadius.circular(5),
                                  ),
                                  title: RichText(
                                    text: TextSpan(
                                      children: <TextSpan>[
                                        TextSpan(
                                          text: "Not: ",
                                          style: TextStyle(
                                            fontWeight: FontWeight.bold,
                                            color: renk,
                                          ),
                                        ),
                                        TextSpan(
                                          text: not.aciklama,
                                          style: TextStyle(color: renk),
                                        ),
                                      ],
                                    ),
                                  ),
                                  subtitle: RichText(
                                    text: TextSpan(
                                      children: <TextSpan>[
                                        TextSpan(
                                          text: "\nOluşturulma Tarihi: ",
                                          style: TextStyle(
                                            fontWeight: FontWeight.bold,
                                            color: renk,
                                          ),
                                        ),
                                        TextSpan(
                                          text: not.tarih,
                                          style: TextStyle(color: renk),
                                        ),
                                        TextSpan(
                                          text: "\nOluşturan: ",
                                          style: TextStyle(
                                            fontWeight: FontWeight.bold,
                                            color: renk,
                                          ),
                                        ),
                                        TextSpan(
                                          text: not.olusturan,
                                          style: TextStyle(color: renk),
                                        ),
                                        TextSpan(
                                          text: "\nSon Düzenleme: ",
                                          style: TextStyle(
                                            fontWeight: FontWeight.bold,
                                            color: renk,
                                          ),
                                        ),
                                        TextSpan(
                                          text:
                                              not.sonDuzenleme == not.tarih
                                                  ? "-"
                                                  : not.sonDuzenleme,
                                          style: TextStyle(color: renk),
                                        ),
                                        TextSpan(
                                          text: "\nDüzenleyen: ",
                                          style: TextStyle(
                                            fontWeight: FontWeight.bold,
                                            color: renk,
                                          ),
                                        ),
                                        TextSpan(
                                          text:
                                              not.sonDuzenleme == not.tarih
                                                  ? "-"
                                                  : not.duzenleyen,
                                          style: TextStyle(color: renk),
                                        ),
                                      ],
                                    ),
                                  ),
                                  trailing: Row(
                                    mainAxisSize: MainAxisSize.min,
                                    mainAxisAlignment: MainAxisAlignment.end,
                                    children: [
                                      IconButton(
                                        onPressed: () {
                                          Navigator.push(
                                            context,
                                            MaterialPageRoute(
                                              builder:
                                                  (
                                                    context,
                                                  ) => NotEkleDuzenleSayfasi(
                                                    kullanici: widget.kullanici,
                                                    not: not,
                                                    notlariYenile: () async {
                                                      await notlariGetir();
                                                    },
                                                  ),
                                            ),
                                          );
                                        },
                                        icon: Icon(CupertinoIcons.pen),
                                      ),
                                      IconButton(
                                        onPressed: () {
                                          _notSil(not.id);
                                        },
                                        icon: Icon(CupertinoIcons.delete),
                                      ),
                                    ],
                                  ),
                                );
                              },
                            ),
                  )
                  : Center(child: CircularProgressIndicator()),
        ),
      ),
    );
  }

  Future<void> notlariGetir() async {
    setState(() {
      notlar = null;
    });
    List<NotModel> notlarTemp = await BiltekPost.notlariGetir();

    setState(() {
      notlar = notlarTemp;
    });
  }

  void _notSil(int id) {
    showDialog(
      context: context,
      builder: (context) {
        return AlertDialog(
          title: Text("Not Sil"),
          content: Text("Bu notu silmek istediğinize emin misiniz?"),
          actions: [
            TextButton(
              onPressed: () async {
                NavigatorState navigatorState = Navigator.of(context);
                navigatorState.pop();
                bool sil = await BiltekPost.notSil(id: id);
                if (sil) {
                  await notlariGetir();
                } else {
                  if (context.mounted) {
                    showDialog(
                      context: context,
                      builder:
                          (context) => AlertDialog(
                            title: Text("Not silinemedi."),
                            content: Text(
                              "Not silinirken bir hata oluştu. Lütfen daha sonra tekrar deneyin.",
                            ),
                            actions: [
                              TextButton(
                                onPressed: () {
                                  Navigator.pop(context);
                                },
                                child: Text("Kapat"),
                              ),
                            ],
                          ),
                    );
                  }
                }
              },
              child: Text("Evet"),
            ),
            TextButton(
              onPressed: () {
                Navigator.pop(context);
              },
              child: Text("Hayır"),
            ),
          ],
        );
      },
    );
  }
}
