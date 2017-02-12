<?php
namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use AppBundle\Repository\ArticleRepository;
use Doctrine\ORM\EntityRepository;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => true,
                'label' => 'Nom'
            ])
            ->add('contenu', CKEditorType::class, [
                'required' => true,
                'label' => 'Contenu'
            ])
            ->add('categorie', EntityType::class, array(
                'label'         => "Categorie",
                'class'         => 'AppBundle:Category',
                'choice_label'  => 'nom',
                'placeholder'   => 'Entrer votre categorie',
                'query_builder' => function (EntityRepository $er) {
                    return $er->getCategorie();
                }
            ))
            ->add('tags', EntityType::class, array(
                'label'         => "Tags",
                'class'         => 'AppBundle:Tag',
                'choice_label'  => 'nom',
                'placeholder'   => 'Entrer votre tag',
                'multiple'      => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->getTag();
                }
            ))  
            ->add('submit', SubmitType::class)
        ;
    }
}