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

use AppBundle\Entity\Order;
use AppBundle\Entity\OrderElem;
use AppBundle\Entity\OrderState;
use AppBundle\Entity\User;

use AppBundle\Menu\Menu;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $products = $this->getDoctrine()->getRepository('AppBundle:Product')
                         ->findAll();
       
        if (!$products) return new Response('No products found');

        foreach ($products as $product){
            $subcategory = $product->getSubCategory();
            $result[] = $this->genProductInfo($subcategory->getCategory(), $subcategory, $product);
        }

        return $this->render('show.html.twig', 
                $this->genArrayForTwigRender([], 'Все продукты', $result));
    }

    /**
     * @Route("/personal", name="personal")
     */
    public function personalAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        return $this->render('personal/personal.html.twig', 
            $this->genArrayForTwigRender([], 'Мой профиль'));
    }

    /**
     * @Route("/orders/{selection}", name="orders")
     */
    public function orderSelectionAction($selection = 'all'){
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        
        $pageName = 'Мои заказы';
        $orders = [];
        $userId = $this->getUser()->getId();
        $rep = $this->getDoctrine()->getRepository('AppBundle:Order');
        if (strnatcasecmp($selection, 'all') == 0){
            $orders = $rep->findAllByUserIdOrderedByDate($userId);
        } elseif (strnatcasecmp($selection, 'canceled') == 0){
            $orders = $rep->findCanceledOrdersByUserId($userId);
            $pageName = 'Отмененные заказы';
        } elseif (strnatcasecmp($selection, 'opened') == 0){
            $orders = $rep->findOpenedOrdersByUserId($userId);
            $pageName = 'Открытые заказы';
        } elseif (strnatcasecmp($selection, 'bought') == 0){
            $orders = $rep->findBoughtOrdersByUserId($userId);
            $pageName = 'Выкупленные заказы';
        }

        $res = [];
        foreach ($orders as $order) {
            $pres = [];
            foreach ($order->getProductList() as $productElem){
                $pres[] = 
                    '{ "id": '.$productElem->getProductId().
                    ', "Name": "'.$productElem->getProductName().'"'.
                    ', "RetailPrice": "'.$productElem->getPrice().'"'.
                    ', "Count": '.$productElem->getCount().
                    ', "Sum": '.$productElem->getSum().' }'
                ;
            }

            $res[] = [
                'id' => $order->getId(),
                'productList' => '['.implode(",", $pres).']',
                'sum'  => $order->getTotalSum(),
                'date' => $order->getOrderDate()->format('Y-m-d H:i:s'),
                'state' => $order->getState()->getName(),
                'levelState' => $order->getState()->getLevel(),
                'endDeliveryPoint' => $order->getEndDeliveryPoint()->getFieldsValue(),
                'currentDeliveryPoint' => $order->getCurrentDeliveryPoint()->getFieldsValue(),
                'deliveryState' => $order->getDeliveryState()->getName(),
                'deliveryDate' => $order->getDeliveryDate()->format('Y-m-d H:i:s'),
                'address' => $order->getEndDeliveryPoint()->getAddress()
            ];
        }

        $arr = $this->genArrayForTwigRender([], $pageName);
        $arr['orders'] = $res;

        return $this->render('personal/orders.html.twig', $arr);
    }

    /**
     * @Route("/create_order", name="create_order")
     */
    public function orderAction(Request $request)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')
                     ->find($this->getUser()->getId());
        
        $state = $this->getDoctrine()->getRepository('AppBundle:OrderState')
                      ->findOneByName('Заказ принят');
        $dprep = $this->getDoctrine()->getRepository('AppBundle:DeliveryPoint');                      
        
        $curDelPoint = $dprep->find(1);
        $endDelPoint = $dprep->find($_GET['endDeliveryPoint']);
        $delState = $this->getDoctrine()->getRepository('AppBundle:DeliveryState')->find(1);
        $em = $this->getDoctrine()->getManager();

        $order = new Order();
        $order->setTotalSum(intval($_COOKIE['bucket_sum']));
        $order->setOrderDate(new \DateTime("now"));
        $order->setState($state);
        $order->setUser($user);
        $order->setEndDeliveryPoint($endDelPoint);
        $order->setCurrentDeliveryPoint($curDelPoint);
        $order->setDeliveryState($delState);

        $em->persist($order);

        foreach (json_decode($_GET['order']) as $val) {

            $orderElem = new OrderElem();
            $orderElem->setProductId($val->id);

            $orderElem->setProductName($val->Name);
            $orderElem->setPrice($val->RetailPrice);
            $orderElem->setCount($val->Count);
            $orderElem->setSum($val->Sum);
            $orderElem->setOrder($order);

            $em->persist($orderElem);
        }

        
        $em->flush();

        return new JsonResponse([
                'id' => $order->getId(),
                'date' => $order->getOrderDate()->format('Y-m-d H:i:s')
            ]);
    }

    /**
     * @Route("/cancel_order", name="cancel_order")
     */
    public function cancelOrder(Request $request){
        $em = $this->getDoctrine()->getManager();
        $order = $this->getDoctrine()->getRepository('AppBundle:Order')
                       ->find($_GET['id']);
        $state = $this->getDoctrine()->getRepository('AppBundle:OrderState')
                      ->findOneByName('Заказ отменен клиентом');
        $order->setState($state);
        $em->persist($order);
        $em->flush();          
        return new Response('ok');
    }

    /**
     * @Route("/category/{categoryId}", name="category")
     */
    public function showCategoryAction($categoryId)
    {
        $category = $this->getDoctrine()->getRepository('AppBundle:Category')
                    ->find($categoryId);

        if (!$category) return new Response('No category found for id = '.$categoryId);

        $result = [];
        foreach ($category->getSubCategory() as $subCategory){
            foreach ($subCategory->getProducts() as $product){
                $result[] = $this->genProductInfo($category, $subCategory, $product);
            }
        }

        return $this->render('show.html.twig', 
                $this->genArrayForTwigRender($this->genPath(), $category->getName(), $result));
    }

    /**
     * @Route("/subcategory/{subcategoryId}", name="subcategory")
     */
    public function showSubCategoryAction($subcategoryId)
    {
        $subcategory = $this->getDoctrine()
            ->getRepository('AppBundle:SubCategory')
            ->find($subcategoryId);

        if (!$subcategory) return new Response('No subcategory found for id = '.$subcategoryId);

        foreach ($subcategory->getProducts() as $product){
            $result[] = $this->genProductInfo($subcategory->getCategory(), $subcategory, $product);
        }
        
        return $this->render('show.html.twig', 
                $this->genArrayForTwigRender(
                    $this->genPath($subcategory->getCategory()), $subcategory->getName(), $result
                ));
    }

    /**
     * @Route("/product/{productId}", name="product")
     */
    public function showProductAction($productId)
    {
        $product = $this->getDoctrine()->getRepository('AppBundle:Product')
                        ->findOneByIdJoinedToSubCategory($productId);
        
        if (!$product) return new Response('No product found for id = '.$productId);
        
        $subcategory = $product->getSubCategory();
        $category = $product->getSubCategory()->getCategory();
        $result[] = $this->genProductInfo($category, $subcategory, $product);

        return $this->render('show.html.twig', 
                $this->genArrayForTwigRender(
                    $this->genPath($category, $subcategory), 
                    $product->getName(), 
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
                $this->genArrayForTwigRender([], 'Моя корзина'));
        }
        $arr = json_decode($_COOKIE['bucket_list'], true);
        $ids = array_keys($arr);

        $products = $this->getDoctrine()->getRepository('AppBundle:Product')
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

        $DeliveryPoints = $this->getDoctrine()->getRepository('AppBundle:DeliveryPoint')->findAll();

        $vars = $this->genArrayForTwigRender([], 'Моя корзина', $result);
        $address = [];
        foreach ($DeliveryPoints as $dp) {
            $address[] = [
                'id' => $dp->getId(),
                'address' => $dp->getAddress()
            ];
        }
        $vars['addresses'] = $address;/*json_encode($address, JSON_UNESCAPED_UNICODE);*/
        return $this->render('bucket.html.twig', $vars);
    }

    private function genProductInfo($category, $subcategory, $product){
        return [
            'id'          => $product->getId(),
            'Category'    => $category->getName(),
            'SubCategory' => $subcategory->getName(),
            'Name'        => $product->getName(),
            'Count'       => $product->getCount(),
            'RetailPrice' => $product->getRetailPrice()
        ];
    }

    private function genArrayForTwigRender($path, $curPage, $result = []){
        $site_name = 'Интернет-магазин';
        return [
            'page_title' => $site_name." - ".$curPage, 
            'site_name'  => $site_name,
            'path'       => $path,
            'curPage'    => $curPage,
            'db'         => '<script type="text/javascript">var data = '.
                             json_encode($result, JSON_UNESCAPED_UNICODE).
                            ';</script>'];
    }

    private function genPath($category = NULL, $subcategory = NULL){
        $path[] = [ 'name' => 'Каталог', 'url'  => '/' ];
        if (!$category) return $path;
        $path[] = [ 'name' => $category->getName(), 'url' => '/category/'.$category->getId() ];
        if (!$subcategory) return $path;
        $path[] = [ 'name' => $subcategory->getName(), 'url' => '/subcategory/'.$subcategory->getId() ];
        return $path;
    }
}