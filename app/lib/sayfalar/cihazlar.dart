import 'package:flutter/material.dart';

import '../models/cihaz.dart';
import '../models/kullanici.dart';
import '../utils/post.dart';
import '../utils/renkler.dart';
import '../widgets/scaffold.dart';

class CihazlarSayfasi extends StatefulWidget {
  const CihazlarSayfasi({
    super.key,
    required this.kullanici,
    required this.seciliSayfa,
    this.sorumlu,
  });
  final KullaniciModel kullanici;
  final String seciliSayfa;
  final int? sorumlu;

  @override
  State<CihazlarSayfasi> createState() => _CihazlarSayfasiState();
}

class _CihazlarSayfasiState extends State<CihazlarSayfasi> {
  List<Cihaz> cihazlar = [];
  @override
  void initState() {
    Future.delayed(Duration.zero, () async {
      await _cihazlariYenile();
    });
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      drawer: biltekDrawer(
        context,
        kullanici: widget.kullanici,
        seciliSayfa: widget.seciliSayfa,
      ),
      appBar: biltekAppBar(
        context,
        title: widget.kullanici.adSoyad,
      ),
      body: Container(
        decoration: BoxDecoration(
          color: Colors.white,
        ),
        width: MediaQuery.of(context).size.width,
        child: cihazlar.isEmpty
            ? Center(
                child: CircularProgressIndicator(),
              )
            : RefreshIndicator(
                onRefresh: () async {
                  await _cihazlariYenile();
                },
                child: ListView.builder(
                  itemCount: cihazlar.length,
                  itemBuilder: (context, index) {
                    Cihaz cihaz = cihazlar[index];
                    Color? renkTemp = Renkler.yazi(cihaz.guncelDurumRenk);
                    return Container(
                      decoration: BoxDecoration(
                        color: Renkler.arka(cihaz.guncelDurumRenk),
                        border: Border.all(color: Colors.black, width: 1),
                      ),
                      child: ListTile(
                        textColor: renkTemp,
                        title: RichText(
                          text: TextSpan(
                            children: <TextSpan>[
                              TextSpan(
                                text: "Servis No: ",
                                style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  color: renkTemp,
                                ),
                              ),
                              TextSpan(
                                text: cihaz.servisNo.toString(),
                                style: TextStyle(
                                  color: renkTemp,
                                ),
                              ),
                              TextSpan(
                                text: "\nMüşteri Adı: ",
                                style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  color: renkTemp,
                                ),
                              ),
                              TextSpan(
                                text: cihaz.musteriAdi,
                                style: TextStyle(
                                  color: renkTemp,
                                ),
                              ),
                              TextSpan(
                                text: "\nCihaz Tür: ",
                                style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  color: renkTemp,
                                ),
                              ),
                              TextSpan(
                                text: cihaz.cihazTuru,
                                style: TextStyle(
                                  color: renkTemp,
                                ),
                              ),
                              if (widget.sorumlu == null)
                                TextSpan(
                                  text: "\nSorumlu: ",
                                  style: TextStyle(
                                    fontWeight: FontWeight.bold,
                                    color: renkTemp,
                                  ),
                                ),
                              if (widget.sorumlu == null)
                                TextSpan(
                                  text: cihaz.sorumlu,
                                  style: TextStyle(
                                    color: renkTemp,
                                  ),
                                ),
                              TextSpan(
                                text: "\nCihaz: ",
                                style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  color: renkTemp,
                                ),
                              ),
                              TextSpan(
                                text:
                                    "${cihaz.cihaz}${(cihaz.cihazModeli.isNotEmpty ? " ${cihaz.cihazModeli}" : "")}",
                                style: TextStyle(
                                  color: renkTemp,
                                ),
                              ),
                              TextSpan(
                                text: "\nGiriş Tarihi: ",
                                style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  color: renkTemp,
                                ),
                              ),
                              TextSpan(
                                text: cihaz.tarih,
                                style: TextStyle(
                                  color: renkTemp,
                                ),
                              ),
                            ],
                          ),
                        ),
                        subtitle: Text(cihaz.guncelDurumText.toString()),
                      ),
                    );
                  },
                ),
              ),
      ),
    );
  }

  Future<void> _cihazlariYenile() async {
    List<Cihaz> cihazlarTemp = await BiltekPost.cihazlariGetir(
      sorumlu: widget.sorumlu,
    );
    if (mounted) {
      setState(() {
        cihazlar = cihazlarTemp;
      });
    } else {
      cihazlar = cihazlarTemp;
    }
  }
}
