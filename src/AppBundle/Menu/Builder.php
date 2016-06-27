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
		$categoryArr = $em->getRepository('AppBundle:Category')->findAll();

		foreach ($categoryArr as $category) {
			if ($category->getId() == 23 || $category->getId() == 24 || $category->getId() == 25 ||
				($category->getId() > 7 && $category->getId() < 14)){ 
				continue;
				/* This cond is temporary. It's for stop generate menuItems with this Id.
				 * Now categories with this id has not subcategories. 
				 * 
				 * cond: empty($category->getSubCategory()) is false for categories with this Id.
				 * Price list downloaded from other site. There were products with category, but without 
				 * subcategory. So, database store info about every category, but when tables were create 
				 * categories were add to Category table. But products snd subcategories were not add to 
				 * appropriate tables. 

				 * So now this cond for ignore categories without subcategory and without products.
				 */
			}
			$menu->addChild(
				$category->getName(), 
				array(
					'route' => 'category',
					'routeParameters' => array('categoryId' => $category->getId())
			));
			foreach ($category->getSubCategory() as $subCategory) {
				if ($subCategory->getId() < 31 && $subCategory->getId() > 25){
					continue;
				}
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
}

?>