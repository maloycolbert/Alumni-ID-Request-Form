<div class="container issue">
    <ul class="text-center">
        <li><a tabindex="-1" role="link" href="<?=bloginfo('url');?>" title="Liberty Alumni"><img class="alumni-icon"
        src="<?php echo get_stylesheet_directory_uri() . '/img/request_id_form/LU_Alumni_blue.svg'; ?>" alt="LU Alumni Icon" title="LU Alumni Icon"></a></li>
        <h2>Digital ID Card Request</h2>
        <p class="receive-id">Fill out this form to receive your very own Alumni Identification card.</p>
    </ul>
    <div class="error-box">
        <p><strong>We couldn't log you in.</strong></p>
        <p>There was a small glitch on our end. Please try logging in again.</p>
        </li>
    </div>
    <section class="start-group">
        <?php require_once('inc_login.php') ?>
    </section>
</div>