<?php include_once __DIR__ . '/../includes/header.php'; ?>

<?php

session_start();

/**
 * @var Secret $secret
 */
include_once __DIR__ . '/../includes/get_secret.php';
?>

<?php if (isset($_SESSION['private']) && $secret->id === $_SESSION['private']) :?>

    <?php
        unset($_SESSION['private']);
    ?>

    <div class="field">
        <label class="label">Share this link</label>
        <div class="control">
            <input class="input copy-content" type="text" readonly value="<?php echo $secret->viewUrl(); ?>" id="secret_url" />
            <button class="button is-small copy-button">copy</button>
            <?php if($secret->hasPassword()): ?>
                <p class="help is-dark has-text-weight-bold	">Requires a password.</p>
            <?php endif; ?>
        </div>
    </div>


    <?php if($secret->hasPassword()): ?>
        <div class="field">
            <label class="label">Secret (<?php echo $secret->smallid; ?>)</label>
            <div class="control">
                <input class="input" disabled value="This message is encrypted with your password."/>
            </div>
        </div>
    <?php else: ?>
        <div class="field">
            <label class="label">Secret (<?php echo $secret->smallid; ?>)</label>
            <div class="control">
                <div class="textarea pre-wrap copy-content" id="message_content"><?php echo $secret->getContent(); ?></div>
                <button class="button is-small copy-button">copy</button>
            </div>
        </div>
    <?php endif; ?>

    <script>

    </script>

<?php else: ; ?>

    <div class="field">
        <label class="label">Secret (<?php echo $secret->smallid; ?>)</label>
        <div class="control">
            <input class="input" disabled value="*******************"/>
        </div>
    </div>

<?php endif; ?>

<span class="title is-5 has-text-centered">
    Expires in <?php echo $secret->expireTime->longAbsoluteDiffForHumans(); ?>.
    <span class="subtitle is-6">(<?php echo $secret->expireTime->toDateTimeString(); ?>)</span>
</span>

<hr/>

<a class="button is-fullwidth" href="<?php echo $secret->deleteUrl(); ?>">Delete this secret</a>

<hr />

<a class="button is-info is-fullwidth" href="/">Share new secret</a>


<?php include_once __DIR__ . '/../includes/footer.php'; ?>
