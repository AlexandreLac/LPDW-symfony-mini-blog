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
            // ->orderBy('a.date_parution','DESC')
            ->getQuery()
        ;	
	}
}
