<?php if ( ! defined( 'ABSPATH' ) ) exit;
if(isset($PostID) && isset($_POST['servicebox_save_data_action']) ) {
			if (!wp_verify_nonce($_POST['wpsm_service_security'], 'wpsm_service_nonce_save_settings_values')) {
				die();
			}
			$TotalCount = count($_POST['service_title']);
			$ShortcodeArray = array();
			if($TotalCount) {
				for($i=0; $i < $TotalCount; $i++) {
					$service_title           = stripslashes(sanitize_text_field($_POST['service_title'][$i]));
					$service_description     = stripslashes(wp_kses_post($_POST['service_description'][$i]));
					$service_description     = str_replace('\\', '&#92;', $service_description);
					$service_icon            = sanitize_text_field($_POST['service_icon'][$i]);
					$service_link            = stripslashes(sanitize_text_field($_POST['service_link'][$i]));

					$ShortcodeArray[] = array(
						
						'service_title'           => $service_title,
						'service_description'     => $service_description,
						'service_icon'           => $service_icon,
						'service_link'           => $service_link,
						);
				}
				update_post_meta($PostID, 'wpsm_servicebox_data', serialize($ShortcodeArray));
				update_post_meta($PostID, 'wpsm_servicebox_count', $TotalCount);
			} else {
				$TotalCount = -1;
				update_post_meta($PostID, 'wpsm_servicebox_count', $TotalCount);
				$AccordionArray = array();
				update_post_meta($PostID, 'wpsm_servicebox_data', serialize($ShortcodeArray));
			}
		}
 ?>