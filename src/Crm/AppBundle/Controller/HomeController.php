<?php

namespace Crm\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function homeAction()
    {
        // Redirect to main controller.
        return $this->redirectToRoute('crm_app_company_list');
    }
}