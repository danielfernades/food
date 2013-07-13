<?php

class LangualFactorDescriptionsController extends ApiController
{
    public function __construct(LangualFactorDescription $model)
    {
        $this->items = $model;
        parent::__construct();
    }
}

