<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use FOS\UserBundle\Model\UserManagerInterface;

class UserAdmin extends AbstractAdmin
{
	protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        	->with('General')
	           	->add('username', 'text')
	        	->add('email', 'email')
	        	->add('plainPassword', 'text')
        	->end()

            ->with('Management')
                /*->add('roles', 'sonata_security_roles', array( 'multiple' => true))*/
                ->add('locked', null, ['required' => false])
                ->add('expired', null, ['required' => false])
                ->add('enabled', null, ['required' => false])
                ->add('credentialsExpired', null, ['required' => false])
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
        	/*->add('password')*/
        	->add('email')
            ->add('locked')
            ->add('expired')
            ->add('enabled')
            ->add('credentialsExpired')
            ->add('last_login', 'datetime')
        	;
    }

    public function getDashboardActions(){
    	$actions = parent::getDashboardActions();
    	return $actions;
    }

    public function preUpdate($user)
    {
        $this->getUserManager()->updateCanonicalFields($user);
        $this->getUserManager()->updatePassword($user);
    }

    public function setUserManager(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @return UserManagerInterface
     */
    public function getUserManager()
    {
        return $this->userManager;
    }
}