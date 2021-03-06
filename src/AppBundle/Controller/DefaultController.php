<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Tag;
use AppBundle\Entity\Article;
use AppBundle\Entity\Category;
use AppBundle\Entity\Commentaire;
use AppBundle\Form\TagType;
use AppBundle\Form\ArticleType;
use AppBundle\Form\CategoryType;
use AppBundle\Form\CommentaireType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $articles = $this->getDoctrine()->getRepository('AppBundle:Article')->getHome()->getResult();

        return $this->render('AppBundle:home:home.html.twig',[
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/articles", name="articles")
     */
    public function allArticlesAction(Request $request)
    {
        $articles = $this->getDoctrine()->getRepository('AppBundle:Article')->getAll()->getResult();
        
        return $this->render('AppBundle:article:index.html.twig',[
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/administration/newtag", name="newtag")
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
            return $this->redirectToRoute('admin');
        }
        return $this->render('AppBundle:tag:new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/administration/newcategory", name="newcategory")
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
            return $this->redirectToRoute('admin');
        }
        return $this->render('AppBundle:category:new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/administration/newarticle", name="newarticle")
     */
    public function newArticleAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $article->setAuteur($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush($article);
            return $this->redirectToRoute('admin');
        }
        return $this->render('AppBundle:article:new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/article/{id}", name="detail_article")
     */
    public function detailArticleAction(Request $request, $id)
    {
        $article = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Article')
            ->findOneById($id);

        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire = $form->getData();
            $article->addCommentaires($commentaire);
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush($commentaire);
            $em->persist($article);
            $em->flush($article);

            return $this->redirectToRoute('homepage');
        }
        return $this->render('AppBundle:article:detail.html.twig',[
            'article' => $article,
            'form' => $form->createView()   
        ]);
    }

    /**
     * @Route("categorie/{id}", name="detail_categorie")
     */
    public function detailCategorieAction(Request $request, $id)
    {
        $articles = $this->getDoctrine()->getRepository('AppBundle:Article')->getArticleByCategorie($id)->getResult();
        return $this->render('AppBundle:category:list.html.twig',[
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("categories", name="categories")
     */
    public function allCategoriesAction(Request $request)
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->getAllCategories()->getResult();
        return $this->render('AppBundle:category:index.html.twig',[
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/administration/delete/{entity}/{id}", name="delete_entity")
     */
    public function deleteEntityAction(Request $request, $entity, $id)
    {
        if(in_array($entity, array('Tag','Article','Category'))){
            $delete = $this
                ->getDoctrine()
                ->getRepository('AppBundle:'.$entity)
                ->findOneById($id);
            $em = $this->getDoctrine()->getManager();
            $em->remove($delete);
            $em->flush($delete);            
        }
        return $this->redirectToRoute('admin');
    }
}
