<?php


namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\AtributoConfiguracion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AtributoConfiguracionFixture extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $atrConfiguracion = new AtributoConfiguracion();
        $atrConfiguracion->setClave('files_directory');
        $atrConfiguracion->setValor('web/uploads/imagenes_denuncias');
        $manager->persist($atrConfiguracion);

        $atrConfiguracion = new AtributoConfiguracion();
        $atrConfiguracion->setClave('mail_incumpl_to');
        $atrConfiguracion->setValor('["galescano@santafe.gov.ar", "abrusutti@santafe.gov.ar"]');
        $manager->persist($atrConfiguracion);

        $atrConfiguracion = new AtributoConfiguracion();
        $atrConfiguracion->setClave('mail_incumpl_from');
        $atrConfiguracion->setValor('no-reply@santafe.gov.ar');
        $manager->persist($atrConfiguracion);

        $atrConfiguracion = new AtributoConfiguracion();
        $atrConfiguracion->setClave('contacto_mail');
        $atrConfiguracion->setValor('precios.santafesinos@santafe.gov.ar');
        $manager->persist($atrConfiguracion);

        $atrConfiguracion = new AtributoConfiguracion();
        $atrConfiguracion->setClave('contacto_telefono');
        $atrConfiguracion->setValor('0342 4505300 int. 4232');
        $manager->persist($atrConfiguracion);

        $manager->flush();
    }
}