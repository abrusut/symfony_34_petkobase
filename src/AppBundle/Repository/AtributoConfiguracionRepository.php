<?php

namespace AppBundle\Repository;

use AppBundle\Entity\AtributoConfiguracion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * AtributoConfiguracionRepository
 *
 */
final class AtributoConfiguracionRepository extends ServiceEntityRepository
{
    /**
     * @var EntityRepository
     */
    private $repository;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, AtributoConfiguracion::class);
        $this->repository = $this->getEntityManager()->getRepository(AtributoConfiguracion::class);
    }

    public function save(AtributoConfiguracion $atributoConfiguracion)
    {
        $this->repository->persist($atributoConfiguracion);
        $this->repository->flush();
    }

    public function findAtributoConfiguracionByClave($clave){
        return $this->findBy(array(
                'clave' => $clave
            )
        );
    }
}


?>