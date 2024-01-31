<?php
namespace AcmeWidgetCo\Delivery;

/**
 * Is it more appropriate to name this ShippingCalculator or
 *  DeliveryCostCalculator? DeliveryCost->calculate() reads well in english
 *  because you calculate delivery costs but conceptually it really doesn't make
 *  sense.
 * Also, the problem definition only states one set of delivery costs but
 * online stores usually have multiple options such as Standard or Expedited
 * (even multiple types/kinds of Expedited options) with associated price 
 * tiers/calculations. Would be nice to have a more extensible solution.
 */
class DeliveryCost {
	/** @var array<array<string, float>> */
	private array $tiers = [];

	public function __construct(string $type = 'standard') {
		// load data for $type, but since I don't have a database and can't do that, $tiers is all the data and we're only loading the particular data we want
		// todo test boundaries
		$tiers = [
			'standard' => [
				['min' => 0, 'cost' => 4.95],
				['min' => 50, 'cost' => 2.95],
				['min' => 90, 'cost' => 0]
			]
			// 'expedited' => [], ...
		];
		if (!isset($tiers[$type])) {
			throw new \Exception("'{$type}' is not a valid Delivery type.");
		}
		$this->tiers = $tiers[$type];
	}

	public function calculateDeliveryCost(float $orderTotal): float {
		// sort array of the different tiers and their associated costs in descending order (highest first) so that the first lower limit/boundary threshold the total is above will be the tier that applies (reword) rather than having a lower and upper bounds
		usort($this->tiers, function($a, $b) {
			return $b['min'] <=> $a['min'];
		});

		if (!empty($this->tiers)) {
			foreach ($this->tiers as $tier) {
				if ($orderTotal >= $tier['min']) {
					return $tier['cost'];
				}
			}
		}

		/**
		 * if there is no tier for the cart total, normally we'd default to
		 * something but I don't think we can pick a default as even the
		 * lowest/last tier has a threshold more than the cart total and can't
		 * assume free shipping because if there are tiers with costs
		 * associated, it wouldn't make sense to have the lowest tier be free
		 * because it de-incentives (deter?) users from buying more. Might be
		 * more appropriate to throw an exception.
		 */
		// with the implementation I have where 'min' => 0, we default to that one but I'm not sure it's safe to make that assumption given other people could modify delivery tiers
		throw new \Exception('Could not calculate delivery cost.');
	}
}
