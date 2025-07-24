import 'package:flutter/material.dart';

import '../models/musteri.dart';
import '../utils/post.dart';
import 'input.dart';

typedef MusteriSecCallback = void Function(MusteriModel musteri);

class MusteriSec extends StatefulWidget {
  const MusteriSec({
    super.key,
    this.musteriAdiController,
    this.musteriAdiFocus,
    this.onMusteriSec,
  });

  final TextEditingController? musteriAdiController;
  final FocusNode? musteriAdiFocus;
  final MusteriSecCallback? onMusteriSec;

  static void show(
    BuildContext context, {
    TextEditingController? musteriAdiController,
    FocusNode? musteriAdiFocus,
    required MusteriSecCallback onMusteriSec,
  }) {
    String musteriAdiOnceki = musteriAdiController?.text ?? "";
    showDialog(
      context: context,
      builder: (context) {
        return AlertDialog(
          title: Text("Müşteri Adı"),
          content: SizedBox(
            width: MediaQuery.of(context).size.width,
            height: 300,
            child: MusteriSec(
              musteriAdiController: musteriAdiController,
              musteriAdiFocus: musteriAdiFocus,
              onMusteriSec: (musteri) {
                onMusteriSec.call(musteri);
                Navigator.pop(context);
              },
            ),
          ),
          actions: [
            TextButton(
              onPressed: () {
                Navigator.pop(context);
              },
              child: Text("Tamam"),
            ),
            TextButton(
              onPressed: () {
                musteriAdiController?.text = musteriAdiOnceki;
                Navigator.pop(context);
              },
              child: Text("İptal"),
            ),
          ],
        );
      },
    );
  }

  @override
  State<MusteriSec> createState() => _MusteriSecState();
}

class _MusteriSecState extends State<MusteriSec> {
  List<MusteriModel> musteriler = [];
  @override
  void initState() {
    Future.delayed(Duration.zero, () async {
      List<MusteriModel> tempMusteriler =
          await BiltekPost.musteriBilgileriGetir(
            widget.musteriAdiController?.text ?? "",
          );
      setState(() {
        musteriler = tempMusteriler;
      });
      widget.musteriAdiFocus?.requestFocus();
    });
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        BiltekTextField(
          controller: widget.musteriAdiController,
          currentFocus: widget.musteriAdiFocus,
          onChanged: (value) async {
            List<MusteriModel> tempMusteriler =
                await BiltekPost.musteriBilgileriGetir(value);
            setState(() {
              musteriler = tempMusteriler;
            });
          },
        ),
        Expanded(
          child: ListView.builder(
            itemCount: musteriler.length,
            scrollDirection: Axis.vertical,
            itemBuilder: (context, index) {
              MusteriModel musteri = musteriler[index];
              return ListTile(
                title: Text(
                  "${musteri.musteriAdi}${musteri.adres.trim().isNotEmpty ? " / ${musteri.adres}" : ""}${musteri.telefonNumarasi.trim().isNotEmpty && musteri.telefonNumarasi != "+90 (___) ___-____" ? " / ${musteri.telefonNumarasi}" : ""}",
                ),
                onTap: () {
                  widget.onMusteriSec?.call(musteri);
                },
              );
            },
          ),
        ),
      ],
    );
  }
}
