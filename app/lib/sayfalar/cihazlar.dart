import 'package:flutter/material.dart';

import '../models/cihaz.dart';
import '../utils/post.dart';
import '../utils/renkler.dart';

class CihazlarSayfasi extends StatefulWidget {
  const CihazlarSayfasi({
    super.key,
    this.sorumlu,
  });

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
    return SizedBox(
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
                  Color renk = Renkler.getir(cihaz.guncelDurumRenk);
                  Color? renkTemp = renk == Colors.white ? Colors.black : null;
                  return ListTile(
                    tileColor: renk,
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
                        ],
                      ),
                    ),
                    /*Text(
                          "Servis No: ${}\n${cihaz.musteriAdi}"),*/
                    subtitle: Text(cihaz.tarih),
                    trailing: Text(cihaz.guncelDurumText.toString()),
                  );
                },
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
