<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AuthController extends Controller
{
    /**
     * @Route("/", name="auth")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $a = 123;

        return ['a' => $a];
    }
}