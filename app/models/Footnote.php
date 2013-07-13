<?php

class Footnote extends BaseModel
{
    protected $table = 'footnote';
    protected $primaryKey = array('ndb_no', 'footnt_no', 'footnt_typ');
}

