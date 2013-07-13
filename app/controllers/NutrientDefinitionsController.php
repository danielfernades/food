<?php

class NutrientDefinitionsController extends ApiController
{
    public function __construct(NutrientDefinition $model)
    {
        $this->items = $model;
        parent::__construct();
    }
}

