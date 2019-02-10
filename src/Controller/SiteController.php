<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Service;
use App\Services\Tunnel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    /**
     * @Route("/", name="site_index")
     */
    public function index()
    {
        $services = $this->findServices();

        shuffle($services);

        return $this->render('site/index.html.twig', [
            'services' => $services,
        ]);
    }

    /**
     * @Route("/fetch_cart", name="site_cart")
     *
     * @param Tunnel $tunnel
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cart(Tunnel $tunnel)
    {
        $cart = $tunnel->getCart();

        return $this->render('includes/navigation/ajax/cart.html.twig', [
            'cart' => $cart,
        ]);
    }

    /**
     * @Route("/search", name="site_search")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function search(Request $request)
    {
        $q = $request->request->get('q');

        $services = $this->getDoctrine()->getManager()->getRepository(Service::class)->search($q);

        return $this->render('site/search.html.twig', [
            'services' => $services,
            'q' => $q,
        ]);

    }



    public function menuServices()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(Category::class)
        ;

        $categories = $repository->findAll();

        return $this->render('includes/navigation/menu.html.twig', [
            'categories' => $categories,
        ]);
    }

    private function findServices()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(Service::class)
        ;

        $services = $repository->findAll();

        return $services;
    }
}
