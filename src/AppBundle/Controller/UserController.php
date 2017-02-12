<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserController extends Controller
{
    /**
     * @Route("/login", name="blog_login")
     */
    public function loginAction(Request $request)
    {
        return $this->render('AppBundle:user:login.html.twig');
    }

    /**
     * @Route("/login_check", name="blog_check")
     */
    public function loginCheckAction(Request $request)
    {

    }

    /**
     * @Route("/administration")
     */
    public function adminAction()
    {
        return new Response('<html><body>Admin page!</body></html>');
    }
}