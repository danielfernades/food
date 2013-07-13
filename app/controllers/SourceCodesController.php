<?php

class SourceCodesController extends ApiController
{
    public function __construct(SourceCode $model)
    {
        $this->items = $model;
        parent::__construct();
    }
}

