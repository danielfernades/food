<?php

class FoodDescriptionsController extends ApiController
{
    public function __construct(FoodDescription $model)
    {
        $this->items = $model;
        parent::__construct();
    }
}

