<?php
namespace Tecnotek\RetoAprenderBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class TestRepository extends EntityRepository
{
    public function getActivitiesCount($id)
    {
        $q = $this
            ->createQueryBuilder('question')
            ->select('question')
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
