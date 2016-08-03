<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use AppBundle\Entity;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProductAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('Name', 'text')
                   ->add(
                    'SubCategory', 'entity', [
                        'class'         => 'AppBundle\Entity\SubCategory',
                        'choice_label'  => 'Name',
                        'group_by'      => function($val, $key, $index){
                            return $val->getCategory()->getName();
                        }
                    ])
                   /*->add('path', 'entity', [
                        'class'         => 'AppBundle\Entity\SubCategory',
                        'choice_label'  => function($subCategory){
                            return  $subCategory->getCategory()->getId().".".
                                    $subCategory->getId().". ".
                                    $subCategory->getName();
                        },
                        'group_by'      => function($val, $key, $index){
                            return $val->getCategory()->getId();
                        }
                    ])*/
                   ->add('Count', 'number')
                   ->add('RetailPrice', 'number')
                   /*->add('path', HiddenType::class, [
                        'data'  =>  '1.1'
                    ])*/
                   ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('Name');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('Name');
    }
}
?>