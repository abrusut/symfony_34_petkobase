<?php

namespace AppBundle\Controller;

use AppBundle\Service\AtributoConfiguracionService;
use AppBundle\Service\FileUploaderService;
use AppBundle\Service\JsonService;
use AppBundle\Service\MailerService;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\View\TwitterBootstrap4View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Default controller.
 *
 * @Route("/default")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/index", name="public_home")
     */
    public function indexAction(Request $request)
    {
    
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Persona')->createQueryBuilder('zzz');
    
        $filter_response = $this->filter($queryBuilder, $request);
        if ($filter_response instanceof RedirectResponse) {
            return $filter_response;
        }
        list($filterForm, $queryBuilder) = $filter_response;
    
        list($personas, $pagerHtml) = $this->paginator($queryBuilder, $request);
    
        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);
    
        return $this->render('persona/index.html.twig', array(
            'personas' => $personas,
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
        $filterForm = $this->createForm('AppBundle\Form\PersonaFilterType');
        
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
                return $this->redirectToRoute('persona', $filterUrl);
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
            return $me->generateUrl('persona', $requestParams);
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
    
    
}
