<?php include_once __DIR__ . '/includes/header.php'; ?>

<?php
/**
 * @var string $nonce
 */
include_once __DIR__ . '/includes/check_nonce.php';
?>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (empty($_POST['secret']) || empty(trim($_POST['secret']))) {
            end_with_message("Invalid request.");
        }

        include_once __DIR__ . '/includes/db.php';

        $db = new DB();
        if ($secret_id = $db->createSecret($_POST['secret'], $_POST['password'])) {
            $_SESSION['private'] = $secret_id;
            header("location: private?secret={$secret_id}");
            exit();
        } else {
            end_with_message("Something went wrong. Please try again later.");
        }
    }
?>

<h1 class="title is-4 has-text-centered">Paste a password, secret message or private link below.</h1>
<div class="subtitle is-6 has-text-centered">Keep sensitive info out of your email and chat logs.</div>
<form method="post" autocomplete="off" action="/">
    <input type="hidden" name="nonce" value="<?php echo $nonce; ?>">
    <div class="field">
        <label for="secret" class="label">Secret</label>
        <div class="control">
            <textarea class="textarea" maxlength='100000' id="secret" name="secret"></textarea>
            <span class="is-size-6 has-text-weight-bold has-text-grey letter-counter" id="letter-counter">100000</span>
        </div>
    </div>
    <div class="field">
        <label for="password" class="label">Password</label>
        <div class="control">
            <input type="text" class="input" name="password" id="password" />
        </div>
    </div>
    <div class="control">
        <button class="button is-info is-fullwidth">Share a secret</button>
    </div>
</form>
<script>
    (function () {
        const textarea = document.getElementById("secret");
        const letterCounter = document.getElementById('letter-counter');

        textarea.addEventListener("input", event => {
            const target = event.currentTarget;
            const maxLength = target.getAttribute("maxlength");
            const currentLength = target.value.length;

            if (currentLength >= maxLength) {
                return console.log("You have reached the maximum number of characters.");
            }

            letterCounter.innerText = maxLength - currentLength;
        });
    })();
</script>
<?php include_once __DIR__ . '/includes/footer.php'; ?>
