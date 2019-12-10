<?php

namespace App\Controller\DO_NOT_OPEN;

use App\Service\BackdoorService;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class DoorController extends BaseController
{
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var BackdoorService
     */
    private $backdoor;

    public function __construct(SessionInterface $session, BackdoorService $backdoor)
    {
        $this->session = $session;
        $this->backdoor = $backdoor;
    }

    /**
     * @Route("/escape-code-door-2", name="door_2")
     */
    public function accessDoor2()
    {
        $this->session->set('door3', true);
        $door = [
            'nb' => 2,
            'description' => "For access to the next door, decrypt this code<br> and enter the password in the next door <a href='" . $this->generateUrl('door_3') . "'>Door 3</a> :"
        ];
        return $this->render('door/door2.html.twig', [
            'door' => $door
        ]);
    }

    public function accessDoor3(FormInterface $form, bool $unlock = false)
    {
        if (!$this->session->has('door3')) {
            return $this->redirectToRoute('home');
        }

        $door = [
            'nb' => 3,
            'description' => "Well, to be able to continue, you need to open a backdoor. Make sure that the \"authorized\" method of the \"BackdoorService\" service returns true."
        ];

        if ($unlock || $this->session->has('unlock')) {
            $this->session->set('unlock', true);
            if ($this->backdoor->authorization()) {
                $this->session->set('door4', true);
            }
            return $this->render('DO_NOT_OPEN/3/door3.html.twig', [
                'door' => $door,
                'backdoor' => $this->backdoor->authorization()
            ]);
        }
        return $response = $this->render('DO_NOT_OPEN/3/beforeDoor3.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/door-4", name="door_4")
     */
    public function accessDoor4()
    {
        if (!$this->session->has('door4')) {
            return $this->redirectToRoute('door_3');
        }

        $door = [
            'nb' => 4,
            'description' => ""
        ];
        return $this->render('DO_NOT_OPEN/4/door4.html.twig', [
            'door' => $door,
        ]);
    }
}
