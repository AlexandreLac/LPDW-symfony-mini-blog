<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Tag;
use AppBundle\Entity\Article;
use AppBundle\Entity\Category;
use AppBundle\Form\TagType;
use AppBundle\Form\ArticleType;
use AppBundle\Form\CategoryType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:home:home.html.twig');
    }

    /**
     * @Route("/newtag", name="newtag")
     */
    public function newTagAction(Request $request)
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tag = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush($tag);
            return $this->redirectToRoute('homepage');
        }
        return $this->render('AppBundle:tag:new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/newcategory", name="newcategory")
     */
    public function newCategoryAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush($category);
            return $this->redirectToRoute('homepage');
        }
        return $this->render('AppBundle:category:new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/newarticle", name="newarticle")
     */
    public function newArticleAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush($article);
            return $this->redirectToRoute('homepage');
        }
        return $this->render('AppBundle:article:new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
