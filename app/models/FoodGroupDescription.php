<?php

class FoodGroupDescription extends BaseModel
{
    protected $table = 'food_grp_desc';
    protected $primaryKey = 'fdgrp_cd';
    public static $schema = array(
        'fdgrp_cd' => array(
            'display' => 'Food Group Code',
        ),
        'gdgrp_desc' => array(
            'display' => 'Description',
        ),
    );
}

