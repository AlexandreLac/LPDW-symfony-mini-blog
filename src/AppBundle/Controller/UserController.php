<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\UserType;
use AppBundle\Entity\User;

class UserController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
         $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('AppBundle:security:login.html.twig', array(
            'error' => $error,
            'last_username' => $lastUsername
        ));
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction(Request $request)
    {

    }

    /**
     * @Route("/administration")
     */
    public function adminAction()
    {
        return $this->render('AppBundle:admin:index.html.twig');
    }

    /**
     * @Route("/register", name="user_registration")
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery("SELECT COUNT(u) FROM AppBundle:User u");
            $usersCount = $query->getSingleScalarResult();

            $role = ($usersCount == 0) ? 'ROLE_ADMIN' : 'ROLE_USER';
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setRole($role);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('articles');
        }

        return $this->render(
            'AppBundle:Registration:register.html.twig',
            array('form' => $form->createView())
        );
    }
}