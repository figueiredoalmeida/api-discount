<?php

namespace App\Controller;

use App\Service\DiscountCalculator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DiscountController extends AbstractController implements TokenAuthenticatedController
{
    /**
     * @Route("/api/discount", name="post_order", methods="POST")
     */
    public function post(
        Request $request, DiscountCalculator $discount
    )
    {
        $order = json_decode(
            $request->getContent(),
            true
        );

        $discount = $discount->calculate($order);

        return $this->json([
            'discount' => $discount,
        ]);
    }
}
