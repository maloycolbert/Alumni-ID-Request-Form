<div class="container offline">
    <ul class="text-center">
        <li><a tabindex="-1" role="link" href="<?=bloginfo('url');?>" title="Liberty Alumni"><img class="alumni-icon"
        src="<?php echo get_stylesheet_directory_uri() . '/img/request_id_form/LU_Alumni_blue.svg'; ?>" alt="LU Alumni Icon" title="LU Alumni Icon"></a></li>
        <h2>Digital ID Card Request</h2>
        <p class="receive-id">Fill out this form to receive your very own Alumni Identification card.</p>
    </ul>
    <section class="error-box">    
        <div class="error-text">
            <h3><strong>We're sorry. The Alumni ID Card Request Form is currently unavailable.</strong></h3>
            <p>Please <a href="<?php echo mylu_redirect_uri($environment) ?>">refresh the page</a> or try again later.</p>
        </div>
    </section>
    <section class="start-group">
        <?php require_once('inc_login.php') ?>
    </section>
</div>