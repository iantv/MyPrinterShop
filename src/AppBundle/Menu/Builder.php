<?php
namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

use AppBundle\Entity\Category;

class Builder implements ContainerAwareInterface
{
	use ContainerAwareTrait;

	public function mainMenu(FactoryInterface $factory, array $options)
	{
		$menu = $factory->createItem('Catalog');
		$menu->setChildrenAttributes(['id' => 'menu']);

		$menu->addChild('Все продукты', array('route' => "homepage"));

		$em = $this->container->get('doctrine')->getManager();
		$categoryArr = $em->getRepository('AppBundle:Category')->findAllOrderedByName();

		foreach ($categoryArr as $category) {
			$menu->addChild(
				$category->getName(), 
				array(
					'route' => 'category',
					'routeParameters' => array('categoryId' => $category->getId())
			));
			foreach ($category->getSubCategory() as $subCategory) {
				$menu[$category->getName()]->addChild(
					$subCategory->getName(), 
					array(
						'route' => 'subcategory', 
						'routeParameters' => array('subcategoryId' => $subCategory->getId())
				));
			}
		}
		return $menu;
	}

	function personalMenu(FactoryInterface $factory, array $options){
		$menu = $factory->createItem('Profile');
		$menu->setChildrenAttributes(['id' => 'menu']);

		$menu->addChild('Мой профиль', ['route' => 'personal']);
		$menu->addChild('Мои заказы', ['route' => 'orders']);
		$menu['Мои заказы']->addChild('Все заказы', ['route' => 'orders']);
		$menu['Мои заказы']->addChild('Открытые заказы', ['route' => 'orders', 'routeParameters' => ['selection' => 'opened']]);
		$menu['Мои заказы']->addChild('Выкупленные заказы', ['route' => 'orders', 'routeParameters' => ['selection' => 'bought']]);
		$menu['Мои заказы']->addChild('Отмененные заказы', ['route' => 'orders', 'routeParameters' => ['selection' => 'canceled']]);

		return $menu;
	}
}

?>