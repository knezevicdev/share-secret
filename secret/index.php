<?php include_once __DIR__ . '/../includes/header.php'; ?>

<?php

/**
 * @var string $nonce
 */
include_once __DIR__ . '/../includes/check_nonce.php';
/**
 * @var Secret $secret
 */
include_once __DIR__ . '/../includes/get_secret.php';
/**
 * @var boolean $is_post
 * @var boolean $invalid_Password
 */
include_once __DIR__ . '/../includes/check_password.php';

?>

<?php if ($is_post && !$invalid_Password): ?>
    <div class="field">
        <label class="label">Message:</label>
        <div class="control">
            <div class="textarea pre-wrap copy-content" id="message_content"><?php echo $secret->getContent(); ?></div>
            <button class="button is-small copy-button">copy</button>
            <p class="help is-dark has-text-weight-bold">(careful: we will only show it once.)</p>
        </div>
    </div>

    <hr />

    <a class="button is-info is-fullwidth" href="/">Share new secret</a>
<?php else: ?>

    <form method="post" autocomplete="off" action="<?php echo $secret->viewUrl(); ?>">
        <input type="hidden" name="nonce" value="<?php echo $nonce; ?>">
        <?php if ($secret->hasPassword()): ?>
            <div class="control mb-2">
                <label class="label">This message requires a password: </label>
                <input type="password" class="input" name="password" id="password" placeholder="Enter the password here" />
            </div>
        <?php endif; ?>
        <div class="control">
            <?php if (!$secret->hasPassword()): ?>
                <label class="label">Click to continue: </label>
            <?php endif; ?>
            <button class="button is-info is-fullwidth" type="submit">View Secret</button>
            <p class="help is-dark has-text-weight-bold">(careful: we will only show it once.)</p>
        </div>
    </form>

<?php endif; ?>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
