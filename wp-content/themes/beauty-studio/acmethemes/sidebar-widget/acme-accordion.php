<?php
/**
 * Class for adding Accordion Section Widget
 *
 * @package Acme Themes
 * @subpackage Beauty Studio
 * @since 1.0.0
 */
if ( ! class_exists( 'Beauty_Studio_Accordion' ) ) {

    class Beauty_Studio_Accordion extends WP_Widget {
        /*defaults values for fields*/
        private $defaults = array(
            'unique_id'             => '',
            'title'                 => '',
            'at_all_page_items'     => '',
            'background_options'    => 'gray',

            'content_from'          => 'excerpt',
            'content_number'        => -1
        );

        function __construct() {
            parent::__construct(
                    /*Base ID of your widget*/
                    'beauty_studio_accordion',
                    /*Widget name will appear in UI*/
                    esc_html__('AT Accordion Section', 'beauty-studio'),
                    /*Widget description*/
                    array(
                            'description' => esc_html__( 'Suitable for FAQ and or other Accordion', 'beauty-studio' )
                    )
            );
        }

        /*Widget Backend*/
        public function form( $instance ) {
            $instance               = wp_parse_args( (array) $instance, $this->defaults );
            /*default values*/
            $unique_id              = esc_attr( $instance['unique_id'] );

	        $title                  = esc_attr( $instance['title'] );
	        $at_all_page_items      = $instance['at_all_page_items'];
	        $content_from           = esc_attr( $instance['content_from'] );
	        $content_number         = intval( $instance['content_number'] );
	        $background_options     = esc_attr( $instance['background_options'] );
	        ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'unique_id' ) ); ?>"><?php esc_html_e( 'Section ID', 'beauty-studio' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'unique_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'unique_id' ) ); ?>" type="text" value="<?php echo $unique_id; ?>" />
                <br />
                <small><?php esc_html_e('Enter a Unique Section ID. You can use this ID in Menu item for enabling One Page Menu.','beauty-studio')?></small>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'beauty-studio' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $title; ?>" />
            </p>

            <!--updated code-->
            <label><?php esc_html_e( 'Select Pages', 'beauty-studio' ); ?></label>
            <br/>
            <small><?php esc_html_e( 'Add Page, Reorder and Remove', 'beauty-studio' ); ?></small>
            <div class="at-repeater">
		        <?php
		        $total_repeater = 0;
		        if  ( is_array($at_all_page_items) && count($at_all_page_items) > 0 ){
			        foreach ($at_all_page_items as $about){
				        $repeater_id  = $this->get_field_id( 'at_all_page_items') .$total_repeater.'page_id';
				        $repeater_name  = $this->get_field_name( 'at_all_page_items' ).'['.$total_repeater.']['.'page_id'.']';
				        ?>
                        <div class="repeater-table">
                            <div class="at-repeater-top">
                                <div class="at-repeater-title-action">
                                    <button type="button" class="at-repeater-action">
                                        <span class="at-toggle-indicator" aria-hidden="true"></span>
                                    </button>
                                </div>
                                <div class="at-repeater-title">
                                    <h3><?php esc_html_e( 'Select Item', 'beauty-studio' )?><span class="in-at-repeater-title"></span></h3>
                                </div>
                            </div>
                            <div class='at-repeater-inside hidden'>
						        <?php
						        /* see more here https://codex.wordpress.org/Function_Reference/wp_dropdown_pages*/
						        $args = array(
							        'selected'          => $about['page_id'],
							        'name'              => $repeater_name,
							        'id'                => $repeater_id,
							        'class'             => 'widefat at-select',
							        'show_option_none'  => esc_html__( 'Select Page', 'beauty-studio'),
							        'option_none_value' => 0 // string
						        );
						        wp_dropdown_pages( $args );
						        ?>
                                <div class="at-repeater-control-actions">
                                    <button type="button" class="button-link button-link-delete at-repeater-remove"><?php esc_html_e('Remove','beauty-studio');?></button> |
                                    <button type="button" class="button-link at-repeater-close"><?php esc_html_e('Close','beauty-studio');?></button>
	                                <?php
	                                if( get_edit_post_link( $about['page_id'] ) ){
		                                ?>
                                        <a class="button button-link at-postid alignright" target="_blank" href="<?php echo esc_url( get_edit_post_link( $about['page_id'] ) ); ?>">
			                                <?php esc_html_e('Full Edit','beauty-studio');?>
                                        </a>
		                                <?php
	                                }
	                                ?>
                                </div>
                            </div>
                        </div>
				        <?php
				        $total_repeater = $total_repeater + 1;
			        }
		        }
		        $coder_repeater_depth = 'coderRepeaterDepth_'.'0';
		        $repeater_id  = $this->get_field_id( 'at_all_page_items') .$coder_repeater_depth.'page_id';
		        $repeater_name  = $this->get_field_name( 'at_all_page_items' ).'['.$coder_repeater_depth.']['.'page_id'.']';
		        ?>
                <script type="text/html" class="at-code-for-repeater">
                    <div class="repeater-table">
                        <div class="at-repeater-top">
                            <div class="at-repeater-title-action">
                                <button type="button" class="at-repeater-action">
                                    <span class="at-toggle-indicator" aria-hidden="true"></span>
                                </button>
                            </div>
                            <div class="at-repeater-title">
                                <h3><?php esc_html_e( 'Select Item', 'beauty-studio' )?><span class="in-at-repeater-title"></span></h3>
                            </div>
                        </div>
                        <div class='at-repeater-inside hidden'>
					        <?php
					        /* see more here https://codex.wordpress.org/Function_Reference/wp_dropdown_pages*/
					        $args = array(
						        'selected'          => '',
						        'name'              => $repeater_name,
						        'id'                => $repeater_id,
						        'class'             => 'widefat at-select',
						        'show_option_none'  => esc_html__( 'Select Page', 'beauty-studio'),
						        'option_none_value' => 0 // string
					        );
					        wp_dropdown_pages( $args );
					        ?>
                            <div class="at-repeater-control-actions">
                                <button type="button" class="button-link button-link-delete at-repeater-remove"><?php esc_html_e('Remove','beauty-studio');?></button> |
                                <button type="button" class="button-link at-repeater-close"><?php esc_html_e('Close','beauty-studio');?></button>
                            </div>
                        </div>
                    </div>

                </script>
		        <?php
		        /*most imp for repeater*/
		        echo '<input class="at-total-repeater" type="hidden" value="'.$total_repeater.'">';
		        $add_field = esc_html__('Add Item', 'beauty-studio');
		        echo '<span class="button-primary at-add-repeater" id="'.$coder_repeater_depth.'">'.$add_field.'</span><br/>';
		        ?>
            </div>
            <!--updated code-->
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'content_from' ) ) ; ?>"><?php esc_html_e( 'Content From', 'beauty-studio' ); ?></label>
                <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'content_from' )); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content_from' ) ); ?>">
			        <?php
			        $beauty_studio_about_content_from = beauty_studio_content_from();
			        foreach ( $beauty_studio_about_content_from as $key => $value ) {
				        ?>
                        <option value="<?php echo esc_attr( $key ) ?>" <?php selected( $key, $content_from ); ?>><?php echo esc_html( $value ); ?></option>
				        <?php
			        }
			        ?>
                </select>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'content_number' ) ); ?>"><?php esc_html_e( 'Number of words in content', 'beauty-studio' ); ?></label>
                <br/>
                <small>
			        <?php esc_html_e('Please enter -1 to show full content or 0 to show none','beauty-studio'); ?>
                </small>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'content_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content_number' ) ); ?>" type="number" value="<?php echo $content_number; ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'background_options' ) ); ?>"><?php esc_html_e( 'Background Options', 'beauty-studio' ); ?></label>
                <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'background_options' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'background_options' ) ); ?>">
			        <?php
			        $beauty_studio_background_options = beauty_studio_background_options();
			        foreach ( $beauty_studio_background_options as $key => $value ) {
				        ?>
                        <option value="<?php echo esc_attr( $key ) ?>" <?php selected( $key, $background_options ); ?>><?php echo esc_html( $value ); ?></option>
				        <?php
			        }
			        ?>
                </select>
            </p>
            <?php
        }

        /**
         * Function to Updating widget replacing old instances with new
         *
         * @access public
         * @since 1.0
         *
         * @param array $new_instance new arrays value
         * @param array $old_instance old arrays value
         * @return array
         *
         */
        public function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['unique_id']    = sanitize_key( $new_instance['unique_id'] );

	        $instance['title']        = sanitize_text_field( $new_instance['title'] );

	        /*updated code*/
	        $page_ids = array();
	        if( isset($new_instance['at_all_page_items'] )){
		        $at_all_page_items    = $new_instance['at_all_page_items'];
		        if  ( is_array($at_all_page_items) && count($at_all_page_items) > 0 ){
			        foreach ($at_all_page_items as $key=>$about ){
				        $page_ids[$key]['page_id'] = beauty_studio_sanitize_page( $about['page_id'] );
			        }
		        }
	        }
	        $instance['at_all_page_items'] = $page_ids;

	        $beauty_studio_about_content_from   = beauty_studio_content_from();
	        $instance['content_from']           = beauty_studio_sanitize_choice_options( $new_instance['content_from'], $beauty_studio_about_content_from, 'excerpt' );

	        $instance['content_number']         = intval( $new_instance['content_number'] );

	        $beauty_studio_widget_background_options    = beauty_studio_background_options();
	        $instance['background_options']             = beauty_studio_sanitize_choice_options( $new_instance['background_options'], $beauty_studio_widget_background_options, 'default' );

	        return $instance;
        }

        /**
         * Function to Creating widget front-end. This is where the action happens
         *
         * @access public
         * @since 1.0
         *
         * @param array $args widget setting
         * @param array $instance saved values
         * @return void
         *
         */
        public function widget($args, $instance) {
            $instance = wp_parse_args( (array) $instance, $this->defaults);

            /*default values*/
            $unique_id          = !empty( $instance['unique_id'] ) ? esc_attr( $instance['unique_id'] ) : esc_attr( $this->id );

	        $title              = apply_filters( 'widget_title', !empty( $instance['title'] ) ? $instance['title'] : '', $instance, $this->id_base );
	        $at_all_page_items  = $instance['at_all_page_items'];
	        $content_from       = esc_attr( $instance['content_from'] );
	        $content_number     = intval( $instance['content_number'] );
	        $background_options = esc_attr( $instance['background_options'] );
	        $bg_gray_class      = $background_options == 'gray'?'at-gray-bg':'';

	        $animation = "init-animate zoomIn";
	        echo $args['before_widget'];
            ?>
            <section id="<?php echo esc_attr( $unique_id );?>" class="at-widgets acme-accordions <?php echo $bg_gray_class;?>">
                <div class="container">
	              <?php
                    if( ! empty( $title ) ){
                        echo "<div class='at-widget-title-wrapper'>";
                        if ( ! empty( $title ) ) {
                            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
                        }
                        echo "</div>";
                    }
	                ?>
                    <div class="row">
                        <?php
                        $col= 'col-sm-12';
                        ?>
                        <div class="<?php echo $col;?>">
                            <div class="accordion-content">
	                            <?php
	                            $post_in = array();
	                            if  ( is_array($at_all_page_items) && count($at_all_page_items) > 0 ){
		                            foreach ( $at_all_page_items as $about ){
			                            if( isset( $about['page_id'] ) && !empty( $about['page_id'] ) ){
				                            $post_in[] = $about['page_id'];
			                            }
		                            }
	                            }
	                            if( !empty ( $post_in ) ) :
		                            $beauty_studio_post_in_page_args = array(
			                            'post__in'          => $post_in,
			                            'orderby'           => 'post__in',
			                            'posts_per_page'    => count( $post_in ),
			                            'post_type'         => 'page',
			                            'no_found_rows'     => true,
			                            'post_status'       => 'publish'
		                            );
		                            $accordion_query = new WP_Query( $beauty_studio_post_in_page_args );
		                            /*The Loop*/
		                            if ( $accordion_query->have_posts() ):
                                        $i=1;
			                            while( $accordion_query->have_posts() ):$accordion_query->the_post();
				                            $accordion_icon = $i!=1?'fa-plus':'fa-minus'
				                            ?>
                                            <div class="accordion-item <?php echo esc_attr( $animation );?>">
					                            <?php
                                                the_title( sprintf( '<h3 class="accordion-title"><a href="%s" rel="bookmark"><i class="accordion-icon fa '.$accordion_icon.'"></i>', esc_url( get_permalink() ) ), '</a></h3>' );
	                                            if( 0 != $content_number ){
		                                            ?>
                                                    <div class="accordion-details">
                                                        <?php
                                                        beauty_studio_advanced_content( $content_number, $content_from );
                                                        ?>
                                                    </div>
		                                            <?php
	                                            }
	                                            ?>
                                            </div>
				                            <?php
                                        $i++;
			                            endwhile;
		                            endif;
		                            wp_reset_postdata();
	                            endif;
	                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php
            echo $args['after_widget'];
        }
    } // Class Beauty_Studio_Accordion ends here
}