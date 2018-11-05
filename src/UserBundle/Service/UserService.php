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
     * Returns top 5 commenting users sorted by DESC comments count
     * @return User array
     */
    public function getTopFiveReviewingUsers(){

        $RAW_QUERY = 'SELECT author_id, count(*) as count 
            FROM review
            WHERE author_id IS NOT NULL 
            GROUP BY author_id
            ORDER BY count DESC
            LIMIT 5';
        
        $connection = $this->em->getConnection();
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();

        $result = $statement->fetchAll();
        return $result;
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
