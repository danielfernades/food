<?php

class WeightsController extends ApiController
{
    public function __construct(Weight $model)
    {
        $this->items = $model;
        parent::__construct();
    }
}

