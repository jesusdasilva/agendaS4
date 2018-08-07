<?php
// agendaS4/src/Controller/ContactoController.php

namespace App\Controller;

use App\Entity\Contacto;

use App\Entity\Grupo;
use App\Repository\GrupoRepository;

use App\Form\ContactoType;
use App\Repository\ContactoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/{_locale}/contacto")
 */
class ContactoController extends Controller
{
    /**
     * @Route("/", name="contacto_index", methods="GET")
     */
    public function index(ContactoRepository $contactoRepository): Response
    {
        return $this->render('contacto/index.html.twig', ['contactos' => $contactoRepository->findAll()]);
    }

    /**
     * @Route("/new", name="contacto_new", methods="GET|POST")
     */
    public function new(Request $request, TranslatorInterface $traductor): Response
    {
        $contacto = new Contacto();
        $form = $this->createForm(ContactoType::class, $contacto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contacto);
            $em->flush();

            $this->addFlash('success', $traductor->trans('mensaje.nuevo',[],'mensaje'));

            return $this->redirectToRoute('contacto_index');
        }

        // Verificar que exista un Grupo para asociar al contacto
        if( 0 === count($this->getDoctrine()->getRepository(Grupo::class)->findAll()) ){
            $this->addFlash('danger', $traductor->trans('mensaje.tabla_vacia_grupo',[],'mensaje'));

            return $this->redirectToRoute('grupo_new');
        }else {

            return $this->render('contacto/new.html.twig', [
                    'contacto' => $contacto,
                    'form' => $form->createView(),
                ]
            );
        }

    }

    /**
     * @Route("/{id}", name="contacto_show", methods="GET")
     */
    public function show(Contacto $contacto): Response
    {
        return $this->render('contacto/show.html.twig', ['contacto' => $contacto]);
    }

    /**
     * @Route("/{id}/edit", name="contacto_edit", methods="GET|POST")
     */
    public function edit(Request $request, Contacto $contacto, TranslatorInterface $traductor): Response
    {
        $form = $this->createForm(ContactoType::class, $contacto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', $traductor->trans('mensaje.editar',[],'mensaje'));

            return $this->redirectToRoute('contacto_edit', ['id' => $contacto->getId()]);
        }

        return $this->render('contacto/edit.html.twig', [
            'contacto' => $contacto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contacto_delete", methods="DELETE")
     */
    public function delete(Request $request, Contacto $contacto, TranslatorInterface $traductor): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contacto->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contacto);
            $em->flush();

            $this->addFlash('success', $traductor->trans('mensaje.eliminar',[],'mensaje'));

        }

        return $this->redirectToRoute('contacto_index');
    }
}
