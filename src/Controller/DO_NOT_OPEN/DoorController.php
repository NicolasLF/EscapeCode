<?php

namespace App\Controller\DO_NOT_OPEN;

use App\Entity\Student;
use App\Service\BackdoorService;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Persistence\ManagerRegistry;
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
    /**
     * @var ManagerRegistry
     */
    private $registry;

    public function __construct(SessionInterface $session, BackdoorService $backdoor, ManagerRegistry $registry)
    {
        $this->session = $session;
        $this->backdoor = $backdoor;
        $this->registry = $registry;
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
        return $this->render('door/2/door2-4.html.twig', [
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

    public function accessDoor4()
    {
        if (!$this->session->has('door4')) {
            return $this->redirectToRoute('door_3');
        }
        $door = [
            'nb' => 4,
            'description' => "Welcome to Gate 4. It's good that you made it this far. But you're only at the beginning of your problems...<br> You must modify the SQL query in StudentRepository to get the same result as below. Update to see if it's okay, and you'll automatically be redirected to the next step."
        ];

        $sql = "SELECT student.city, MIN(student.birth_at) as smallest_birthday, SUM(student.secret_id) as sum_of_secret FROM student WHERE student.city = :city";

        $statement = $this->getDoctrine()->getManager()->getConnection()->prepare($sql);
        $statement->bindValue('city', 'La loupe');
        $statement->execute();
        $result = $statement->fetch();

        $resultStudent = $this->registry->getRepository(Student::class)->findSecret();

        if ($result === $resultStudent) {
            $this->session->set('door5', true);
            return $this->redirectToRoute('door_5');
        }

        return $this->render('DO_NOT_OPEN/4/door4.html.twig', [
            'door' => $door,
            'result' => $result,
            'resultStudent' => $resultStudent,
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/door-5", name="door_5")
     */
    public function accessDoor5()
    {
        if (!$this->session->has('door5')) {
            return $this->redirectToRoute('door_4');
        }

        $door = [
            'nb' => 5,
            'description' => "Congratulation !! You did it, but stay cool, the next time is more complicated... Good luck ;) "
        ];

        return $this->render('DO_NOT_OPEN/5/door5.html.twig', [
            'door' => $door,
        ]);
    }
}
