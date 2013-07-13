<?php

class DataSourcesController extends ApiController
{
    public function __construct(DataSource $model)
    {
        $this->items = $model;
        parent::__construct();
    }
}

