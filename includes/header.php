<!DOCTYPE html>
<html>
<head>
    <title>Share a secret</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link rel="stylesheet" href="/style.css">
</head>
<body>
<main class="container">
<div class="section">
<div class="columns">
<div class="column is-one-fifth"></div>
<div class="column is-three-fifths">
<?php

function end_with_message($message, $title = NULL) {
    ?>
        <?php if($title): ?>
            <h1 class="title is-4 has-text-centered"><?php echo $title; ?></h1>
        <?php endif; ?>
        <article class="message is-warning">
            <div class="message-body">
                <?php echo $message; ?>
            </div>
        </article>
        <a class="button is-info is-fullwidth" href="/">Share new secret</a>
    <?php

    include_once __DIR__ . '/footer.php';
    exit();
}

require __DIR__ . '/../vendor/autoload.php';
