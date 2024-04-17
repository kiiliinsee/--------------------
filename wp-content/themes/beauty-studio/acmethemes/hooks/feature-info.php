<?php
/**
 * Display Feature Columns
 * @since Beauty Studio 1.0.0
 *
 * @return void
 *
 */
if ( !function_exists('beauty_studio_feature_info') ) :
	function beauty_studio_feature_info() {
		global $beauty_studio_customizer_all_values;
		$beauty_studio_feature_info_number = $beauty_studio_customizer_all_values['beauty-studio-feature-info-number'];
		echo '<div class="info-icon-box-wrapper">';
		$column = $number = $beauty_studio_feature_info_number;

		$beauty_studio_basic_info_data = array();

		$beauty_studio_first_info_icon = $beauty_studio_customizer_all_values['beauty-studio-first-info-icon'] ;
		$beauty_studio_first_info_title = $beauty_studio_customizer_all_values['beauty-studio-first-info-title'];
		$beauty_studio_first_info_desc = $beauty_studio_customizer_all_values['beauty-studio-first-info-desc'];
		$beauty_studio_basic_info_data[] = array(
			"icon"  => $beauty_studio_first_info_icon,
			"title" => $beauty_studio_first_info_title,
			"desc"  => $beauty_studio_first_info_desc
		);

		$beauty_studio_second_info_icon = $beauty_studio_customizer_all_values['beauty-studio-second-info-icon'] ;
		$beauty_studio_second_info_title = $beauty_studio_customizer_all_values['beauty-studio-second-info-title'];
		$beauty_studio_second_info_desc = $beauty_studio_customizer_all_values['beauty-studio-second-info-desc'];
		$beauty_studio_basic_info_data[] = array(
			"icon"  => $beauty_studio_second_info_icon,
			"title" => $beauty_studio_second_info_title,
			"desc"  => $beauty_studio_second_info_desc
		);

		$beauty_studio_third_info_icon = $beauty_studio_customizer_all_values['beauty-studio-third-info-icon'] ;
		$beauty_studio_third_info_title = $beauty_studio_customizer_all_values['beauty-studio-third-info-title'];
		$beauty_studio_third_info_desc = $beauty_studio_customizer_all_values['beauty-studio-third-info-desc'];
		$beauty_studio_basic_info_data[] = array(
			"icon"  => $beauty_studio_third_info_icon,
			"title" => $beauty_studio_third_info_title,
			"desc"  => $beauty_studio_third_info_desc
		);

		$beauty_studio_forth_info_icon = $beauty_studio_customizer_all_values['beauty-studio-forth-info-icon'] ;
		$beauty_studio_forth_info_title = $beauty_studio_customizer_all_values['beauty-studio-forth-info-title'];
		$beauty_studio_forth_info_desc = $beauty_studio_customizer_all_values['beauty-studio-forth-info-desc'];
		$beauty_studio_basic_info_data[] = array(
			"icon"  => $beauty_studio_forth_info_icon,
			"title" => $beauty_studio_forth_info_title,
			"desc"  => $beauty_studio_forth_info_desc
		);

		if( $column == 1 ){
			$col= "col-md-12";
		}
        elseif( $column == 2 ){
			$col= "col-sm-6 col-md-6";
		}
        elseif( $column == 3 ){
			$col= "col-sm-4 col-md-4";
		}
		else{
			$col= "col-sm-3 col-md-3";
		}

		$col .= " init-animate zoomIn";

		$i=0;
		foreach ( $beauty_studio_basic_info_data as $base_basic_info_data) {
			if( $i >= $number ){
				break;
			}
			?>
            <div class="info-icon-box <?php echo $col;?>">
				<?php
				if( !empty( $base_basic_info_data['icon'])){
					?>
                    <div class="info-icon">
                        <i class="fa <?php echo esc_attr( $base_basic_info_data['icon'] );?>"></i>
                    </div>
					<?php
				}
				if( !empty( $base_basic_info_data['title']) || !empty( $base_basic_info_data['desc']) ){
					?>
                    <div class="info-icon-details">
						<?php
						if( !empty( $base_basic_info_data['title']) ){
							echo '<h6 class="icon-title">'.esc_html( $base_basic_info_data['title'] ).'</h6>';
						}
						if( !empty( $base_basic_info_data['desc']) ){
							echo '<span class="icon-desc">'.wp_kses_post( $base_basic_info_data['desc'] ).'</span>';
						}
						?>
                    </div>
					<?php
				}
				?>
            </div>
			<?php
			$i++;
		}
		echo "</div>";/*.infowrapper*/
	}
endif;
add_action( 'beauty_studio_action_feature_info', 'beauty_studio_feature_info', 20 );