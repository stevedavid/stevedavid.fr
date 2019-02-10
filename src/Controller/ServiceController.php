<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Service;
use App\Services\Tunnel;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/services")
 *
 * Class ServiceController
 * @package App\Controller
 */
class ServiceController extends AbstractController
{
    /**
     * @Route("/{slugCategory}/{slugService}", name="service_show")
     *
     * @param $slugCategory
     * @param $slugService
     * @return Response
     */
    public function show(Tunnel $tunnel, $slugCategory, $slugService)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(Service::class)
        ;

        $service = $repository->findOneBySlug($slugService);

        $category = $service->getCategory();
        if($category->getSlug() !== $slugCategory) {
            return new Response(null, 404);
        }

        $tunnel->setService($service);

        $criteria = new Criteria();
        $criteria->where(Criteria::expr()->neq('id', $service->getId()));
        $criteria->andWhere(Criteria::expr()->eq('category', $category));
        $services = $repository->matching($criteria);

        return $this->render('service/show.html.twig', [
            'service' => $service,
            'related_services' => $services,
            'disponibilites' => Tunnel::DISPONIBILITES,
            'disponibilite' => $tunnel->getDisponibilite(),
        ]);
    }

    /**
     * @Route("/post_dispo", name="service_post_dispo")
     */
    public function postDispo(Request $request, Tunnel $tunnel)
    {
        $isAllowed = $request->isXmlHttpRequest() && $request->isMethod(Request::METHOD_POST);

        if ($isAllowed) {

            $disponibilite = $request->request->get('disponibilite');
            $tunnel->setDisponibilite($disponibilite);

            return new JsonResponse([
                'error' => 0,
                'dispo' => $tunnel->getDisponibilite(),
            ]);

        }

        throw new HttpException(500);
    }

    /**
     * @Route("/{slugCategory}", name="category_show")
     *
     * @param $slugCategory
     * @return Response
     */
    public function showCategory($slugCategory)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(Category::class)
        ;

        $category = $repository->findOneBySlug($slugCategory);

        if(empty($category)) {
            return new Response(null, 404);
        }

        return $this->render('service/category.html.twig', [
            'category' => $category,
        ]);
    }
}
