<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends \Doctrine\ORM\EntityRepository
{

	public function getHome(){
		return $this
            ->createQueryBuilder('a')
            ->where('a.dateParution < CURRENT_TIMESTAMP()')
            ->orderBy('a.dateParution','DESC')
            ->setMaxResults( 5 )
            ->getQuery()
        ;	
	}

	public function getAll(){
		return $this
            ->createQueryBuilder('a')
            ->where('a.dateParution < CURRENT_TIMESTAMP()')
            ->orderBy('a.dateParution','DESC')
            ->getQuery()
        ;
	}

    public function getAllAdmin(){
        return $this
            ->createQueryBuilder('a')
            ->getQuery()
        ;
    }

	public function getArticleByCategorie($id){
		return $this
            ->createQueryBuilder('a')
            ->where('a.categorie = :id')
            ->andwhere('a.dateParution < CURRENT_TIMESTAMP()')
		    ->setParameter('id', $id)
		    ->orderBy('a.dateParution', 'DESC')
		    ->getQuery()
        ;	
	}

    public function GetNbCommentaire($id){
        return $this
            ->createQueryBuilder('a')
            ->select('count(c.id)')
            ->join('a.commentaires','c')
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
