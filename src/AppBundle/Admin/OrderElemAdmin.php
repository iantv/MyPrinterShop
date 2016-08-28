<?php 
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use AppBundle\Entity;

use Sonata\AdminBundle\Route\RouteCollection;

class OrderElemAdmin extends AbstractAdmin
{
	protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        	->add('productName', 'text', [ 'disabled' => true ])
        	->add('price', 'number', ['disabled' => true ])
        	->add('count', 'number')
        	/*->add('sum', 'number', [
        		'label' => 'Sum (Attention! If you edited previous field \'Count\' please check and edit next field \'Sum\'!)'
        	])*/
        	;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        /*$datagridMapper
        	->add('user')*/
        	/*->add('state')
        	->add('totalSum')*/
     //   	->add('orderDate', 'date')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        	->add('order')
        	->add('productId')
        	->addIdentifier('productName')
        	->add('price')
        	->add('count')
        	->add('sum')
        ;
    }
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
    }
}