import 'dart:async';

import 'package:flutter/material.dart';
import 'package:teknikservis/utils/islemler.dart';
import 'package:teknikservis/utils/post.dart';

import '../models/cihaz.dart';

class DetaylarSayfasi extends StatefulWidget {
  const DetaylarSayfasi({
    super.key,
    required this.id,
  });

  final int id;

  @override
  State<DetaylarSayfasi> createState() => _DetaylarSayfasiState();
}

class _DetaylarSayfasiState extends State<DetaylarSayfasi> {
  Cihaz? cihaz;

  bool yukleniyor = true;

  Timer? timer;

  TableBorder tableBorder = TableBorder.symmetric(
    inside: BorderSide(
      color: Colors.yellow.withAlpha(100),
    ),
  );

  @override
  void initState() {
    Future.delayed(Duration.zero, () async {
      await _cihaziYenile();
    });
    timer = Timer.periodic(Duration(seconds: 5), (timer) async {
      await _cihaziYenile();
    });
    super.initState();
  }

  @override
  void dispose() {
    timer?.cancel();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return DefaultTabController(
      length: 3,
      child: Scaffold(
        appBar: AppBar(
          title: cihaz != null ? Text("${cihaz!.servisNo} Detayları") : null,
          bottom: TabBar(
            tabs: [
              Tab(
                text: "Genel Bilgiler",
              ),
              Tab(
                text: "Teknik Servis Bilgileri",
              ),
              Tab(
                text: "Yapılan İşlemler",
              ),
            ],
          ),
        ),
        body: SizedBox(
          height: MediaQuery.of(context).size.height,
          child: TabBarView(
            children: [
              SizedBox(
                child: cihaz != null
                    ? SingleChildScrollView(
                        physics: AlwaysScrollableScrollPhysics(),
                        child: Table(
                          border: tableBorder,
                          children: [
                            TableRow(
                              children: [
                                Text(
                                  "Servis No:",
                                  style: TextStyle(
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                Text(cihaz!.servisNo.toString())
                              ],
                            ),
                            TableRow(
                              children: [
                                Text(
                                  "Takip No:",
                                  style: TextStyle(
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                Text(cihaz!.takipNumarasi.toString())
                              ],
                            ),
                            TableRow(
                              children: [
                                Text(
                                  "Müşteri Adı:",
                                  style: TextStyle(
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                Text(cihaz!.musteriAdi)
                              ],
                            ),
                            TableRow(
                              children: [
                                Text(
                                  "Teslim Eden:",
                                  style: TextStyle(
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                Text(cihaz!.teslimEden)
                              ],
                            ),
                            TableRow(
                              children: [
                                Text(
                                  "Teslim Alan:",
                                  style: TextStyle(
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                Text(cihaz!.teslimAlan)
                              ],
                            ),
                            TableRow(
                              children: [
                                Text(
                                  "Adresi:",
                                  style: TextStyle(
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                Text(cihaz!.adres)
                              ],
                            ),
                            TableRow(
                              children: [
                                Text(
                                  "GSM:",
                                  style: TextStyle(
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                Text(cihaz!.telefonNumarasi)
                              ],
                            ),
                            TableRow(
                              children: [
                                Text(
                                  "Giriş Tarihi:",
                                  style: TextStyle(
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                Text(cihaz!.tarih)
                              ],
                            ),
                            TableRow(
                              children: [
                                Text(
                                  "Çıkış Tarihi:",
                                  style: TextStyle(
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                Text(cihaz!.cikisTarihi)
                              ],
                            ),
                            TableRow(
                              children: [
                                Text(
                                  "Bildirim Tarihi:",
                                  style: TextStyle(
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                Text(cihaz!.bildirimTarihi)
                              ],
                            ),
                            TableRow(
                              children: [
                                Text(
                                  "Güncel Durum:",
                                  style: TextStyle(
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                Text(cihaz!.guncelDurumText)
                              ],
                            ),
                          ],
                        ),
                      )
                    : Center(),
              ),
              SizedBox(
                child: cihaz != null
                    ? SingleChildScrollView(
                        physics: AlwaysScrollableScrollPhysics(),
                        child: Table(
                          border: tableBorder,
                          children: [
                            TableRow(
                              children: [
                                Text(
                                  "Cihaz Türü:",
                                  style: TextStyle(
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                Text(cihaz!.cihazTuru)
                              ],
                            ),
                            TableRow(
                              children: [
                                Text(
                                  "Markası:",
                                  style: TextStyle(
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                Text(cihaz!.cihaz)
                              ],
                            ),
                            TableRow(
                              children: [
                                Text(
                                  "Modeli:",
                                  style: TextStyle(
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                Text(cihaz!.cihazModeli)
                              ],
                            ),
                            TableRow(
                              children: [
                                Text(
                                  "Seri No:",
                                  style: TextStyle(
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                Text(cihaz!.seriNo)
                              ],
                            ),
                            TableRow(
                              children: [
                                Text(
                                  "Teslim Alınanlar:",
                                  style: TextStyle(
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                Text(cihaz!.teslimAlan)
                              ],
                            ),
                            TableRow(
                              children: [
                                Text(
                                  "Cihaz Şifresi:",
                                  style: TextStyle(
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                cihaz!.cihazSifresi != "Yok" &&
                                        cihaz!.cihazSifresi.isNotEmpty
                                    ? Text(cihaz!.cihazSifresi)
                                    : Text("")
                              ],
                            ),
                          ],
                        ),
                      )
                    : Center(),
              ),
              SizedBox(
                child: cihaz != null
                    ? SingleChildScrollView(
                        physics: AlwaysScrollableScrollPhysics(),
                        child: Column(
                          children: [
                            Table(
                              border: tableBorder,
                              children: [
                                /*TableRow(
                                  children: [
                                    Text(
                                      "Teslim Alınmadan Önce Belirlenen Hasar Türü:",
                                      style: TextStyle(
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                    Text(cihaz!.cihazdakiHasar)
                                  ],
                                ),*/
                                TableRow(
                                  children: [
                                    Text(
                                      "Teslim Alınmadan Önce Yapılan Hasar Tespiti:",
                                      style: TextStyle(
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                    Text(cihaz!.hasarTespiti)
                                  ],
                                ),
                                TableRow(
                                  children: [
                                    Text(
                                      "Arıza Açıklaması:",
                                      style: TextStyle(
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                    Text(cihaz!.arizaAciklamasi)
                                  ],
                                ),
                                TableRow(
                                  children: [
                                    Text(
                                      "Servis Türü:",
                                      style: TextStyle(
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                    Text(Islemler.servisTuru(cihaz!.servisTuru))
                                  ],
                                ),
                                TableRow(
                                  children: [
                                    Text(
                                      "Yedek Alınacak mı?:",
                                      style: TextStyle(
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                    Text(cihaz!.yedekDurumu == 1
                                        ? "Evet"
                                        : (cihaz!.yedekDurumu == 0
                                            ? "Hayır"
                                            : "Belirtilmemiş"))
                                  ],
                                ),
                                TableRow(
                                  children: [
                                    Text(
                                      "Güncel Durum:",
                                      style: TextStyle(
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                    Text(cihaz!.guncelDurumText)
                                  ],
                                ),
                                TableRow(
                                  children: [
                                    Text(
                                      "Bildirim Tarihi:",
                                      style: TextStyle(
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                    Text(cihaz!.bildirimTarihi)
                                  ],
                                ),
                                TableRow(
                                  children: [
                                    Text(
                                      "Sorumlu Personel:",
                                      style: TextStyle(
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                    Text(cihaz!.sorumlu)
                                  ],
                                ),
                                TableRow(
                                  children: [
                                    Text(
                                      "Yapılan İşlem Açıklaması:",
                                      style: TextStyle(
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                    Text(cihaz!.yapilanIslemAciklamasi)
                                  ],
                                ),
                              ],
                            ),
                            Builder(
                              builder: (context) {
                                EdgeInsetsGeometry padding = EdgeInsets.all(1);
                                List<TableRow> rows = [];
                                double kdvsizToplam = 0;
                                double kdvToplam = 0;
                                for (int i = 0;
                                    i < cihaz!.islemler.length;
                                    i++) {
                                  YapilanIslem islem = cihaz!.islemler[i];
                                  if (islem.ad.isNotEmpty) {
                                    double kdvsiz =
                                        islem.miktar * islem.birimFiyati;
                                    double kdv = (kdvsiz / 100) * islem.kdv;
                                    double kdvli = kdvsiz + kdv;
                                    kdvsizToplam += kdvsiz;
                                    kdvToplam += kdv;
                                    rows.add(TableRow(
                                      children: [
                                        Container(
                                          padding: padding,
                                          child: Text(islem.ad),
                                        ),
                                        Container(
                                          padding: padding,
                                          child: Text(islem.miktar.toString()),
                                        ),
                                        Container(
                                          padding: padding,
                                          child:
                                              Text("${islem.birimFiyati} TL"),
                                        ),
                                        Container(
                                          padding: padding,
                                          child: Text("${islem.kdv} ($kdv TL)"),
                                        ),
                                        Container(
                                          padding: padding,
                                          child: Text("$kdvsiz TL"),
                                        ),
                                        Container(
                                          padding: padding,
                                          child: Text("$kdvli TL"),
                                        ),
                                      ],
                                    ));
                                  }
                                }

                                double genelToplam = kdvsizToplam + kdvToplam;
                                return Column(
                                  children: [
                                    Table(
                                      border: tableBorder,
                                      children: [
                                        TableRow(
                                          children: [
                                            Container(
                                              padding: padding,
                                              child: Text(
                                                "Malzeme/İşçilik",
                                                style: TextStyle(
                                                  fontWeight: FontWeight.bold,
                                                ),
                                              ),
                                            ),
                                            Container(
                                              padding: padding,
                                              child: Text(
                                                "Miktar",
                                                style: TextStyle(
                                                  fontWeight: FontWeight.bold,
                                                ),
                                              ),
                                            ),
                                            Container(
                                              padding: padding,
                                              child: Text(
                                                "Birim Fiyatı",
                                                style: TextStyle(
                                                  fontWeight: FontWeight.bold,
                                                ),
                                              ),
                                            ),
                                            Container(
                                              padding: padding,
                                              child: Text(
                                                "KDV",
                                                style: TextStyle(
                                                  fontWeight: FontWeight.bold,
                                                ),
                                              ),
                                            ),
                                            Container(
                                              padding: padding,
                                              child: Text(
                                                "Tutar (KDV'siz)",
                                                style: TextStyle(
                                                  fontWeight: FontWeight.bold,
                                                ),
                                              ),
                                            ),
                                            Container(
                                              padding: padding,
                                              child: Text(
                                                "Toplam",
                                                style: TextStyle(
                                                  fontWeight: FontWeight.bold,
                                                ),
                                              ),
                                            ),
                                          ],
                                        ),
                                        ...rows
                                      ],
                                    ),
                                    if (rows.isEmpty)
                                      Container(
                                        padding: EdgeInsets.only(top: 5),
                                        width:
                                            MediaQuery.of(context).size.width,
                                        child: Text(
                                          "Şuanda yapılmış bir işlem yok.",
                                          textAlign: TextAlign.center,
                                        ),
                                      ),
                                    Container(
                                      padding: EdgeInsets.only(top: 10),
                                      child: Table(
                                        border: tableBorder,
                                        children: [
                                          TableRow(
                                            children: [
                                              Text(
                                                "Toplam:",
                                                style: TextStyle(
                                                  fontWeight: FontWeight.bold,
                                                ),
                                              ),
                                              Text(
                                                "$kdvsizToplam TL",
                                              )
                                            ],
                                          ),
                                          TableRow(
                                            children: [
                                              Text(
                                                "KDV:",
                                                style: TextStyle(
                                                  fontWeight: FontWeight.bold,
                                                ),
                                              ),
                                              Text(
                                                "$kdvToplam TL",
                                              )
                                            ],
                                          ),
                                          TableRow(
                                            children: [
                                              Text(
                                                "Genel Toplam:",
                                                style: TextStyle(
                                                  fontWeight: FontWeight.bold,
                                                ),
                                              ),
                                              Text(
                                                "$genelToplam TL",
                                              )
                                            ],
                                          )
                                        ],
                                      ),
                                    )
                                  ],
                                );
                              },
                            ),
                            Table(
                              border: tableBorder,
                              children: [
                                TableRow(
                                  children: [
                                    Text(
                                      "Tahsilat Şekli:",
                                      style: TextStyle(
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                    Text(cihaz!.tahsilatSekli)
                                  ],
                                ),
                                TableRow(
                                  children: [
                                    Text(
                                      "Fatura Durumu:",
                                      style: TextStyle(
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                    Text(Islemler.faturaDurumu(
                                        cihaz!.faturaDurumu))
                                  ],
                                ),
                                TableRow(
                                  children: [
                                    Text(
                                      "Fiş No:",
                                      style: TextStyle(
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                    Text(cihaz!.fisNo)
                                  ],
                                ),
                              ],
                            ),
                          ],
                        ),
                      )
                    : Center(),
              ),
            ],
          ),
        ),
      ),
    );
  }

  Future<void> _cihaziYenile() async {
    Cihaz? cihazTemp = await BiltekPost.cihazGetir(
      id: widget.id,
    );
    if (mounted) {
      setState(() {
        cihaz = cihazTemp;
        yukleniyor = false;
      });
    } else {
      cihaz = cihazTemp;
      yukleniyor = false;
    }
  }
}
