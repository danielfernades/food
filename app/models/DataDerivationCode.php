<?php

class DataDerivationCode extends BaseModel
{
    protected $table = 'data_derivation_code';
    protected $primaryKey = 'deriv_cd';
    public static $schema = array(
        'deriv_cd' => array(
            'display' => 'Derivation Code',
        ),
        'deriv_desc' => array(
            'display' => 'Derivation Description',
        ),
    );
}

