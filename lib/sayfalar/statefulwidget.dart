import 'package:flutter/material.dart';

class VarsayilanStatefulWidget extends StatefulWidget {
  const VarsayilanStatefulWidget({super.key});

  @override
  State<VarsayilanStatefulWidget> createState() =>
      VarsayilanStatefulWidgetState();
}

class VarsayilanStatefulWidgetState<T extends VarsayilanStatefulWidget>
    extends State<T> {
  @override
  void setState(fn) {
    if (mounted) {
      super.setState(fn);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Container();
  }
}
