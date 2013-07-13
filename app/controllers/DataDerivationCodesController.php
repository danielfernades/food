<?php

class DataDerivationCodesController extends ApiController
{
    public function __construct(DataDerivationCode $model)
    {
        $this->items = $model;
        parent::__construct();
    }
}

