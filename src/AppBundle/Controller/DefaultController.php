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

use AppBundle\Menu\Menu;

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
                'Category'    => $product->getSubCategory()->getCategory()->getName(),
                'SubCategory' => $product->getSubCategory()->getName(),
                'Name'        => $product->getName(),
                'Count'       => $product->getCount(),
                'RetailPrice' => $product->getRetailPrice()
            ];
        }
        return $this->render(
            'show.html.twig', 
            $this->generateArrayForTwigRender(
                'Интернет-магазин | Все продукты', 
                $this->makeHtmlCurCategory('Все продукты'), 
                $result
            ));
    }

    /**
     * @Route("/product/{productId}", name="product")
     */
    public function showProductAction($productId)
    {
        $product = $this->getDoctrine()
                        ->getRepository('AppBundle:Product')
                        ->findOneByIdJoinedToSubCategory($productId);
        
        if (!$product){
            return new Response('No product found for id = '.$productId);
        }
        
        $result[] = [
            'Category'    => $product->getSubCategory()->getCategory()->getName(),
            'SubCategory' => $product->getSubCategory()->getName(),
            'Name'        => $product->getName(),
            'Count'       => $product->getCount(),
            'RetailPrice' => $product->getRetailPrice()
        ];
        
        return $this->render('show.html.twig', 
            ['page_title' => 'Интернет-магазин | '.$product->getName(), 
             'path'       => $product->getName(),
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
        $result = [];
        foreach ($category->getSubCategory() as $subCategory) {
            foreach ($subCategory->getProducts() as $product){
                $result[] = [
                    'Category'    => $category->getName(),
                    'SubCategory' => $subCategory->getName(),
                    'Name'        => $product->getName(),
                    'Count'       => $product->getCount(),
                    'RetailPrice' => $product->getRetailPrice()
                ];
            }
        }

        return $this->render(
            'show.html.twig', 
            $this->generateArrayForTwigRender(
                'Интернет-магазин | '. $category->getName(), 
                $this->generatePath(0, $product->getPath()).
                $this->makeHtmlCurCategory($category->getName()), 
                $result
            ));
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

        foreach ($subcategory->getProducts() as $product){
            $result[] = [
                'Category'    => $subcategory->getCategory()->getName(),
                'SubCategory' => $subcategory->getName(),
                'Name'        => $product->getName(),
                'Count'       => $product->getCount(),
                'RetailPrice' => $product->getRetailPrice()
            ];
        }
        
        return $this->render('show.html.twig', 
            $this->generateArrayForTwigRender(
                'Интернет-магазин | '. $subcategory->getName(), 
                $this->generatePath(1, $product->getPath()).
                $this->makeHtmlCurCategory($subcategory->getName()), 
                $result
            ));
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
        
        $cnt = 0;
        foreach ($productsArr as $productElem){
            $cnt++;

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
                $subCategory->setCategory($category);
            } else {
                $subCategory = $resultSubCategory[0];
                $resultSubCategory = [];
            }
            //echo $category->getName()."|\n".$subCategory->getName()."|\n".$productElem['Name']."|\n".$productElem['Count']."|\n".$productElem['RetailPrice'];
 
            $product = new Product();
            $product->setName($productElem['Name']);
            $product->setCount($productElem['Count']);
            $product->setRetailPrice($productElem['RetailPrice']);

           // $product->setCategory($category);
            $product->setSubCategory($subCategory);
            $product->setPath($category->getId().'.'.$subCategory->getId());
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

    private function makeHtmlLink($src, $itemName){
        return "<a class='path_link' href='/".$src."'>".$itemName."</a>";
    }

    private function makeHtmlCurCategory($itemName){
        return "<span class='cur_subcategory'>".$itemName."</span>";
    }

    private function generatePath($level, $path){
        $pathElements = explode('.', $path);
        $result = "";
        if ($level > 0){
            $category = $this->getDoctrine()
                ->getRepository('AppBundle:Category')
                ->find($pathElements[0]);
            if ($level > 1){
                $subCategory = $this->getDoctrine()
                    ->getRepository('AppBundle:SubCategory')
                    ->find($pathElements[1]);
                $result = ">".$this->makeHtmlLink('subcategory/'.$subCategory->getId(), $subCategory->getName());
            }
            $result = ">".$this->makeHtmlLink('category/'.$category->getId(), $category->getName()).$result;
        }

        return $this->makeHtmlLink('', 'Все продукты').$result.">";
    }

    private function generateArrayForTwigRender($page_title, $header, $result){
        $site_name = 'Интернет-магазин';
        return [
            'page_title' => $page_title, 
            'site_name'  => $site_name,
            'path'       => $header,
            'db'         => '<script type="text/javascript">var data = '.
                             json_encode($result, JSON_UNESCAPED_UNICODE).
                            ';</script>'];
    }
}