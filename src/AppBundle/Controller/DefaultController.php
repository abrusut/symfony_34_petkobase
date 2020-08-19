<?php

namespace AppBundle\Controller;

use AppBundle\Service\AtributoConfiguracionService;
use AppBundle\Service\FileUploaderService;
use AppBundle\Service\JsonService;
use AppBundle\Service\MailerService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Default controller.
 *
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="public_home")
     */
    public function indexAction(Request $request)
    {

        return $this->render('default/index.html.twig', [
            'productos' => array(),
        ]);

    }

}
