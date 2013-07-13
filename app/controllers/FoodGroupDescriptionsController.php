<?php

class FoodGroupDescriptionsController extends ApiController
{
    public function __construct(FoodGroupDescription $model)
    {
        $this->items = $model;
        parent::__construct();
    }
}

