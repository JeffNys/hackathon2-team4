<?php

namespace App\Controller;

use App\Entity\perso;
use App\Form\persoType;
use App\Repository\PersoRepository;
use App\Service\MapManager;
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

    public function __construct(PersoRepository $persoRepository)
    {
        $this->persoRepository = $persoRepository;
    }

    /**
     * Move the perso to coord x,y
     * @Route("/move/{x}/{y}", name="moveperso", requirements={"x"="\d+", "y"="\d+"}))
     */
    public function moveperso(int $x, int $y, PersoRepository $persoRepository, EntityManagerInterface $em): Response
    {
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
    public function moveDirection(string $direction, MapManager $mapManager, EntityManagerInterface $entityManager)
    {
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
        if ($mapManager->tileExits($perso->getCoordonneesX(), $perso->getCoordonneesY()) === true) {
            $this->addFlash('success', $perso->getNom() . ' move correctly');
            $entityManager->flush();
            /*if($mapManager->foundObjects($perso) === true) {
                $this->addFlash('success', 'You found an object');
            }*/
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
     * @Route("/new", name="perso_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $perso = new Perso();
        $form = $this->createForm(PersoType::class, $perso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($perso);
            $em->flush();

            return $this->redirectToRoute('perso_index');
        }

        return $this->render('perso/new.html.twig', [
            'perso' => $perso,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="perso_show", methods="GET")
     */
    public function show(Perso $perso): Response
    {
        return $this->render('perso/show.html.twig', ['perso' => $perso]);
    }

    /**
     * @Route("/{id}/edit", name="perso_edit", methods="GET|POST")
     */
    public function edit(Request $request, Perso $perso): Response
    {
        $form = $this->createForm(PersoType::class, $perso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('perso_index', ['id' => $perso->getId()]);
        }

        return $this->render('perso/edit.html.twig', [
            'perso' => $perso,
            'form' => $form->createView(),
        ]);
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