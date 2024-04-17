<?php

class SLB_Discount_Admin_ExportDiscountsCsv{

    public static function init_hooks(){
        add_action('sln.tools.export_button', array('SLB_Discount_Admin_ExportDiscountsCsv','hook_tools_export_button'));
        add_action('sln.tools.export_csv', array('SLB_Discount_Admin_ExportDiscountsCsv', 'hook_export'));
    }

    public static function hook_export($data){
        if(isset($data['sln-tools-export-discounts'])){
            self::export($data);
        }
    }

    public static function export($data){
        $format = SLN_Plugin::getInstance()->format();
        $from = $data['export']['from'];
        $from = SLN_Func::filter($from, 'date').' 00:00:00';

        $to = $data['export']['to'];
        $to = SLN_Func::filter($to, 'date').' 23:59:59';

        $criteria['@wp_query'] = array(
            'post_type' => SLB_Discount_Plugin::POST_TYPE_DISCOUNT,
            'nopaging' => true,
            'meta_query' => array(
                array(
                    'key' => '_sln_discount_from',
                    'value' => array($from, $to),
                    'compare' => 'BETWEEN',
                    'type' => 'DATETIME',
                )
            )
        );
        $criteria['query'] = true;
        $dRepo = SLN_Plugin::getInstance()->getRepository(SLB_Discount_Plugin::POST_TYPE_DISCOUNT);
        $discounts = $dRepo->get(apply_filters('sln.discount.tools.export_criteria', $criteria));
        $headers = array(
            __('Discount name', 'salon-booking-system'),
            __('Discount code', 'salon-booking-system'),
            __('Discount amoount', 'salon-booking-system'),
            __('Discount type', 'salon-booking-system'),
            __('Discount max usage limit', 'salon-booking-system'),
            __('Discount current usage', 'salon-booking-system'),
            __('Valid from', 'salon-booking-system'),
            __('Valid to', 'salon-booking-system'),
            __('Is active?', 'salon-booking-system'),
        );
        $tmpfile = tempnam(get_temp_dir(), 'sln-export-discounts-');
        $fh = fopen($tmpfile, 'w');
        fwrite($fh, chr(239).chr(187).chr(191));
        fputcsv(
            $fh,
            apply_filters('sln.discount.tools.export_headers', $headers)
        );
        
        foreach($discounts as $discount){
            $limit = $discount->getTotalUsagesLimit();
            $now = new SLN_DateTime(current_time('mysql'));
            $start = $discount->getStartsAt();
            $end =   $discount->getEndsAt();
            $is_valid = $now >= $start && $now <= $end;
            if(!empty($limit) && $discount->getTotalUsagesNumber() >= $limit) {
                $is_valid = false;
            }

            $values =array(
                $discount->getName(),
                $discount->getCouponCode(),
                $discount->getAmount(),
                $discount->getAmountType(),
                empty($limit) ? __('Unlimited usage') : $limit,
                $discount->getTotalUsagesNumber(),
                $discount->getStartsAt(),
                $discount->getEndsAt(),
                $is_valid ? __('Active', 'salon-booking-system') : __('Inactive', 'salon-booking-system'),
            );
            fputcsv(
                $fh,
                apply_filters('sln.discount.tools.export_values', $values)
            );
        }

        fclose($fh);

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"export-discounts.csv\";");
        header("Content-Transfer-Encoding: binary");
        echo file_get_contents($tmpfile);

        unlink($tmpfile);
        exit;
    }

    public static function hook_tools_export_button(){
		?><div class="form-group col-xs-12 col-md-4">
		<button type="submit" id="discount-action" name="sln-tools-export-discounts" value="export"
			class="sln-btn sln-btn--main sln-btn--big sln-btn--icon sln-icon--tag">
			<?php _e('Export discounts', 'salon-booking-system')?></button>
		</div>
		<?php
	}
}

?>