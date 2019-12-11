<?php

namespace App\Controller\Door;

use App\Controller\DO_NOT_OPEN\BaseController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class Door4Controller extends BaseController
{
    /**
     * @Route("/door-4/{secret}", name="door_4", requirements={"secret"="\S+"}, defaults={"secret": ""})
     */
    public function accessDoor4($secret)
    {
        /*------- Do not touch -------*/
        if (!$secret) {
            throw new NotFoundHttpException('Your path is invalid. You miss something...');
        }
        if ($secret !== 'I<3W1ld') {
            throw new NotFoundHttpException('Your secret is invalid');
        }
        return $this->forward('App\Controller\DO_NOT_OPEN\DoorController::accessDoor4', [
        ]);
        /*------- End Do not touch -------*/
    }
}
