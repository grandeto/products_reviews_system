<?php

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager){
        for($i = 0; $i < 10; $i++){
            $user = new User();
            if($i == 0) {
                $user->setUsername('admin');
                $user->setEmail('admin@admin.com');
                $user->setRoles(array('ROLE_ADMIN'));
            } else {
                $user->setUsername('user'.$i);
                $user->setEmail('user'.$i.'@user.com');
                $user->setRoles(array('ROLE_USER'));
            }
            $user->setPlainPassword('1234');
            $user->setEnabled(true);

            $manager->persist($user);

            // Reference added once
            if($i == 0) {
                $this->addReference('user', $user); //admin
            }
        }

        $manager->flush();
    }

    public function getOrder(){
        return 1;
    }
}
