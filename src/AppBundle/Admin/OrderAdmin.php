<?php 
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use AppBundle\Entity;

class OrderAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        	->add('user', 'entity', [
        		'class' 	   => 'AppBundle\Entity\User',
        		'choice_label' => 'username'
        	])
        	->add('state', 'entity', [
        		'class' 	   => 'AppBundle\Entity\OrderState',
        		'choice_label' => 'name'	
        	])
        	->add('totalSum', 'number')
        	->add('orderDate', 'datetime')
        	;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        	->add('user')
        	/*->add('state')
        	->add('totalSum')*/
     //   	->add('orderDate', 'date')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        	->addIdentifier('user')
        	->addIdentifier('state')
        	->add('totalSum')
        	->add('orderDate', 'date')
            ->add('productList')
        ;
    }
}
?>