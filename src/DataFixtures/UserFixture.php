<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    /**
     * @var UserPasswordEncoder
     */
    private $encoder;

    /**
     * UserFixture constructor.
     *
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach (range(1, 100) as $i) {
            $user = new User();
            $user->setEmail(sprintf('user%d@askfm.com', $i));
            $user->setUsername(sprintf('user-%d', $i));
            $user->setPassword($this->encoder->encodePassword($user, 123456));
            $user->generateToken();

            $manager->persist($user);
        }

        $manager->flush();
    }
}
