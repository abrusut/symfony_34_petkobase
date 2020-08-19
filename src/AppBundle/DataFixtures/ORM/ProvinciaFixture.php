<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Provincia;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class ProvinciaFixture extends Fixture implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $provincias = array(
            array('area_numero' => 2,'nombre' => 'Ciudad Autónoma de Buenos Aires'),
            array('area_numero' => 6,'nombre' => 'Buenos Aires'),
            array('area_numero' => 10,'nombre' => 'Catamarca'),
            array('area_numero' => 14,'nombre' => 'Córdoba'),
            array('area_numero' => 18,'nombre' => 'Corrientes'),
            array('area_numero' => 22,'nombre' => 'Chaco'),
            array('area_numero' => 26,'nombre' => 'Chubut'),
            array('area_numero' => 30,'nombre' => 'Entre Ríos'),
            array('area_numero' => 34,'nombre' => 'Formosa'),
            array('area_numero' => 38,'nombre' => 'Jujuy'),
            array('area_numero' => 42,'nombre' => 'La Pampa'),
            array('area_numero' => 46,'nombre' => 'La Rioja'),
            array('area_numero' => 50,'nombre' => 'Mendoza'),
            array('area_numero' => 54,'nombre' => 'Misiones'),
            array('area_numero' => 58,'nombre' => 'Neuquén'),
            array('area_numero' => 62,'nombre' => 'Río negro'),
            array('area_numero' => 66,'nombre' => 'Salta'),
            array('area_numero' => 70,'nombre' => 'San Juan'),
            array('area_numero' => 74,'nombre' => 'San Luis'),
            array('area_numero' => 78,'nombre' => 'Santa Cruz'),
            array('area_numero' => 82,'nombre' => 'Santa Fe'),
            array('area_numero' => 86,'nombre' => 'Santiago del Estero'),
            array('area_numero' => 90,'nombre' => 'Tucumán'),
            array('area_numero' => 94,'nombre' => 'Tierra del Fuego'),

        );
        foreach ($provincias as $provincia) {
            $entidad = new Provincia();
            $entidad->setAreaNumero($provincia['area_numero']);
            $entidad->setNombre($provincia['nombre']);
            $manager->persist($entidad);

            if ($entidad->getAreaNumero() == 82)
                $this->addReference('ProvSantaFe', $entidad);
        }
        $manager->flush();

    }

}
