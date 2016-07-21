<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserProfileController extends Controller{

	/**
     * @Route("/order", name="order_list")
     */
    public function orderAction(Request $request){
    	if (!array_key_exists('bucket_list', $_COOKIE)){
            return $this->render(
                'personal/personal.html.twig',
                [
                	'page_title' => 'Интернет-магазин | Мои заказы',
                	'site_name'	 => 'Мои заказы',
                	'db'		 => '[]'
                ]);
        }
    }
}

?>