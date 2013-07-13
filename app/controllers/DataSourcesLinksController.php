<?php

class DataSourcesLinksController extends ApiController
{
    public function __construct(DataSourcesLink $model)
    {
        $this->items = $model;
        parent::__construct();
    }
}

