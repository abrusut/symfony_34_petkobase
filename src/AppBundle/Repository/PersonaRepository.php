<?php


namespace AppBundle\Repository;




use AppBundle\Entity\Persona;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class PersonaRepository extends ServiceEntityRepository
{
    
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Persona::class);
    }
    
    /**
     * @param $termino Palabra, id, Buscado
     * @param $page Pagina pedida
     * @param $size Cantidad de registros pedidos
     * @return Persona[]
     */
    public function findByTermino($termino, $page = 1, $size = 20, $order)
    {
        $firstResult = ($page -1) * $size;
        
        $queryBuilder = $this->createQueryBuilder('a')
            ->andWhere('a.apellido LIKE :termino')
            ->setParameter('termino', '%'.$termino.'%')
            ->orWhere('a.nombre LIKE :termino')
            ->setParameter('termino', '%'.$termino.'%')
            ->orWhere('a.numeroDocumento LIKE :termino')
            ->setParameter('termino', '%'.$termino.'%')
            ->orWhere('a.email LIKE :termino')
            ->setParameter('termino', '%'.$termino.'%');
        
        if(!is_null($order) && count($order)>0){
            foreach ($order as  $clave => $valor)
            {
                $queryBuilder->orderBy('a.'.$clave , $valor);
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