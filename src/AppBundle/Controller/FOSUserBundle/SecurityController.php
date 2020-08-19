<?php

namespace AppBundle\Controller\FOSUserBundle;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class SecurityController extends Controller
{
    use TargetPathTrait;

    /**
     * @param Request $request
     * @Route("/redirecthome", name="security_redirect")
     * @return RedirectResponse
     */
    public function redirectAfterLoginAction(Request $request, RouterInterface $router, AuthorizationCheckerInterface $authorizationChecker)
    {
//        var_dump('a redireccionar');die;
        $url = $this->getTargetPath($request->getSession(), 'main');
        if (!$url) {
            if ($authorizationChecker->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('admin_inicio');
            }
            else {
                $url = $router->generate('public_home');
            }
        }
        return $this->redirect($url);
    }

    /**
     *
     * @Route("/admin/inicio", name="admin_inicio")
     */
    public function inicioAction()
    {
        $this->addFlash('info'
            , 'Seleccione alguna funcionalidad del menú para comenzar.'
        );
        return $this->render('security/admin.home.html.twig');
    }

    /**
     *
     * @Route("/accesodenegado", name="security_accesodenegado")
     */
    public function failureAction(Request $request)
    {
        $this->addFlash('info'
            , 'El usuario autenticado no posee los permisos necesarios.'
            . ' <a href="' . $this->generateUrl('fos_user_security_login') . '" title="Reintentar">Ingresar con otro usuario</a>'
        );
        return $this->render('security/accesodenegado.html.twig');
    }

}