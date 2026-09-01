<?php
$host = 'localhost';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS `manglik_matrimony_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `manglik_matrimony_db`");

    // Table: Success Stories
    $pdo->exec("CREATE TABLE IF NOT EXISTS `success_stories` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(150) NOT NULL,
        `story` TEXT NOT NULL,
        `photo` VARCHAR(255) NOT NULL,
        `story_date` VARCHAR(50) DEFAULT '',
        `status` ENUM('active', 'inactive') DEFAULT 'active',
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB");

    // Reset & Seed Success Stories with clean high-res photos
    $pdo->exec("DELETE FROM `success_stories`");
    $seedStories = [
        ['ANIT & TRILOK', 'Found my soulmate through Sainmatrimony.in. The verified profiles made our matchmaking smooth and trustworthy.', 'story1.jpg', '15 August 2024'],
        ['DEVESH & POOJA', 'Best matrimony platform for mangliks! We connected easily and families agreed immediately.', 'story2.jpg', '10 September 2024'],
        ['PREETI & AMRIK', 'We got married with blessings of family and Sainmatrimony.in. Truly thankful for this wonderful platform.', 'story3.jpg', '04 November 2024'],
        ['BALVINDER & SAKSHI', 'Highly recommended site for finding genuine soulmates. Easy search & quick response.', 'story4.jpg', '18 December 2024']
    ];

    $insStory = $pdo->prepare("INSERT INTO `success_stories` (`title`, `story`, `photo`, `story_date`) VALUES (?, ?, ?, ?)");
    foreach ($seedStories as $s) {
        $insStory->execute($s);
    }

    echo "Success stories database records updated!";

} catch (PDOException $e) {
    echo "Database Setup Error: " . $e->getMessage();
}
?>
