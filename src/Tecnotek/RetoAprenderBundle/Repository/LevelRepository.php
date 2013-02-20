<?php
namespace Tecnotek\RetoAprenderBundle\Repository;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class LevelRepository extends EntityRepository
{
    public function getActivitiesCount($id)
    {
        $q = $this
            ->createQueryBuilder('level')
            ->select('count(unit)')
            ->leftJoin('level.units', 'unit')
            ->where('level.id = :id')
            ->setParameter('id', $id)
            ->getQuery();
        $count = 0;
        try {
            $count = $q->getSingleScalarResult();
        } catch (NoResultException $e) {
            //throw new UsernameNotFoundException(sprintf('Unable to find an active admin AcmeUserBundle:User object identified by "%s".', $username), null, 0, $e);
        }

        return $count;
    }

    public function supportsClass($class)
    {
        return $this->getEntityName() === $class || is_subclass_of($class, $this->getEntityName());
    }
}
?>
