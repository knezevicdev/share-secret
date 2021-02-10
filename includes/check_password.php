<?php

/**
 * @var DB $db;
 * @var Secret $secret
 */
include_once __DIR__ . '/../includes/get_secret.php';

$invalid_Password = false;
$is_post = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($secret->hasPassword() && !$secret->verifyPassword($_POST['password'])) {
        $invalid_Password = true;
    } else {
        $db->deleteSecret($secret->id);
        $is_post = true;
    }
}

?>

<?php if($invalid_Password): ?>
    <article class="message is-danger">
        <div class="message-body">
            Oops! Double check that password
        </div>
    </article>
<?php endif; ?>