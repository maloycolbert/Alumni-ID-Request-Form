<?php
/**
 * Template Name: Alumni Card Request Template
 * Template Post Type: page
 * @package WordPress
 * @subpackage Alumni Theme
 * @since Alumni 1.0
*/

$env = 'www';
if(strstr($_SERVER['HTTP_HOST'], 'dev.')) {
    $env = 'dev';
} else if (strstr($_SERVER['HTTP_HOST'], 'test.')) {
    $env = 'test';
}

global $GTM_code_g;

// Include our functions
require_once get_stylesheet_directory() .'/inc/request-id-form/inc_rif_functions.php';
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <?php if (!empty($GTM_code_g)) : 
        // Include GTM container script if GTM Code field has a value ?>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','<?= $GTM_code_g ?>');</script>
        <!-- End Google Tag Manager -->
    <?php endif; ?>

    <script defer src="https://<?=$env?>.liberty.edu/ux-global-header/ux-global-header.js"></script>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <link rel="shortcut icon" type="image/x-icon" href="https://www.liberty.edu/favicon.ico" />
    <link rel="stylesheet" href="<?php echo get_theme_file_uri(); ?>/styles/min/id-card-request.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri();?>/js/cinch-2.8.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri();?>/js/requestIDForm.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri();?>/js/mylu_v2.js"></script>
</head>

<header id="global-header" data-prop-right="16" data-prop-top="84" data-prop-position="absolute" data-prop-site="edu"></header>

<body id="alumni-forms" class="rif-form">

    <?php if (!empty($GTM_code_g)) : ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?=$GTM_code_g?>"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php endif; ?>

    <ul class="heading">
        <li class="wordmark"><a tabindex="-1" role="link" href="<?=bloginfo('url');?>" title="Liberty Alumni">
            <img src="<?php echo get_stylesheet_directory_uri() . '/img/request_id_form/Wordmark.svg'; ?>"
            alt="Liberty University" title="Liberty Alumni"></a></li>
    </ul>
    <main class="container">
        <section id="rif-container-wrapper">
        <?php
        if((check_status($environment) === false) || $_GET['offline']) {

            require_once(get_stylesheet_directory().'/inc/request-id-form/inc_offline.php');
            return;

        } else {
            
            if(isset($_POST['my_lu_error']) || $_GET['myluerror']) {
                echo '<form action="'. current_location() .'" class="validate" id="rif-form " method="POST" name="mylu_error">';
                require_once(get_stylesheet_directory().'/inc/request-id-form/inc_mylu_error.php');
                echo '<input type="hidden" name="redirect-uri" id="redirect-uri" value="'.mylu_redirect_uri($environment).'"/>';
                echo '</form>';
                return;
            }

            if(isset($_GET['issues'])) {
                echo '<form action="'. current_location() .'" class="validate" id="rif-form" method="POST">';
                require_once(get_stylesheet_directory().'/inc/request-id-form/inc_issues.php');
                echo '</form>';
                return;
            }

            if(isset($_GET['submitted'])) {
                require_once(get_stylesheet_directory().'/inc/request-id-form/inc_submitted.php');
                return;
            }

            if(isset($_POST['main'])) {
                echo '<form action="'.get_site_url().'/wp-content/themes/wp-alumni-theme/inc/request-id-form/inc_xml.php" 
                    class="validate main-rif-form" id="rif-form" method="POST" name="form">';
                require_once(get_stylesheet_directory().'/inc/request-id-form/inc_form.php');
                echo '</form>';
                return;
            }

            if((isset($_GET['code'])) || ($_GET['testcode'])) {
                echo '<form action="'. current_location() .'" class="validate" id="rif-form" method="POST" name="start">';
                require_once(get_stylesheet_directory().'/inc/request-id-form/inc_loading.php');
                echo '<input type="hidden" name="redirect-uri" id="redirect-uri" value="'.mylu_redirect_uri($environment).'"/>';
                echo '</form>';
                return;
            }

            if((count($_POST) == 0)){
                echo '<form action="'. current_location() .'" class="validate" id="rif-form" method="POST" name="start">';
                require_once(get_stylesheet_directory().'/inc/request-id-form/inc_start.php');
                echo '<input type="hidden" name="redirect-uri" id="redirect-uri" value="'.mylu_redirect_uri($environment).'"/>';
                echo '</form>';
                return;
            }
        }
        ?>
        </section>
    </main>
</body>
<?php
if(isset($_POST)) { unset($_POST); }
?>