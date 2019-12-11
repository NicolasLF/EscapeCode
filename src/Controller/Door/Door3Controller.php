<?php

namespace App\Controller\Door;

use App\Controller\DO_NOT_OPEN\BaseController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class Door3Controller extends BaseController
{
    /**
     * @Route("/door-3", name="door_3")
     */
    public function accessDoor3(Request $request)
    {
        /*------- Do not touch -------*/
        $unlock = false;
        $qb = $this->createFormBuilder();
        $qb->add('password', PasswordType::class, [
            'label' => false
        ]);
        $form = $qb->getForm();
        /*------- End Do not touch -------*/

        //$form->handleRequest();

        /*------- Do not touch -------*/
        if ($form->isSubmitted() && $form->isValid()) {
            $mdp = crypt($form->get('password')->getData(), 'W1ld3r');
            if (!$mdp === 'W1O41hdtIvh1w') {
                throw new AccessDeniedException('Bad Password');
            }
            $unlock = true;
        }
        return $this->forward('App\Controller\DO_NOT_OPEN\DoorController::accessDoor3', [
            'form' => $form,
            'unlock' => $unlock,
        ]);
        /*------- End Do not touch -------*/
    }
}
