<?php


namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $entidad = new User();
        $entidad->setUsername('galescano');
        $entidad->setEmail('galescano@santafe.gov.ar');
        $entidad->setPassword(
            $this->passwordEncoder->encodePassword($entidad, 'test123')
        );
        $entidad->setRoles(['ADMIN']);
        $manager->persist($entidad);

        $manager->flush();
    }

}