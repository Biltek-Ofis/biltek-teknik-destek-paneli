import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:flutter_inappwebview/flutter_inappwebview.dart';
import 'package:url_launcher/url_launcher.dart';

import '../main.dart';

class WebviewPage extends StatefulWidget {
  const WebviewPage({
    super.key,
    required this.url,
  });

  final String url;

  @override
  State<WebviewPage> createState() => _WebviewPageState();
}

class _WebviewPageState extends State<WebviewPage> {
  final GlobalKey webViewKey = GlobalKey();

  InAppWebViewController? webViewController;
  InAppWebViewSettings settings = InAppWebViewSettings(
    isInspectable: kDebugMode,
  );

  PullToRefreshController? pullToRefreshController;
  String title = "";
  double progress = 0;
  @override
  void initState() {
    super.initState();

    pullToRefreshController = kIsWeb ||
            ![TargetPlatform.iOS, TargetPlatform.android]
                .contains(defaultTargetPlatform)
        ? null
        : PullToRefreshController(
            settings: PullToRefreshSettings(
              color: Colors.blue,
            ),
            onRefresh: () async {
              if (defaultTargetPlatform == TargetPlatform.android) {
                webViewController?.reload();
              } else if (defaultTargetPlatform == TargetPlatform.iOS) {
                webViewController?.loadUrl(
                  urlRequest: URLRequest(
                    url: await webViewController?.getUrl(),
                  ),
                );
              }
            },
          );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        automaticallyImplyLeading: false,
        title: Text(title),
        actions: [
          IconButton(
            onPressed: () {
              Navigator.pop(context);
            },
            icon: Icon(Icons.close),
          ),
        ],
      ),
      body: SafeArea(
        child: Column(
          children: [
            progress < 1.0
                ? LinearProgressIndicator(value: progress)
                : Container(),
            Expanded(
              child: InAppWebView(
                key: webViewKey,
                webViewEnvironment: webViewEnvironment,
                initialUrlRequest: URLRequest(
                  url: WebUri(widget.url),
                ),
                initialSettings: settings,
                pullToRefreshController: pullToRefreshController,
                onWebViewCreated: (controller) {
                  webViewController = controller;
                },
                onLoadStart: (controller, url) async {
                  /*String tt = await webViewController?.getTitle() ?? "";
                  setState(() {
                    title = tt;
                  });*/
                },
                onPermissionRequest: (controller, request) async {
                  return PermissionResponse(
                      resources: request.resources,
                      action: PermissionResponseAction.GRANT);
                },
                shouldOverrideUrlLoading: (controller, navigationAction) async {
                  var uri = navigationAction.request.url!;

                  if (![
                    "http",
                    "https",
                    "file",
                    "chrome",
                    "data",
                    "javascript",
                    "about"
                  ].contains(uri.scheme)) {
                    if (await canLaunchUrl(uri)) {
                      // Launch the App
                      await launchUrl(
                        uri,
                      );
                      // and cancel the request
                      return NavigationActionPolicy.CANCEL;
                    }
                  }

                  return NavigationActionPolicy.ALLOW;
                },
                onLoadStop: (controller, url) async {
                  pullToRefreshController?.endRefreshing();
                  String tt = await webViewController?.getTitle() ?? "";
                  setState(() {
                    title = tt;
                  });
                },
                onReceivedError: (controller, request, error) {
                  pullToRefreshController?.endRefreshing();
                },
                onProgressChanged: (controller, progress) async {
                  if (progress == 100) {
                    pullToRefreshController?.endRefreshing();
                    String tt = await webViewController?.getTitle() ?? "";
                    setState(() {
                      title = tt;
                    });
                  }
                  setState(() {
                    this.progress = progress / 100;
                  });
                },
                onUpdateVisitedHistory:
                    (controller, url, androidIsReload) async {
                  String tt = await webViewController?.getTitle() ?? "";
                  setState(() {
                    title = tt;
                  });
                },
                onConsoleMessage: (controller, consoleMessage) {
                  if (kDebugMode) {
                    debugPrint(consoleMessage.message);
                  }
                  /*if (consoleMessage.message == "window.close();" ||
                      consoleMessage.message == "window.close()") {
                    Navigator.pop(context);
                  }*/
                },
              ),
            ),
          ],
        ),
      ),
    );
  }
}
