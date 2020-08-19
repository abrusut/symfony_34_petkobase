<?php

namespace AppBundle\Repository;


use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use App\Entity\TipoDocumento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Doctrine\Persistence\ManagerRegistry;

class TipoDocumentoRepository  extends ServiceEntityRepository
{
    private $tokenStorage;
    /**
     * @var ManagerRegistry
     */
    private $registry;
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoDocumento::class);
    }
    
    /**
     * @param $termino Palabra, id, Buscado
     * @param $page Pagina pedida
     * @param $size Cantidad de registros pedidos
     * @return TipoDocumento[]
     */
    public function findByTermino($termino, $page = 1, $size = 20, $order)
    {
        $firstResult = ($page -1) * $size;
        
        $queryBuilder = $this->createQueryBuilder('t')
            ->andWhere('t.tipo LIKE :termino')
            ->setParameter('termino', '%'.$termino.'%');
        
        if(!is_null($order) && count($order)>0){
            foreach ($order as  $clave => $valor)
            {
                $queryBuilder->orderBy('t.'.$clave , $valor);
            }
        }
        
        $criteria = Criteria::create()
            ->setFirstResult($firstResult)
            ->setMaxResults($size);
        $queryBuilder->addCriteria($criteria);
        
        $doctrinePaginator = new DoctrinePaginator($queryBuilder);
        $paginator = new Paginator($doctrinePaginator);
        
        return $paginator;
    }
    
    
    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}