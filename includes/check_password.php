<?php

/**
 * @var DB $db;
 * @var Secret $secret
 */
include_once __DIR__ . '/../includes/get_secret.php';

$invalid_Password = false;
$is_post = false;

if (isset($_SESSION['password_attempts']) &&
    isset($_SESSION['password_attempts'][$secret->id]) &&
    $_SESSION['password_attempts'][$secret->id] > 3) {
    end_with_message('You have been reached the attempts limit.', 'Error');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($secret->hasPassword() && !$secret->verifyPassword($_POST['password'])) {
        $invalid_Password = true;
        
        if (!isset($_SESSION['password_attempts'])) {
            $_SESSION['password_attempts'] = [];
        }

        if (!isset($_SESSION['password_attempts'][$secret->id])) {
            $_SESSION['password_attempts'][$secret->id] = 0;
        }

        $_SESSION['password_attempts'][$secret->id]++;
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