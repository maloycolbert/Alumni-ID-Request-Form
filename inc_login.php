<div class="container login">
    <section class="banner-group">
        <section class="links-group">
            <ul>
                <li id="mainStart"><a href="<?php echo mylu_link($environment); ?>" title="Continue with Liberty Login" class="btn blue">Continue with Liberty Login</a> </li>
            </ul>
        <ul class="text-center">
            <li class="please-note"><em>Logging in with your Liberty login will pre-fill the form for you.</em></li>
        </ul>
        <ul class="text-center">
            <form method="POST">
            <button name="main" type="submit" class="skip-login" value="1">Skip Login</button>
            </form>
        </ul>
        </section>
        <section class="info-group">
            <?php require_once('inc_info.php') ?>
        </section>
    </section>
</div>