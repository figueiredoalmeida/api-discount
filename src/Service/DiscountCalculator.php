<?php declare(strict_types = 1);

namespace App\Service;

use DateTime;
use App\Entity\Customer;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DiscountCalculator extends AbstractController
{
    /**
     * PROMO A
     * For every product of category "Switches" (id 2), when you buy five,
     * you get a sixth for free
    */
    const PROMO_A_CATEGORY = 2;
    const PROMO_A_ADD_QUANTITY = 1;

    /**
     * PROMO C
     * If you buy two or more products of category "Tools" (id 1),
     * you get a 20% discount on the cheapest product
    */
    const PROMO_B_CATEGORY = 1;
    const PROMO_B_DISCOUNT = 20;

    /**
     * PROMO C
     * A customer who has already bought for over € 1000,
     * gets a discount of 10% on the whole order
    */
    const PROMO_C_AMMOUNT = 1000;
    const PROMO_C_PERC = 10;

    public function calculate(array $order) : array
    {
        $customer = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->findById(intval($order['customer-id']));


        return $customer;
    }

}
