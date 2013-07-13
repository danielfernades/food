<?php

class LangualFactorsController extends ApiController
{
    public function __construct(LangualFactor $model)
    {
        $this->items = $model;
        parent::__construct();
    }
}

