<?php
/**
 * Template Name: Dashboard - Settings
 */


$dokan_template_settings = Dokan_Template_Settings::init();

$validate = $dokan_template_settings->validate();

if( $validate !== false && !is_wp_error( $validate ) ) {
   $dokan_template_settings->insert_settings_info();
}

$scheme = is_ssl() ? 'https' : 'http';
wp_enqueue_script( 'google-maps', $scheme . '://maps.google.com/maps/api/js?sensor=true' );

get_header();
?>

<?php dokan_get_template( __DIR__ . '/dashboard-nav.php', array( 'active_menu' => 'settings' ) ); ?>

<div id="primary" class="content-area col-md-10">
    <div id="content" class="site-content" role="main">

        <?php while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <?php the_content(); ?>
                </div><!-- .entry-content -->

                <?php if ( is_wp_error( $validate ) ) {
                    $messages = $validate->get_error_messages();

                    foreach( $messages as $message ) {
                        ?>
                        <div class="alert alert-danger" style="width: 40%; margin-left: 25%;">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong><?php echo $message; ?></strong>
                        </div>

                        <?php
                    }
                } ?>

                <?php $dokan_template_settings->setting_field($validate); ?>
            </article>

        <?php endwhile; // end of the loop. ?>

    </div><!-- #content .site-content -->
</div><!-- #primary .content-area -->

<?php get_footer(); ?>