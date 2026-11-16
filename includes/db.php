<?php
$pdo = new PDO(
    'sqlite:' . __DIR__ . '/../database/rewards.db',
    options: [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ],
);
