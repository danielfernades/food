<?php

class FootnotesController extends ApiController
{
    public function __construct(Footnote $model)
    {
        $this->items = $model;
        parent::__construct();
    }
}

