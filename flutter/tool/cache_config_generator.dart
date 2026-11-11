import 'dart:convert';
import 'dart:io';

const noCache = 'no-cache, must-revalidate';
const immutable = 'public, max-age=31536000, immutable';
final web = Directory('build/web');
final manifest = File('${web.path}/precache_manifest.json');

Future<void> main(List<String> args) async {
  if (!web.existsSync() || !manifest.existsSync()) {
    stderr.writeln('Build çıktısı veya precache_manifest.json bulunamadı.');
    stderr.writeln(
      'Önce flutter build web --release --web-content-hash çalıştırın.',
    );
    exitCode = 1;
    return;
  }

  final data =
      jsonDecode(await manifest.readAsString()) as Map<String, dynamic>;

  final entries = data['entries'] as List;

  final hashed = <String>[];

  for (final item in entries) {
    if (item is! Map) continue;

    final url = item['url'];
    final isHashed = item['urlHashed'];

    if (url is! String || isHashed is! bool) {
      throw const FormatException('Geçersiz manifest girdisi.');
    }

    if (isHashed) {
      final uriPath = Uri.parse(url).path;
      if (!uriPath.contains('..') && !uriPath.contains('?')) {
        final normalizedPath = uriPath.startsWith('/') ? uriPath : '/$uriPath';
        hashed.add(normalizedPath);
      }
    }
  }

  final uniqueHashed = hashed.toSet().toList()..sort();

  final configDir = Directory('build/cache-config');
  await configDir.create(recursive: true);

  await writeJson(
    File('${configDir.path}/firebase-hosting-headers.generated.json'),
    firebaseRules(uniqueHashed),
  );

  await writeJson(
    File('${configDir.path}/vercel-headers.generated.json'),
    vercelRules(uniqueHashed),
  );

  await File('${configDir.path}/nginx-cache.generated.conf')
      .writeAsString(nginxConfig(uniqueHashed));

  await updateMarkedFile(
    File('${web.path}/_headers'),
    '# BEGIN FLUTTER CACHE CONFIG',
    '# END FLUTTER CACHE CONFIG',
    netlifyConfig(uniqueHashed),
  );

  await updateMarkedFile(
    File('${web.path}/.htaccess'),
    '# BEGIN FLUTTER CACHE CONFIG',
    '# END FLUTTER CACHE CONFIG',
    apacheConfig(uniqueHashed),
  );

  await writeJson(File('${configDir.path}/cache-report.json'), {
    'totalManifestEntries': entries.length,
    'hashedCount': uniqueHashed.length,
    'hashedFiles': uniqueHashed,
    'unhashedCount': entries.length - uniqueHashed.length,
    'hashedCache': immutable,
    'unhashedCache': noCache,
  });

  await updateIndexHtmlWithHashedAssets();

  stdout.writeln('Cache yapılandırmaları oluşturuldu.');
  stdout.writeln('Toplam manifest girdisi: ${entries.length}');
  stdout.writeln('Hash içeren dosya: ${uniqueHashed.length}');
  stdout.writeln(
    'Hash içermeyen dosya: ${entries.length - uniqueHashed.length}',
  );
}

Future<void> updateIndexHtmlWithHashedAssets() async {
  final indexFile = File('${web.path}/index.html');

  if (!indexFile.existsSync()) {
    stderr.writeln('index.html bulunamadı.');
    return;
  }

  final manifestData =
      jsonDecode(await manifest.readAsString()) as Map<String, dynamic>;
  final entries = manifestData['entries'] as List;

  var htmlContent = await indexFile.readAsString();

  for (final item in entries) {
    if (item is! Map) continue;
    final url = item['url'] as String?;
    final isHashed = item['urlHashed'] as bool?;

    if (isHashed == true && url != null) {
      // Hash'li URL'den orijinal (hash'siz) dosya yolunu türetiyoruz
      // Örn: "assets/.../web_support.2f9ccef9.js" -> "assets/.../web_support.js"
      final originalUrl = url.replaceAll(RegExp(r'\.[0-9a-f]{8}\.'), '.');

      if (originalUrl != url) {
        // index.html içindeki eşleşen yolları hash'li versiyonla değiştiriyoruz
        htmlContent = htmlContent.replaceAll(originalUrl, url);
      }
    }
  }

  await indexFile.writeAsString(htmlContent);
  stdout.writeln('index.html içerisindeki hashli asset yolları güncellendi.');
}

Future<void> writeJson(File file, Object data) async {
  const encoder = JsonEncoder.withIndent('  ');
  await file.writeAsString('${encoder.convert(data)}\n');
}

List<Map<String, dynamic>> firebaseRules(List<String> hashed) {
  return [
    {
      'source': '**',
      'headers': [
        {'key': 'Cache-Control', 'value': noCache},
      ],
    },
    ...hashed.map(
      (path) => {
        'regex': '^${RegExp.escape(path)}\$',
        'headers': [
          {'key': 'Cache-Control', 'value': immutable},
        ],
      },
    ),
  ];
}

Map<String, dynamic> vercelRules(List<String> hashed) {
  return {
    'headers': [
      {
        'source': '/(.*)',
        'headers': [
          {'key': 'Cache-Control', 'value': noCache},
        ],
      },
      ...hashed.map(
        (path) => {
          'source': path,
          'headers': [
            {'key': 'Cache-Control', 'value': immutable},
          ],
        },
      ),
    ],
  };
}

String netlifyConfig(List<String> hashed) {
  final b = StringBuffer()
    ..writeln('# BEGIN FLUTTER CACHE CONFIG')
    ..writeln('/*')
    ..writeln('  Cache-Control: $noCache');

  for (final path in hashed) {
    b
      ..writeln()
      ..writeln(path)
      ..writeln('  Cache-Control: $immutable');
  }

  b.writeln('# END FLUTTER CACHE CONFIG');
  return b.toString();
}

String apacheConfig(List<String> hashed) {
  final b = StringBuffer()
    ..writeln('# BEGIN FLUTTER CACHE CONFIG')
    ..writeln('<IfModule mod_headers.c>')
    ..writeln('    # Varsayılan olarak tüm dosyalar no-cache olsun')
    ..writeln('    Header set Cache-Control "$noCache"')
    ..writeln()
    ..writeln('    <IfModule mod_setenvif.c>');

  for (final path in hashed) {
    // path örneğin: "/assets/AssetManifest.dc141a60.bin" şeklinde gelir.
    // Başındaki slash'ı kaldırıp, Request_URI sonunda bu yolun geçtiğini regex ile doğrulayalım.
    // Bu sayede /m/ alt klasöründe olsa bile tam dosya yolu kusursuz eşleşir.
    final cleanPath = path.startsWith('/') ? path.substring(1) : path;
    b.writeln(
      '        SetEnvIf Request_URI "${RegExp.escape(cleanPath)}\$" flutter_cache_immutable',
    );
  }

  b
    ..writeln('    </IfModule>')
    ..writeln(
      '    Header set Cache-Control "$immutable" env=flutter_cache_immutable',
    )
    ..writeln('</IfModule>')
    ..writeln('# END FLUTTER CACHE CONFIG');

  return b.toString();
}

String nginxConfig(List<String> hashed) {
  final b = StringBuffer()
    ..writeln('# Generated Flutter cache configuration')
    ..writeln();

  for (final path in hashed) {
    b
      ..writeln('location = $path {')
      ..writeln('    add_header Cache-Control "$immutable" always;')
      ..writeln('    try_files \$uri =404;')
      ..writeln('}')
      ..writeln();
  }

  b
    ..writeln('location / {')
    ..writeln('    add_header Cache-Control "$noCache" always;')
    ..writeln('    try_files \$uri \$uri/ /index.html;')
    ..writeln('}');

  return b.toString();
}

Future<void> updateMarkedFile(
  File file,
  String start,
  String end,
  String generated,
) async {
  var content = file.existsSync() ? await file.readAsString() : '';

  final startIndex = content.indexOf(start);
  final endIndex = content.indexOf(end);

  if ((startIndex == -1) != (endIndex == -1) ||
      (startIndex != -1 && endIndex < startIndex)) {
    throw FormatException('Bozuk otomatik yapılandırma bölümü: ${file.path}');
  }

  if (startIndex != -1) {
    content =
        content.substring(0, startIndex) +
        content.substring(endIndex + end.length);
  }

  final result = [
    if (content.trim().isNotEmpty) content.trimRight(),
    generated.trimRight(),
  ].join('\n\n');

  await file.writeAsString('$result\n');
}
