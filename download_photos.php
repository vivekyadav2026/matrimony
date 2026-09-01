<?php
$photos = [
    'rahul.jpg' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=600&auto=format&fit=crop&q=80',
    'bhagyashree.jpg' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=600&auto=format&fit=crop&q=80',
    'atul.jpg' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&auto=format&fit=crop&q=80'
];

$ctx = stream_context_create([
    'http' => [
        'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n"
    ]
]);

foreach ($photos as $filename => $url) {
    $data = @file_get_contents($url, false, $ctx);
    if ($data !== false) {
        file_put_contents(__DIR__ . '/images/' . $filename, $data);
        echo "Downloaded $filename (" . strlen($data) . " bytes)\n";
    } else {
        echo "Failed to download $filename\n";
    }
}
?>
