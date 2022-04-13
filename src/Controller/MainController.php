<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

Class MainController extends AbstractController{

    /** 
     * @Route("/home", name="home")
     */
    public function home(){

        var_dump("home");
        die;
    }


}