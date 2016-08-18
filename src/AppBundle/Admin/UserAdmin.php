<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class UserAdmin extends AbstractAdmin
{
	protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        	->with('User Data')
	        	->add('username', 'text')
	        	->add('email', 'email')
	        	->add('plainPassword', 'repeated')
        	->end()
        	;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        /*$datagridMapper->add('id')
        	;*/
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        	->addIdentifier('username')
        	->add('password')
        	->add('email')
        	;
    }

    public function getDashboardActions(){
    	$actions = parent::getDashboardActions();
    	//unset($actions['create']);

    	/*$actions['import'] = [
    		'label' => 'Import',
    		'url' => $this->generateUrl('import'),
    		'icon'	=> 'import',
    		'translation_domain' => 'SonataAdminBundle',
    		'template' => 'SonataAdminBundle:CRUD:dashboard__action.html.twig'
    	];*/

    	return $actions;
    }

    public function prePersist($user){
    	$encoder = $this->container->get('security.password_encoder');
		$encoded = $encoder->encodePassword($user, $user->getPlainpassword());

		$user->setPassword($encoded);
	}
}