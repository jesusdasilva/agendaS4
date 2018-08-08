<?php
// agendaS4/src/Controller/InicioController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{_locale}/inicio")
 */
class InicioController extends Controller
{
    /**
     * @Route("/", name="inicio_index", methods="GET")
     */
    public function index(): Response
    {

        return $this->render('inicio/index.html.twig');

    }

}
