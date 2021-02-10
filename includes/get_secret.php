<?php

if (!isset($_GET['secret'])) {
    end_with_message('Invalid request.');
}

include_once __DIR__ . '/../includes/db.php';

$db = new DB();
/** @var Secret $secret */
$secret = $db->getSecret($_GET['secret']);

if (!$secret || $secret->expired) {
    end_with_message('It either never existed or has already been viewed.', 'Unknown Secret');
}
