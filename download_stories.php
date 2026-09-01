<?php
$stories_photos = [
    'story1.jpg' => 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=600&auto=format&fit=crop&q=80',
    'story2.jpg' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=600&auto=format&fit=crop&q=80',
    'story3.jpg' => 'https://images.unsplash.com/photo-1609357605129-26f69add5d6e?w=600&auto=format&fit=crop&q=80',
    'story4.jpg' => 'https://images.unsplash.com/photo-1519741497674-611481863552?w=600&auto=format&fit=crop&q=80'
];

$ctx = stream_context_create([
    'http' => [
        'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n"
    ]
]);

foreach ($stories_photos as $filename => $url) {
    $data = @file_get_contents($url, false, $ctx);
    if ($data !== false) {
        file_put_contents(__DIR__ . '/images/' . $filename, $data);
        echo "Downloaded $filename (" . strlen($data) . " bytes)\n";
    } else {
        echo "Failed to download $filename\n";
    }
}
?>
