<?php
namespace App\Services;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Session\Session;

class Tunnel
{
    private $session;
    private $manager;

    private $nom;
    private $prenom;
    private $telephone;
    private $service;
    private $disponibilite;

    const DISPONIBILITES = [
        1 => 'Aujourd\'hui',
        2 => 'Demain',
        3 => 'Dans la semaine',
        4 => 'La semaine prochaine',
    ];

    public function __construct(ObjectManager $manager)
    {
        $this->session = new Session();
        $this->manager = $manager;
    }

    public function getCart()
    {
        $session = $this->session;

        if(!array_key_exists($this->getDisponibilite(), self::DISPONIBILITES)) {
            $disponibilite = 'N/A';
        } else {
            $disponibilite = self::DISPONIBILITES[$this->getDisponibilite()];
        }

        $cart = [
            'identite' => [
                'nom' => $session->get('nom', 'N/A'),
                'prenom' => $session->get('prenom', 'N/A'),
                'telephone' => $session->get('telephone', 'N/A'),
            ],
            'service' => $this->getService(),
            'disponibilite' => $disponibilite,
        ];

        return $cart;
    }

    public function setDisponibilite($disponibilite)
    {
        $this->disponibilite = $disponibilite;
        $this->session->set('disponibilite', $disponibilite);

        return;
    }

    public function getDisponibilite()
    {
        return $this->session->get('disponibilite');
    }

    public function setService(Service $service)
    {
        $this->service = $service;
        $this->session->set('service', $service->getId());

        return;
    }

    private function getService()
    {
        $service = $this->manager
            ->getRepository(Service::class)
            ->findOneById(
                $this->session->get('service')
            );

        if(empty($service)) {
            return null;
        }

        return $service;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        $this->session->set('nom', $nom);
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        $this->session->set('prenom', $prenom);
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
        $this->session->set('telephone', $telephone);
    }


}