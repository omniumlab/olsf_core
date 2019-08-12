<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 20/11/2017
 * Time: 8:29
 */

namespace Core\Controllers\Symfony;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AngularController extends Controller
{

    /**
     * AngularCRUDController constructor.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * @Route("/{url}", requirements={"url": "^((?!%api_prefix%/.*).)*$"})
     * @Method({"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction($url)
    {

        $params = [];
        if ($url === "")
            $params["isLogin"] = true;

        return $this->render("main_angular.html.twig", $params);
    }
}
