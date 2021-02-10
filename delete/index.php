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
 */
include_once __DIR__ . '/../includes/check_password.php';

if ($is_post) {
    header("location: /");
    exit();
}

?>

<form method="post" autocomplete="off" action="<?php echo $secret->deleteUrl(); ?>">
    <input type="hidden" name="nonce" value="<?php echo $nonce; ?>">
    <div class="field">
        <label for="password" class="label">Secret: <?php echo $secret->smallid; ?></label>
        <?php if($secret->hasPassword()): ?>
            <div class="control">
                <input type="password" class="input" name="password" id="password" placeholder="Enter the password here" />
            </div>
        <?php endif; ?>
    </div>

    <div class="control mb-2 mt-5">
        <button class="button is-danger is-fullwidth" type="submit">Confirm: Delete this secret</button>
    </div>

    <div class="control">
        <a class="button is-fullwidth" href="<?php echo $secret->privateUrl(); ?>">Cancel</a>
    </div>

</form>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
