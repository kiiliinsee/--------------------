<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Acme Themes
 * @subpackage Beauty Studio
 */
$no_blog_image = '';
global $beauty_studio_customizer_all_values;

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('init-animate'); ?>>
	<div class="content-wrapper">
		<?php
		$beauty_studio_hide_single_featured_image = beauty_studio_featured_image_display( get_the_ID() );
		if( has_post_thumbnail() && 'disable' != $beauty_studio_hide_single_featured_image):
			echo '<div class="single-feat clearfix"><figure class="single-thumb single-thumb-full">';
			the_post_thumbnail( $beauty_studio_hide_single_featured_image );
			echo "</figure></div>";
		else:
			$no_blog_image = 'no-image';
		endif;
		?>
		<div class="entry-content <?php echo $no_blog_image?>">
			<?php
			if ( 'post' === get_post_type() && has_category() ) : ?>
                <header class="entry-header <?php echo $no_blog_image; ?>">
                    <div class="entry-meta">
						<?php
						beauty_studio_cats_lists()
						?>
                    </div><!-- .entry-meta -->
                </header><!-- .entry-header -->
			<?php
			endif; ?>
            <div class="entry-header-title">
	            <?php
	            the_title( '<h1 class="entry-title">', '</h1>' );
	            ?>
            </div>
            <footer class="entry-footer">
	            <?php beauty_studio_entry_footer( ); ?>
            </footer><!-- .entry-footer -->
			<?php
			the_content();
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'beauty-studio' ),
				'after'  => '</div>',
			) );
            ?>
		</div><!-- .entry-content -->
	</div>
</article><!-- #post-## -->