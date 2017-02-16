<?php 
namespace AppBundle\Twig;

class CommentaireExtension extends \Twig_Extension
{
	private $ServiceCommentaire;

	public function __construct($service){
		$this->ServiceCommentaire = $service;
	}
	public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('count', array($this, 'GetNbCommentaire')),
        );
    }
	public function GetNbCommentaire($id){
        return $this->ServiceCommentaire->GetNbCommentaire($id);
	}
}