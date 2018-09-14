<?php

namespace AppBundle\Repository;

/**
 * CameraRepository
 */
class CameraRepository extends \Doctrine\ORM\EntityRepository
{

    public function findAllByFilter(
      string $sortBy,
      string $orderBy,
      string $stock
    ) {
        return $this->createQueryBuilder('camera')
          ->where('camera.quantity >= :group')
          ->orderBy('camera.' . $sortBy, $orderBy)
          ->setParameter('group', $stock)
          ->getQuery()
          ->getResult();
    }
}
