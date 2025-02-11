import 'package:flutter/material.dart';

Offset calcCirclePosition(
    int n, Size size, int dimension, double relativePadding) {
  final o = size.width > size.height
      ? Offset((size.width - size.height) / 2, 0)
      : Offset(0, (size.height - size.width) / 2);
  return o +
      Offset(
        size.shortestSide /
            (dimension - 1 + relativePadding * 2) *
            (n % dimension + relativePadding),
        size.shortestSide /
            (dimension - 1 + relativePadding * 2) *
            (n ~/ dimension + relativePadding),
      );
}

class Desen extends StatefulWidget {
  const Desen({
    super.key,
    this.hata = "",
    this.initDesen = const [],
    this.duzenlenebilir = true,
    this.dimension = 3,
    this.relativePadding = 0.7,
    this.selectedColor,
    this.notSelectedColor = Colors.black45,
    this.pointRadius = 10,
    this.showInput = true,
    this.selectThreshold = 25,
    this.fillPoints = false,
    required this.onInputComplete,
  });

  final String hata;
  final List<int> initDesen;
  final bool duzenlenebilir;

  final int dimension;

  final double relativePadding;

  final Color? selectedColor;

  final Color notSelectedColor;

  final double pointRadius;

  final bool showInput;

  final int selectThreshold;

  final bool fillPoints;

  final Function(List<int>) onInputComplete;

  @override
  State<Desen> createState() => DesenState();
}

class DesenState extends State<Desen> {
  List<int> used = [];
  Offset? currentPoint;
  String desenHata = "";

  @override
  void initState() {
    super.initState();
    used = widget.initDesen;
    desenHata = widget.hata;
  }

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onPanStart: (details) {
        if (!widget.duzenlenebilir) {
          return;
        }
        setState(() {
          used = [];
          currentPoint = null;
        });
        widget.onInputComplete(used);
      },
      onPanEnd: (DragEndDetails details) {
        if (!widget.duzenlenebilir) {
          return;
        }
        if (used.isNotEmpty) {
          widget.onInputComplete(used);
        }
        setState(() {
          ////used = [];
          currentPoint = null;
        });
      },
      onPanUpdate: (DragUpdateDetails details) {
        if (!widget.duzenlenebilir) {
          return;
        }
        RenderBox referenceBox = context.findRenderObject() as RenderBox;
        Offset localPosition =
            referenceBox.globalToLocal(details.globalPosition);

        Offset circlePosition(int n) => calcCirclePosition(
              n,
              referenceBox.size,
              widget.dimension,
              widget.relativePadding,
            );

        setState(() {
          currentPoint = localPosition;
          for (int i = 0; i < widget.dimension * widget.dimension; ++i) {
            final toPoint = (circlePosition(i) - localPosition).distance;
            if (!used.contains(i) && toPoint < widget.selectThreshold) {
              used.add(i);
            }
          }
        });
      },
      child: Column(
        children: [
          Expanded(
            child: CustomPaint(
              painter: _DesenPaint(
                dimension: widget.dimension,
                used: used,
                currentPoint: currentPoint,
                relativePadding: widget.relativePadding,
                selectedColor: widget.selectedColor ??
                    Theme.of(context).textTheme.bodyMedium?.color ??
                    Theme.of(context).primaryColor,
                notSelectedColor:
                    Theme.of(context).textTheme.bodyMedium?.color ??
                        Colors.black45,
                pointRadius: widget.pointRadius,
                showInput: widget.showInput,
                fillPoints: widget.fillPoints,
              ),
              size: Size.infinite,
            ),
          ),
          Text(
            desenHata,
            style: TextStyle(color: Colors.red),
          ),
        ],
      ),
    );
  }

  void hataGoster(String hata) {
    setState(() {
      desenHata = hata;
    });
  }
}

@immutable
class _DesenPaint extends CustomPainter {
  final int dimension;
  final List<int> used;
  final Offset? currentPoint;
  final double relativePadding;
  final double pointRadius;
  final bool showInput;

  final Paint circlePaint;
  final Paint selectedPaint;

  _DesenPaint({
    required this.dimension,
    required this.used,
    this.currentPoint,
    required this.relativePadding,
    required Color selectedColor,
    required Color notSelectedColor,
    required this.pointRadius,
    required this.showInput,
    required bool fillPoints,
  })  : circlePaint = Paint()
          ..color = notSelectedColor
          ..style = fillPoints ? PaintingStyle.fill : PaintingStyle.stroke
          ..strokeWidth = 2,
        selectedPaint = Paint()
          ..color = selectedColor
          ..style = fillPoints ? PaintingStyle.fill : PaintingStyle.stroke
          ..strokeCap = StrokeCap.round
          ..strokeWidth = 2;

  @override
  void paint(Canvas canvas, Size size) {
    Offset circlePosition(int n) =>
        calcCirclePosition(n, size, dimension, relativePadding);

    for (int i = 0; i < dimension; ++i) {
      for (int j = 0; j < dimension; ++j) {
        canvas.drawCircle(
          circlePosition(i * dimension + j),
          pointRadius,
          showInput && used.contains(i * dimension + j)
              ? selectedPaint
              : circlePaint,
        );
      }
    }

    if (showInput) {
      for (int i = 0; i < used.length - 1; ++i) {
        canvas.drawLine(
          circlePosition(used[i]),
          circlePosition(used[i + 1]),
          selectedPaint,
        );
      }

      final currentPoint = this.currentPoint;
      if (used.isNotEmpty && currentPoint != null) {
        canvas.drawLine(
          circlePosition(used[used.length - 1]),
          currentPoint,
          selectedPaint,
        );
      }
    }
  }

  @override
  bool shouldRepaint(CustomPainter oldDelegate) => true;
}
