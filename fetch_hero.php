<?php
$banner_urls = [
    'hero_bg.jpg' => 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=1920&auto=format&fit=crop&q=90',
    'hero_bg2.jpg' => 'https://images.unsplash.com/photo-1519741497674-611481863552?w=1920&auto=format&fit=crop&q=90'
];

$ctx = stream_context_create([
    'http' => [
        'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n"
    ]
]);

foreach ($banner_urls as $filename => $url) {
    $data = @file_get_contents($url, false, $ctx);
    if ($data !== false) {
        file_put_contents(__DIR__ . '/images/' . $filename, $data);
        echo "Downloaded $filename (" . strlen($data) . " bytes)\n";
    } else {
        echo "Failed to download $filename\n";
    }
}
?>
