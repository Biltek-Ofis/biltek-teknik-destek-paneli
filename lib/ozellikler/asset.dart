class Asset {
  Asset();

  static Asset get of {
    return Asset();
  }

  String assetsPath = "assets/";

  AssetImage get image {
    return AssetImage(assetsPath);
  }
}

class AssetImage {
  AssetImage(this.assetsPath);

  final String assetsPath;
  String get path {
    return "${assetsPath}images";
  }

  String get logo => "$path/logo.png";
}

extension AssetExtension on Asset {
  Asset getRelativePath() {
    Asset asset = Asset();
    asset.assetsPath = "";
    return asset;
  }
}
