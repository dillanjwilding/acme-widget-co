<?php
namespace AcmeWidgetCo\Offer;

/**
 * Ok, I may be overthinking this but typically there are a couple parts to a
 * deal/promotion/offer; usually they are boundaries such as dates in which it
 * is valid, the condition that needs to be met (date, order amount, buying 2
 * of a particular item, etc), and the discount. I guess there's also the
 * ability to activate or deactivate offers if need be but they could always
 * just set the end date to yesterday to deactivate an offer.
 */
class Offer {
	private $start_date;
	private $end_date;
	private $condition;
	private $discount;

	public function __construct($start_date, $end_date, $condition, $discount) {
		$this->start_date = $start_date;
		$this->end_date = $end_date;
		$this->condition = $condition;
		$this->discount = $discount;
	}

	// valid, applicable, or active
	public function isValid() {
		// check if today is in between the start and end dates,
		//  possibly also check if the condition is met
		// todo fill this in
	}
}