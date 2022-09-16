class ResponseBool {
  ResponseBool({
    required this.response,
  });
  final bool response;
  factory ResponseBool.response(String response) {
    bool responsBl = response.toLowerCase() == "true" ? true : false;
    return ResponseBool(
      response: responsBl,
    );
  }
}
