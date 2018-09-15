<?php

namespace AppBundle\Form\Model;


class FilterCameras
{

    const VALID_SORT_BY = [
      'make',
      'model',
      'price',
    ];

    const VALID_ORDER_BY = [
      'ASC',
      'DESC',
    ];

    private $sortBy;

    private $orderBy;

    private $stock;

    /**
     * @return mixed
     */
    public function getSortBy()
    {
        return $this->sortBy;
    }

    /**
     * @param mixed $sortBy
     *
     * @return FilterCameras
     */
    public function setSortBy($sortBy)
    {
        $this->sortBy = $sortBy;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @param mixed $orderBy
     *
     * @return FilterCameras
     */
    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param mixed $stock
     *
     * @return FilterCameras
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
        return $this;
    }


}