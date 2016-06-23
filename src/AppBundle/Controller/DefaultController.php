<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

use Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Entity\Category;
use AppBundle\Entity\SubCategory;
use AppBundle\Entity\Product;

/*use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
*/

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $products = $this->getDoctrine()
                        ->getRepository('AppBundle:Product')
                        ->findAll();
       
        if (!$products){
            return new Response('No products found');
        }

        foreach ($products as $product) {
           $result[] = [
                'Category'    => $product->getCategory()->getName(),
                'SubCategory' => $product->getSubCategory()->getName(),
                'Name'        => $product->getName(),
                'Count'       => $product->getCount(),
                'RetailPrice' => $product->getRetailPrice()
            ];
        }
        
        return $this->render('show.html.twig', [
            'page_title' => 'Интернет-магазин | Все продукты', 
            'header'     => 'Все продукты',
            'db'         => '<script type="text/javascript">var data = '.
                             json_encode($result, JSON_UNESCAPED_UNICODE).
                            ';</script>']);
    }

    /**
     * @Route("/product/{productId}", name="product")
     */
    public function showProductAction($productId)
    {
        $product = $this->getDoctrine()
                        ->getRepository('AppBundle:Product')
                        ->findOneByIdJoinedToCategory($productId);

        if (!$product){
            return new Response('No product found for id = '.$productId);
        }
        
        $result[] = [
            'Category'    => $product->getCategory()->getName(),
            'SubCategory' => $product->getSubCategory()->getName(),
            'Name'        => $product->getName(),
            'Count'       => $product->getCount(),
            'RetailPrice' => $product->getRetailPrice()
        ];
    
        return $this->render('show.html.twig', 
            ['page_title' => 'Интернет-магазин | Продукты | Продукт: '.$product->getName(), 
             'header'     => $product->getName(),
             'db'         => '<script type="text/javascript">var data = '.
                              json_encode($result, JSON_UNESCAPED_UNICODE).
                             ';</script>']);
    }

    /**
     * @Route("/category/{categoryId}", name="category")
     */
    public function showCategoryAction($categoryId)
    {
        $category = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->find($categoryId);

        if (!$category){
            return new Response('No category found for id = '.$categoryId);
        }

        foreach ($category->getProducts() as $product) {
            $result[] = [
                'Category'    => $category->getName(),
                'SubCategory' => $product->getSubCategory()->getName(),
                'Name'        => $product->getName(),
                'Count'       => $product->getCount(),
                'RetailPrice' => $product->getRetailPrice()
            ];
        }
        
        return $this->render('show.html.twig', [
            'page_title' => 'Интернет-магазин | Продукты | Категория: '.$category->getName(), 
            'header'     => 'Категория: '.$category->getName(),
            'db'         => '<script type="text/javascript">var data = '.
                             json_encode($result, JSON_UNESCAPED_UNICODE).
                            ';</script>']);
    }

    /**
     * @Route("/subcategory/{subcategoryId}", name="subcategory")
     */
    public function showSubCategoryAction($subcategoryId)
    {
        $subcategory = $this->getDoctrine()
            ->getRepository('AppBundle:SubCategory')
            ->find($subcategoryId);

        if (!$subcategory){
            return new Response('No subcategory found for id = '.$subcategoryId);
        }

        foreach ($subcategory->getProducts() as $product) {
            $result[] = [
                'Category'    => $product->getCategory()->getName(),
                'SubCategory' => $subcategory->getName(),
                'Name'        => $product->getName(),
                'Count'       => $product->getCount(),
                'RetailPrice' => $product->getRetailPrice()
            ];
        }
        
        return $this->render('show.html.twig', [
            'page_title' => 'Интернет-магазин | Продукты | Подкатегория: '.$subcategory->getName(), 
            'header'     => 'Подкатегория: '.$subcategory->getName(),
            'db'         => '<script type="text/javascript">var data = '.json_encode($result, JSON_UNESCAPED_UNICODE).';</script>']);
    }

    /**
     * @Route("/create", name="create")
     */
    public function createProductAction()
    {
        $category = new Category();
        $category->setName('Прочее');

        $subcategory = new SubCategory();
        $subcategory->setName('Программаторы');
        
        $product = new Product();
        $product->setName('Программатор микросхем 24CXX EEPROM');
        $product->setCount(58);
        $product->setRetailPrice(300);

        $product->setCategory($category);
        $product->setSubCategory($subcategory);

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->persist($subcategory);
        $em->persist($product);
        $em->flush();

        return new Response(
            'Saved new product with id: '.$product->getId().' and new category with id: '.$category->getId().' and new subcategory with id: '.$subcategory->getId());
    }

    /**
     * @Route("/createdbfromjson", name="createdb")
     */
    public function createdb(){
        return new Response('Comment first line in createdb()');
        $string = file_get_contents(
            "/home/iantv/Documents/WEB/MyPrinterShop/src/AppBundle/Resources/public/js/data.json");
        $data = json_decode($string, true, JSON_UNESCAPED_UNICODE);
        $productsArr = $data['Products'];

        $em = $this->getDoctrine()->getManager();        
        $category = NULL; $subCategory = NULL; $resultCategory = []; $resultSubCategory = [];
        
        //return new JsonResponse($productsArr);
        $cnt = 0;
        foreach ($productsArr as $productElem){
            echo $cnt++;

            /*if ($cnt == 2){
                echo $category->getName().":".$productElem['Category'];
                //echo strnatcmp($category->getName(), $productElem['Category']) == 0;
            }*/
            if ($cnt > 1 && (strnatcmp($category->getName(), $productElem['Category']) == 0)){
                $queryCategory = $em->createQuery(
                    'SELECT c FROM AppBundle:Category c WHERE c.Name = :Name'
                )->setParameter('Name',$productElem['Category']);
                $resultCategory = $queryCategory->getResult();
                //echo "resultCategory";
            }
            if (empty($resultCategory)){
                $category = new Category();
                $category->setName($productElem['Category']);
            } else {
                $category = $resultCategory[0];
                $resultCategory = [];
            }

            if ($cnt > 1 && (strnatcmp($subCategory->getName(), $productElem['SubCategory']) == 0)){
                $querySubCategory = $em->createQuery(
                    'SELECT c FROM AppBundle:SubCategory c WHERE c.Name = :Name'
                )->setParameter('Name', $productElem['SubCategory']);
                $resultSubCategory = $querySubCategory->getResult();
                //echo "resultSubCategory: ";
            }
            if (empty($resultSubCategory)){
                $subCategory = new SubCategory();
                $subCategory->setName($productElem['SubCategory']);
            } else {
                $subCategory = $resultSubCategory[0];
                $resultSubCategory = [];
            }
            //echo $category->getName()."|\n".$subCategory->getName()."|\n".$productElem['Name']."|\n".$productElem['Count']."|\n".$productElem['RetailPrice'];
 
            $product = new Product();
            $product->setName($productElem['Name']);
            $product->setCount($productElem['Count']);
            $product->setRetailPrice($productElem['RetailPrice']);

            $product->setCategory($category);
            $product->setSubCategory($subCategory);

            $em->persist($category);
            $em->persist($subCategory);
            $em->persist($product);
            $em->flush();
        }
        return new Response('$products ok');
    }

    /**
     * @Route("/remove/{productId}", name="remove")
     */
    public function removeAction($productId)
    {   
        $em = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getRepository('AppBundle:Product')->find($productId);
        $em->remove($product);
        $em->flush();

        return new Response('Removed product with id '.$productId);
    }
}