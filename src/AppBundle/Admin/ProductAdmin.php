<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;


class ProductAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('Name', 'text')
                   /*->add('category', 'entity', array(
                        'class' => 'AppBundle\Entity\Category', 
                        'choice_label' => 
                    ))*/
                   ->add('subcategory', 'entity', array(
                        'class' => 'AppBundle\Entity\SubCategory',
                        'choice_label' => 'Name',
                    ))
                   ->add('Count', 'number')
                   ->add('RetailPrice', 'number');
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