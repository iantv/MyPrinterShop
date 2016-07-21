<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Component\HttpFoundation\JsonResponse;

use Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Entity;

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
                'id'          => $product->getId(),
                'Category'    => $product->getSubCategory()->getCategory()->getName(),
                'SubCategory' => $product->getSubCategory()->getName(),
                'Name'        => $product->getName(),
                'Count'       => $product->getCount(),
                'RetailPrice' => $product->getRetailPrice()
            ];
        }
        return $this->render(
            'show.html.twig', 
            $this->generateArrayForShowTwigRender(
                'Интернет-магазин | Все продукты', 
                $this->makeHtmlCurCategory('Все продукты'), 
                $result
            ));
    }

    /**
     * @Route("/personal", name="personal")
     */
    public function personalAction(Request $request)
    {
        return $this->render(
            'personal/personal.html.twig', 
            $this->generateArrayForShowTwigRender(
                'Интернет-магазин | Личный кабинет', 
                'Личный кабинет'
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
            'id'          => $product->getId(),
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
                    'id'          => $product->getId(),
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
            $this->generateArrayForShowTwigRender(
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
                'id'          => $product->getId(),
                'Category'    => $subcategory->getCategory()->getName(),
                'SubCategory' => $subcategory->getName(),
                'Name'        => $product->getName(),
                'Count'       => $product->getCount(),
                'RetailPrice' => $product->getRetailPrice()
            ];
        }
        
        return $this->render('show.html.twig', 
            $this->generateArrayForShowTwigRender(
                'Интернет-магазин | '. $subcategory->getName(), 
                $this->generatePath(1, $product->getPath()).
                $this->makeHtmlCurCategory($subcategory->getName()), 
                $result
            ));
    }


    /**
     * @Route("/bucket", name="bucket")
     */
    public function bucketAction(Request $request)
    {   
        if (!array_key_exists('bucket_list', $_COOKIE)){
            return $this->render(
                'bucketisempty.html.twig', 
                $this->generateArrayForShowTwigRender(
                    'Интернет-магазин | Моя корзина', 
                    $this->makeHtmlCurHeader('Моя корзина'), 
                    []
                ));
        }
        $arr = json_decode($_COOKIE['bucket_list'], true);
        $ids = array_keys($arr);

        $products = $this->getDoctrine()
                        ->getRepository('AppBundle:Product')
                        ->findByIds($ids);
        
        $result = [];
        foreach ($products as $product){
           $result[] = [
                'id'          => $product->getId(),
                'Name'        => $product->getName(),
                'RetailPrice' => $product->getRetailPrice(),
                'Count'       => $arr[$product->getId()],
                'Sum'         => $arr[$product->getId()]*$product->getRetailPrice()
            ];
        }

        return $this->render(
            'bucket.html.twig', 
            $this->generateArrayForShowTwigRender(
                'Интернет-магазин | Моя корзина', 
                $this->makeHtmlCurHeader('Моя корзина'), 
                $result
            ));
    }

    private function makeHtmlLink($src, $itemName){
        return "<a class='path_link' href='/".$src."'>".$itemName."</a>";
    }

    private function makeHtmlCurCategory($itemName){
        return "<span class='cur_subcategory'>".$itemName."</span>";
    }

    private function makeHtmlCurHeader($itemName){
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

    private function generateArrayForShowTwigRender($page_title, $header, $result = []){
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