<?php
namespace AppBundle\Service;
class ServiceCommentaire
{
	private $em;
	
	public function __construct(\Doctrine\ORM\EntityManager $em)
	{
	    $this->em = $em;
	}

	public function GetNbCommentaire($id){
		return $this->em->getRepository('AppBundle:Article')->GetNbCommentaire($id);
	}
}