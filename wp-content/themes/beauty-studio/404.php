<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Acme Themes
 * @subpackage Beauty Studio
 */
get_header();
global $beauty_studio_customizer_all_values;
?>
<div class="wrapper inner-main-title">
	<?php
	echo beauty_studio_get_header_normal_image();
	?>
	<div class="container">
		<header class="entry-header init-animate">
			<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'beauty-studio' ); ?></h1>
			<?php
			if( 1 == $beauty_studio_customizer_all_values['beauty-studio-show-breadcrumb'] ){
				beauty_studio_breadcrumbs();
			}
			?>
		</header>
	</div>
</div>
<div id="content" class="site-content container clearfix">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<section class="error-404 not-found">
				<div class="page-content">
                    <h2><?php esc_html_e('404','beauty-studio'); ?><span><?php esc_html_e('Sorry! We could not found that page','beauty-studio'); ?></span></h2>
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'beauty-studio' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- #content -->
<?php get_footer();