<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Product;
use App\Service\DiscountCalculator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

class DiscountController extends AbstractController implements TokenAuthenticatedController
{
    /**
     * @Route("/api/v1/discount", name="post_order", methods="POST")
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

        /**
     * @Route("/api/v1/customer", name="post_customer", methods="POST")
     */
    public function postCustomer(
        Request $request
    )
    {
        $customers = json_decode(
            $request->getContent(),
            true
        );

        $em = $this->getDoctrine()->getManager();

        foreach ($customers as $customer) {
            $data = new Customer();
            $data->setName($customer['name']);
            $data->setSince(DateTime::createFromFormat('Y-m-d', $customer['since']));
            $data->setRevenue($customer['revenue']);

            $em->persist($data);
        }
        $em->flush();

        return $this->json([
            'info' => 'Customer(s) added with success.',
        ]);
    }

    /**
     * @Route("/api/v1/product", name="post_product", methods="POST")
     */
    public function postProduct(
        Request $request
    )
    {
        $products = json_decode(
            $request->getContent(),
            true
        );

        $em = $this->getDoctrine()->getManager();

        foreach ($products as $product) {
            $data = new Product();
            $data->setId($product['id']);
            $data->setDescription($product['description']);
            $data->setCategory($product['category']);
            $data->setPrice($product['price']);

            $em->persist($data);
        }
        $em->flush();

        return $this->json([
            'info' => 'Product(s) added with success.',
        ]);
    }

}
