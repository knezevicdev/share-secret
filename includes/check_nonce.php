<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['nonce'])) {
        end_with_message("Invalid request.");
    }

    $found_nonce = array_search($_POST['nonce'], $_SESSION['nonce']);
    if ($found_nonce === false) {
        end_with_message("Invalid request.");
    }
    unset($_SESSION['nonce'][$found_nonce]);
}

use Ramsey\Uuid\Uuid;

$nonce = Uuid::uuid4();

if (!isset($_SESSION['nonce'])) $_SESSION['nonce'] = [];
$_SESSION['nonce'] [] = $nonce->toString();
