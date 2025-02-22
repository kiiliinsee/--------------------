<?php // algolplus

class SLN_Shortcode_SalonMyAccount_Details
{
	const NAME = 'salon_booking_my_account_details';

	private $plugin;
	private $attrs;
	private $perPage = 5;

	function __construct(SLN_Plugin $plugin, $attrs)
	{
		$this->plugin = $plugin;
		$this->attrs = $attrs;
	}

	public static function init(SLN_Plugin $plugin)
	{
		add_shortcode(self::NAME, array(__CLASS__, 'create'));
	}

	public static function create($attrs)
	{
            SLN_TimeFunc::startRealTimezone();

		$obj = new self(SLN_Plugin::getInstance(), $attrs);

		$ret = $obj->execute();
            SLN_TimeFunc::endRealTimezone();
		return $ret;
	}

	public function execute()
	{
		if (!is_user_logged_in()) {
			return false;
		}
		$accountBookings = new SLN_Helper_Availability_MyAccountBookings();

		if (isset($this->attrs['part']) && $this->attrs['part'] === 'history') { // history 'load more'
			$page = $this->attrs['page'];

			$historyItems = $this->prepareBookings($accountBookings->getBookings(get_current_user_id(), 'history'));
			$historyEnds  = count($historyItems) <= ($this->perPage*$page);
			$historyItems = array_slice($historyItems, 0, $this->perPage*$page);

			return $this->render('shortcode/salon_my_account/_salon_my_account_details_table',
					array(
						'table_data' => array(
							'page'  => $page,
							'items' => $historyItems,
							'end'   => $historyEnds,
							'mode'  => 'history',
						),
						'hide_prices' => $this->plugin->getSettings()->get('hide_prices'),
						'attendant_enabled' => $this->plugin->getSettings()->get('attendant_enabled'),
                                                'customer_timezone' => isset($_POST['customer_timezone']) ? $_POST['customer_timezone'] : '',
					)
			);
		}

// FULL MY ACCOUNT PAGE

		$historyItems = $this->prepareBookings($accountBookings->getBookings(get_current_user_id(), 'history'));

		$historySuccesfulItems = array();
		foreach($historyItems as $item) {
			if (in_array($item['status_code'], array(SLN_Enum_BookingStatus::PAY_LATER, SLN_Enum_BookingStatus::PAID, SLN_Enum_BookingStatus::CONFIRMED))) {
				$historySuccesfulItems[] = $item;
				break;
			}
		}

		$historyEnds  = count($historyItems) <= $this->perPage;
		$historyItems = array_slice($historyItems, 0, $this->perPage);

		return $this->render('shortcode/salon_my_account/salon_my_account_details',
				array(
					'new' => array(
						'items' => $this->prepareBookings($accountBookings->getBookings(get_current_user_id(), 'new'))
					),
					'history_successful' => array(
						'items' => $historySuccesfulItems
					),
					'history' => array(
						'page'  => 1,
						'items' => $historyItems,
						'end'   => $historyEnds,
					),
					'cancellation_enabled' => $this->plugin->getSettings()->get('cancellation_enabled'),
					'seconds_before_cancellation' => $this->plugin->getSettings()->get('hours_before_cancellation') * 3600,
					'gen_phone' => $this->plugin->getSettings()->get('gen_phone'),
					'cancelled' => !empty($_POST['option']) && $_POST['option'] = 'cancelled' ? true : false,
					'user_name' => wp_get_current_user()->user_firstname,
					'gen_name' => $this->plugin->getSettings()->get('gen_name'),
					'hide_prices' => $this->plugin->getSettings()->get('hide_prices'),
					'attendant_enabled' => $this->plugin->getSettings()->get('attendant_enabled'),
					'pay_enabled' => $this->plugin->getSettings()->isPayEnabled(),
					'booking_url' => $this->plugin->getSettings()->getPayPageId() ? get_post_permalink( $this->plugin->getSettings()->getPayPageId() ) : null,
					'is_form_steps_alt_order' => $this->plugin->getSettings()->isFormStepsAltOrder(),
					'customer_timezone' => isset($_POST['customer_timezone']) ? $_POST['customer_timezone'] : '',
                                        'customer_fidelity_score_enabled' => $this->plugin->getSettings()->get('enable_customer_fidelity_score'),
                                        'customer_fidelity_score' => (new SLN_Wrapper_Customer(get_current_user_id()))->getFidelityScore(),
				)
		);
	}

	private function prepareBookings($bookings)
	{
		$result = array();
		foreach ( $bookings as $booking ) {
			$result[] = $this->prepareBooking($booking);
		}

		return $result;
	}

    /**
     * @param SLN_Wrapper_Booking $booking
     * @return array
     */
    private function prepareBooking($booking) {
        $format = $this->plugin->format();
        $serviceNames = array();
        foreach($booking->getBookingServices()->getItems() as $s){
			if(!empty($s->getAttendant())){
				if(is_array($s->getAttendant())){
					$attendant = array();
					foreach($s->getAttendant() as $att){
						$attendant[] = $att->getName();
					}
					$attendant = implode(' ', $attendant);
				}else{
					$attendant = $s->getAttendant()->getName();
				}
			}
            $serviceNames[] = array(
				'name' => $s->getService()->getName(),
				'attendant' => !empty($attendant) ? $attendant : null,
				'price' => $format->moneyFormatted($s->getPrice()),
			);
        }

		$total = $format->moneyFormatted($booking->getAmount());
        if (SLN_Enum_BookingStatus::PAID == $booking->getStatus() && $deposit = $booking->getDeposit()) {
	        $total .= ' (' . $format->moneyFormatted($deposit) . ' ' .
	                  __('already paid as deposit','salon-booking-system') . ')';
        }

        $bId = $booking->getId();

        $comments = get_comments("post_id={$bId}&type=sln_review");
        $comment  = isset($comments[0]) ? $comments[0] : null;

        $timezone = $this->plugin->getSettings()->isDisplaySlotsCustomerTimezone() && isset($_POST['customer_timezone']) ? $_POST['customer_timezone'] : '';
		return array(
            'id'          => $bId,
            'date'        => $format->date($timezone ? $booking->getStartsAt()->setTimezone(new DateTimeZone($timezone)) : $booking->getStartsAt()),
            'time'        => $format->time($timezone ? $booking->getStartsAt()->setTimezone(new DateTimeZone($timezone)) : $booking->getStartsAt()),
            'timestamp'   => $booking->getStartsAt()->getTimestamp(),
            'services'    => $serviceNames,
            'total'       => $total,
            'status'      => SLN_Enum_BookingStatus::getLabel($booking->getStatus()),
            'status_code' => $booking->getStatus(),
            'rating'      => $booking->getRating(),
            'feedback'    => !empty($comment) ? $comment->comment_content : '',
		);
	}

	protected function render($view, $data)
	{
		return $this->plugin->loadView($view, compact('data'));
	}

}
