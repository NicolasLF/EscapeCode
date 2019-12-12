<?php

namespace App\Controller\Door;

use App\Controller\DO_NOT_OPEN\BaseController;
use App\Entity\Student;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class Door5Controller extends BaseController
{
    /**
     * @Route("/door-5", name="door_5")
     */
    public function accessDoor5()
    {
        $students = $this->getDoctrine(Student::class)->findBy('La loupe');

        for ($i = 1; $i <= count($students) -1; ++$i) {

        }

        if ($i !== count($students)) {
            throw new \Exception('You need to solve this problem...');
        }


        return $this->forward('App\Controller\DO_NOT_OPEN\DoorController::accessDoor5', [
        ]);
    }
}
