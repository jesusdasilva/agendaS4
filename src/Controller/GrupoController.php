<?php
// agendaS4/src/Controller/GrupoController.php

namespace App\Controller;

use App\Entity\Grupo;
use App\Form\GrupoType;
use App\Repository\GrupoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GeneradorMensaje;
use \Doctrine\DBAL\DBALException;

/**
 * @Route("/{_locale}/grupo")
 */
class GrupoController extends Controller
{
    /**
     * @Route("/", name="grupo_index", methods="GET")
     */
    public function index(GrupoRepository $grupoRepository): Response
    {
        return $this->render('grupo/index.html.twig', ['grupos' => $grupoRepository->findAll()]);
    }

    /**
     * @Route("/new", name="grupo_new", methods="GET|POST")
     */
    public function new(Request $request, GeneradorMensaje $mensaje): Response
    {
        $grupo = new Grupo();
        $form = $this->createForm(GrupoType::class, $grupo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($grupo);
            $em->flush();

            // Servicio GeneradorMensaje
            $mensaje->crear('Nuevo');
            // Mensaje flash
            $this->addFlash($mensaje->getTipo(), $mensaje->getContenido());

            return $this->redirectToRoute('grupo_index');
        }

        return $this->render('grupo/new.html.twig', [
            'grupo' => $grupo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="grupo_show", methods="GET")
     */
    public function show(Grupo $grupo): Response
    {
        return $this->render('grupo/show.html.twig', ['grupo' => $grupo]);
    }

    /**
     * @Route("/{id}/edit", name="grupo_edit", methods="GET|POST")
     */
    public function edit(Request $request, Grupo $grupo, GeneradorMensaje $mensaje): Response
    {
        $form = $this->createForm(GrupoType::class, $grupo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            // Servicio GeneradorMensaje
            $mensaje->crear('Editar');
            // Mensaje flash
            $this->addFlash($mensaje->getTipo(), $mensaje->getContenido());

            return $this->redirectToRoute('grupo_edit', ['id' => $grupo->getId()]);
        }

        return $this->render('grupo/edit.html.twig', [
            'grupo' => $grupo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="grupo_delete", methods="DELETE")
     */
    public function delete(Request $request, Grupo $grupo, GeneradorMensaje $mensaje): Response
    {

        if ($this->isCsrfTokenValid('delete'.$grupo->getId(), $request->request->get('_token'))) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->remove($grupo);
                $em->flush();

                // Servicio GeneradorMensaje
                $mensaje->crear('Eliminar');
                // Mensaje flash
                $this->addFlash($mensaje->getTipo(), $mensaje->getContenido());

            }catch(DBALException $e){

                if('23000' === $e->getPrevious()->getCode()){
                    $mensaje->crear('error_eliminar_23000');
                }else{
                    $mensaje->crear('error_eliminar_otro', $e->getPrevious()->getCode());
                }

                $this->addFlash($mensaje->getTipo(), $mensaje->getContenido());

                return $this->redirectToRoute('grupo_show',['id' => $grupo->getId()]);
            }
        }

        return $this->redirectToRoute('grupo_index');

    }
}
