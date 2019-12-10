<?php


namespace App\Controller\DO_NOT_OPEN;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function default()
    {
        return $this->render('index.html.twig');
    }

}