<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Service\UserService;
use UserBundle\Entity\User;

class UserController extends Controller{

    protected $userService;

    public function preExecute(){
        /** @var UserService userService */
        $this->userService = $this->container->get('UserService');
    }

    public function dashboardUserAction(){
        $users = $this->userService->getTopFiveReviewingUsers();

        return $this->render('UserBundle:User:user.html.twig', array(
            'users' => $users
        ));
    }

    public function deleteAction(User $user){
        $this->userService->delete($user);

        return $this->redirect($this->generateUrl('user_dashboard'));
    }
}
