<?php

namespace App\Controller;

use App\Entity\perso;
use App\Repository\PersoRepository;
use App\Repository\TileRepository;
use App\Service\MapManager;
use App\Services\ApplyEffects;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/perso")
 */
class PersoController extends AbstractController
{

    private $persoRepository;
    private $tileRepository;

    public function __construct(
        PersoRepository $persoRepository,
        TileRepository $tileRepository
    ) {
        $this->persoRepository = $persoRepository;
        $this->tileRepository = $tileRepository;
    }

    /**
     * Move the perso to coord x,y
     * @Route("/move/{x}/{y}", name="moveperso", requirements={"x"="\d+", "y"="\d+"}))
     */
    public function moveperso(
        int $x,
        int $y,
        PersoRepository $persoRepository,
        EntityManagerInterface $em
    ): Response {
        $perso = $persoRepository->findOneBy([]);
        $perso->setCoordonneesX($x);
        $perso->setCoordonneesX($y);

        $em->flush();

        return $this->redirectToRoute('map');
    }

    /**
     * Move perso N,S,E,W
     * @Route("/move/{direction}", name="persoDirection", requirements={"direction"="N|S|E|W"})
     */
    public function moveDirection(
        string $direction,
        MapManager $mapManager,
        EntityManagerInterface $entityManager,
        ApplyEffects $effects
    ) {
        $perso = $this->persoRepository->findOneBy([]);


        if ($direction === 'N') {
            $perso->setCoordonneesY($perso->getCoordonneesY() - 1);
        } elseif ($direction === 'S') {
            $perso->setCoordonneesY($perso->getCoordonneesY() + 1);
        } elseif ($direction === 'E') {
            $perso->setCoordonneesX($perso->getCoordonneesX() + 1);
        } elseif ($direction === 'W') {
            $perso->setCoordonneesX($perso->getCoordonneesX() - 1);
        }
        $position = $this->tileRepository->findOneBy(
            [
                'coordX' => $perso->getCoordonneesX(),
                'coordY' => $perso->getCoordonneesY()
            ]
        );
        if ($mapManager->tileExits($perso->getCoordonneesX(), $perso->getCoordonneesY()) === true) {
            $entityManager->flush();
            if ($mapManager->foundObjects($perso) === true) {
                $this->addFlash('success', 'bravo tu as trouvé ' . $position->getObjet()->getNom());
                $potion = $position->getObjet();
                $effects->applyPotion($perso, $potion);
            }
            if ($mapManager->foundArme($perso)) {
                $this->addFlash('success', 'bravo tu as trouvé ' . $position->getArme()->getNom());
                $arme = $position->getArme();

            }
            if ($mapManager->foundPiege($perso)) {
                $this->addFlash('danger', 'bravo tu as trouvé ' . $position->getPiege()->getNom());
                $piege = $position->getPiege();
                $effects->applyPiege($perso, $piege);
            }
        } else {
            $this->addFlash('danger', 'Tile doesn\'t exist, the perso can\'t move');
        }
        return $this->redirectToRoute('map');
    }


    /**
     * @Route("/", name="perso_index", methods="GET")
     */
    public function index(PersoRepository $persoRepository): Response
    {
        return $this->render('perso/index.html.twig', ['persos' => $persoRepository->findAll()]);
    }

    /**
     * @Route("/{id}", name="perso_show", methods="GET")
     */
    public function show(Perso $perso): Response
    {
        return $this->render('perso/show.html.twig', ['perso' => $perso]);
    }

    /**
     * @Route("/{id}", name="perso_delete", methods="DELETE")
     */
    public function delete(Request $request, Perso $perso): Response
    {
        if ($this->isCsrfTokenValid('delete' . $perso->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($perso);
            $em->flush();
        }

        return $this->redirectToRoute('home');
    }
}
