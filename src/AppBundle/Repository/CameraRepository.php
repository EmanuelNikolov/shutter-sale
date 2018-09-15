<?php

namespace AppBundle\Repository;

use AppBundle\Form\Model\FilterCameras;
use Doctrine\Common\Collections\Criteria;

/**
 * CameraRepository
 */
class CameraRepository extends \Doctrine\ORM\EntityRepository
{

    public function findAllByFilter(FilterCameras $filter)
    {
        return $this->createQueryBuilder('camera')
          ->addCriteria(self::createFilterCamerasCriteria($filter))
          ->getQuery()
          ->getResult();
    }

    public static function createFilterCamerasCriteria(FilterCameras $filter)
    {
        return Criteria::create()
          ->andWhere(Criteria::expr()->gte('quantity', $filter->getStock()))
          ->orderBy([$filter->getSortBy() => $filter->getOrderBy()]);
    }
}
