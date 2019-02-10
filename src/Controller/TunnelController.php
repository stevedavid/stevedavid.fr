<?php

namespace App\Controller;

use App\Services\Services;
use App\Services\Tunnel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Intl\Exception\MethodNotImplementedException;
use Symfony\Component\Routing\Annotation\Route;

class TunnelController extends AbstractController
{
    /**
     * @Route("/tunnel/2", name="tunnel_2")
     *
     * @param Request $request
     * @return Response
     */
    public function secondStep(Request $request, Tunnel $tunnel)
    {
        $isAllowed = $request->isXmlHttpRequest() && $request->isMethod(Request::METHOD_POST);

        if($isAllowed) {

            $choice = $request->request->get('choice');
            $session = new Session();
            $session->set('choice', $choice);

            return $this->render('tunnel/2.html.twig', []);

        }

        throw new HttpException(500);
    }

    /**
     * @Route("/tunnel/3", name="tunnel_3")
     *
     * @param Request $request
     * @return Response
     */
    public function stepThree(Request $request, Tunnel $tunnel)
    {
        $isAllowed = $request->isXmlHttpRequest() && $request->isMethod(Request::METHOD_POST);

        if ($isAllowed) {

            $telephone = $request->request->get('tel');
            $tunnel->setTelephone($telephone);

            return $this->render('tunnel/3.html.twig', []);
        }

        throw new HttpException(500);
    }

    /**
     * @Route("/tunnel/4", name="tunnel_4")
     *
     * @param Request $request
     * @return Response
     */
    public function stepFour(Request $request, Tunnel $tunnel)
    {
        $isAllowed = $request->isXmlHttpRequest() && $request->isMethod(Request::METHOD_POST);

        if ($isAllowed) {

            $prenom = $request->request->get('prenom');
            $nom = $request->request->get('nom');
            $tunnel->setPrenom($prenom);
            $tunnel->setNom($nom);

            $session = new Session();
            return $this->render('tunnel/4.html.twig', [
                'choice' => $session->get('choice'),
            ]);

        }

        throw new HttpException(500);
    }
}
