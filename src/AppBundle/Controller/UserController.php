<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap4View;

use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * User controller.
 *
 * @Route("/admin/user")
 */
class UserController extends Controller
{
    /**
     * Lists all User entities.
     *
     * @Route("/", name="user")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:User')->createQueryBuilder('zzz');

        $filter_response = $this->filter($queryBuilder, $request);
        if ($filter_response instanceof RedirectResponse) {
            return $filter_response;
        }
        list($filterForm, $queryBuilder) = $filter_response;

        list($users, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        return $this->render('user/index.html.twig', array(
            'users' => $users,
            'pagerHtml' => $pagerHtml,
            'filterForm' => $filterForm->createView(),
            'totalOfRecordsString' => $totalOfRecordsString,

        ));
    }


    /**
    * Create filter form and process filter request.
    *
    */
    protected function filter($queryBuilder, $request)
    {
        $session = $request->getSession();
        $filterForm = $this->createForm('AppBundle\Form\UserFilterType');

        // Bind values from the request
        $filterForm->handleRequest($request);

    //Reset Filters
    if ($request->get('filter_action') == 'reset') {
        $request->query->remove('filter_action');
        $session->remove('filterUrl');
    }
    else {
        if ($filterForm->isValid()) {
            $filterUrl = $request->query->all();
            $session->set('filterUrl', $filterUrl);
            // Build the query from the given form object
            $this->get('petkopara_multi_search.builder')->searchForm( $queryBuilder, $filterForm->get('search'));
        }
        else if ( $request->get('pcg_page') || $request->get('pcg_sort_col') || $request->get('pcg_sort_order') ) {
            $filterUrl = $request->query->all();
            $session->set('filterUrl', $filterUrl);
        }
        else if ($session->has('filterUrl')) {
            $filterUrl = $session->get('filterUrl');
            $session->remove('filterUrl');
            return $this->redirectToRoute('user', $filterUrl);
        }
    }

    return array($filterForm, $queryBuilder);
    }

    /**
    * Get results from paginator and get paginator view.
    *
    */
    protected function paginator($queryBuilder, Request $request)
    {
        //sorting
        $sortCol = $queryBuilder->getRootAlias().'.'.$request->get('pcg_sort_col', 'id');
        $queryBuilder->orderBy($sortCol, $request->get('pcg_sort_order', 'desc'));
        // Paginator
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($request->get('pcg_show' , 10));

        try {
            $pagerfanta->setCurrentPage($request->get('pcg_page', 1));
        } catch (\Pagerfanta\Exception\OutOfRangeCurrentPageException $ex) {
            $pagerfanta->setCurrentPage(1);
        }
        
        $entities = $pagerfanta->getCurrentPageResults();

        // Paginator - route generator
        $me = $this;
        $routeGenerator = function($page) use ($me, $request)
        {
            $requestParams = $request->query->all();
            $requestParams['pcg_page'] = $page;
            return $me->generateUrl('user', $requestParams);
        };

        // Paginator - view
        $view = new TwitterBootstrap4View();
        $pagerHtml = $view->render($pagerfanta, $routeGenerator, array(
            'proximity' => 3,
            'prev_message' => 'anterior',
            'next_message' => 'siguiente',
        ));

        return array($entities, $pagerHtml);
    }
    
    
    
    /*
     * Calculates the total of records string
     */
    protected function getTotalOfRecordsString($queryBuilder, $request) {
        $totalOfRecords = $queryBuilder->select('COUNT(zzz.id)')->getQuery()->getSingleScalarResult();
        $show = $request->get('pcg_show', 10);
        $page = $request->get('pcg_page', 1);

        $startRecord = ($show * ($page - 1)) + 1;
        $endRecord = $show * $page;

        if ($endRecord > $totalOfRecords) {
            $endRecord = $totalOfRecords;
        }
        return "Mostrando $startRecord - $endRecord de $totalOfRecords Registros.";
    }
    
    

    /**
     * Displays a form to create a new User entity.
     *
     * @Route("/new", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
    
        $user = new User();
        $form   = $this->createForm('AppBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            $editLink = $this->generateUrl('user_edit', array('id' => $user->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>El nuevo registro se ha creado exitosamente.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'user' : 'user_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('user/new.html.twig', array(
            'user' => $user,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a User entity.
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(
        Request $request,
        User $user,
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('AppBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $plainPassword = $user->getPlainPassword();
            if ( $plainPassword && trim($plainPassword) != '') {
                $password = $passwordEncoder->encodePassword($user, $plainPassword);
                $user->setPassword($password);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha editado exitosamente');
            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }
        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a User entity.
     *
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
    
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha eliminado exitosamente');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'No se ha podido eliminar el registro');
        }
        
        return $this->redirectToRoute('user');
    }
    
    /**
     * Creates a form to delete a User entity.
     *
     * @param User $user The User entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete User by id
     *
     * @Route("/delete/{id}", name="user_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(User $user){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($user);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'El registro se ha eliminado exitosamente');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'No se ha podido eliminar el registro');
        }

        return $this->redirect($this->generateUrl('user'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="user_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('AppBundle:User');

                foreach ($ids as $id) {
                    $user = $repository->find($id);
                    $em->remove($user);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'El registro se ha eliminado exitosamente');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'No se ha podido eliminar el registro');
            }
        }

        return $this->redirect($this->generateUrl('user'));
    }
    

}
