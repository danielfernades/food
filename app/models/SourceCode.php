<?php

class SourceCode extends BaseModel
{
    protected $table = 'source_code';
    protected $primaryKey = 'src_cd';
    public static $schema = array(
        'src_cd' => array(
            'display' => 'Source Code',
        ),
        'srccd_desc' => array(
            'display' => 'Source Description',
        ),
    );
}

