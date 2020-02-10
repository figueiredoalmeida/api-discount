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
     * PROMO B
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

    private $totalAmmount = 0;

    public function calculate(array $order) : array
    {
        $customer = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->findById(intval($order['customer-id']));

        // PROMO A
        foreach ($order['items'] as $key => $item) {
            $productCategory = $this->getDoctrine()
                ->getRepository(Product::class)
                ->findCategory($item['product-id']);

            if ($productCategory == self::PROMO_A_CATEGORY && $item['quantity'] == 5) {
                $order['items'][$key]['quantity'] = $item['quantity'] + self::PROMO_A_ADD_QUANTITY;
                $order['items'][$key]['total'] = ($order['items'][$key]['unit-price'] * $order['items'][$key]['quantity']);
            }
        }
        
        // PROMO B
        foreach ($order['items'] as $key => $item) {
            $productCategory = $this->getDoctrine()
                ->getRepository(Product::class)
                ->findCategory($item['product-id']);

            if ($productCategory == self::PROMO_B_CATEGORY && $item['quantity'] >= 2) {
                # Getting the cheapest product in order to calculate the discount over it's purchase
                $cheapestIdProduct = $this->cheapestProduct(
                        array_column($order['items'], 'product-id')
                    );
                $index = array_search($cheapestIdProduct, array_column($order['items'], 'product-id'));
                $cheapestProductPrice = $order['items'][$index]['total'];
                $order['items'][$key]['total'] = $cheapestProductPrice - ($cheapestProductPrice * (self::PROMO_B_DISCOUNT / 100));
            }
            $this->totalAmmount += $order['items'][$key]['total'];
        }
        $order['total'] = $this->totalAmmount;

        // PROMO C
        if ($customer[0]['revenue'] > self::PROMO_C_AMMOUNT) {
            $order['total'] = $order['total'] - ($order['total'] * (self::PROMO_C_PERC / 100));
        }

        return $order;
    }

    public function cheapestProduct(array $items)
    {
        $id = $cheapestPrice = $this->getDoctrine()
                    ->getRepository(Product::class)
                    ->findCheapest($items);

        return $id[0]['id'];
    }

}
