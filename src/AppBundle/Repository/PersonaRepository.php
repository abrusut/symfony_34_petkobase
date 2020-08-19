<?php


namespace AppBundle\Repository;


use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use App\Entity\Persona;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Doctrine\Persistence\ManagerRegistry;
use Faker\Provider\Person;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PersonaRepository extends ServiceEntityRepository
{
    private $tokenStorage;
    /**
     * @var ManagerRegistry
     */
    private $registry;
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Persona::class);
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