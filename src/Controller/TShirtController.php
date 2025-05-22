<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TShirtController extends AbstractController
{
    #[Route('/tshirt', name: 'app_t_shirt')]
    public function index(): Response
    {
        return $this->render('t_shirt/index.html.twig');
    }
}
