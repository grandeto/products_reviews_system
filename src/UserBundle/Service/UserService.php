<?php

namespace UserBundle\Service;

use Doctrine\ORM\EntityManager;
use UserBundle\Entity\User;

class UserService{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $userRepository;

    /**
     * @param EntityManager $entityManager
     */
    function __construct(EntityManager $entityManager){
        $this->em = $entityManager;
        $this->userRepository = $this->em->getRepository('UserBundle:User');
    }

    /**
     * Returns all users sorted by ASC username
     * @return User array
     */
    public function getUsers(){
        return $this->userRepository->findBy(
            array('username' => 'ASC')
        );
    }

    /**
     * Returns top 5 commenting users sorted by ASC username
     * @return User array
     */
    public function getTopFiveCommentingUsers(){

        // $RAW_QUERY = 'SELECT username FROM user';
        
        // $connection = $this->$em->getConnection();
        // $statement = $connection->prepare($RAW_QUERY);
        // $statement->execute();

        // $result = $statement->fetchAll();
        // return $result;

        return $this->userRepository->findBy(
            array('username' => 'ASC')
        );
    }

    /**
     * Delete an User object
     * @param User $user
     */
    public function delete(User $user){
        $this->em->remove($user);
        $this->em->flush();
    }
}
