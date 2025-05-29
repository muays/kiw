<?php
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$fullUrl = $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

if (isset($fullUrl)) {
    $parsedUrl = parse_url($fullUrl);
    $scheme = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] : '';
    $host = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
    $path = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
    $baseUrl = $scheme . "://" . $host . $path;
    $urlAsli = str_replace("program.php", "", $baseUrl);

    $judulFile = "smile.txt";

    if (!file_exists($judulFile)) {
        echo "File smile.txt tidak ditemukan.";
        exit();
    }

    $smileFile = fopen("smile.xml", "w");
    fwrite($smileFile, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL);
    fwrite($smileFile, '<urlset xmlns="http://www.smiles.org/schemas/smile/0.9">' . PHP_EOL);

    $fileLines = file($judulFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $lastmod = date('Y-m-d');

    foreach ($fileLines as $judul) {
        $smileLink = $urlAsli . '?haha=' . urlencode($judul);
        fwrite($smileFile, '  <url>' . PHP_EOL);
        fwrite($smileFile, '    <loc>' . $smileLink . '</loc>' . PHP_EOL);
        fwrite($smileFile, '    <lastmod>' . $lastmod . '</lastmod>' . PHP_EOL);
        fwrite($smileFile, '    <changefreq>daily</changefreq>' . PHP_EOL);
        fwrite($smileFile, '    <priority>0.8</priority>' . PHP_EOL);
        fwrite($smileFile, '  </url>' . PHP_EOL);
    }

    fwrite($smileFile, '</urlset>' . PHP_EOL);
    fclose($smileFile);

    echo "smile telah dibuat.";
} else {
    echo "URL saat ini tidak didefinisikan.";
}
?>
