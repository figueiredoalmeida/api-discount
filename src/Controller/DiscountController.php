<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DiscountController extends AbstractController
{
    /**
     * @Route("/api/discount", name="post_order", methods="POST")
     */
    public function post(
        Request $request)
    {
        $order = json_decode(
            $request->getContent(),
            true
        );

        return $order;
    }
}
