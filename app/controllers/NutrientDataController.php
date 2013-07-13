<?php

class NutrientDataController extends ApiController
{
    public function __construct(NutrientData $model)
    {
        $this->items = $model;
        parent::__construct();
    }
}

