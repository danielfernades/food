<?php
use \Illuminate\Database\Eloquent\ModelNotFoundException;

class BaseModel extends Eloquent
{
    protected $guarded = array('id');
    public $timestamps = false;

    public static $schema = array();

    public static function findWhere($field, $id, $columns = array('*'))
    {
        $model = self::where($field, '=', $id)->first($columns);
        if( ! is_null($model) ) {
            return $model;
        }
        throw new ModelNotFoundException;
    }

    public static function search($searchTerms = array())
    {
        if (empty($searchTerms)) {
            return self::all();
        }

        foreach($searchTerms as $key => $value) {
            $search = self::where($key, 'like', '%'.$value.'%');
        }

        return $search->get();
    }

    public function __call($name, $args)
    {
        if (substr($name, 0, 4) == 'find'){
            $id = $args[0];
            $columns = isset($args[1]) ? $args[1] : array('*');
            return static::findWhere(substr($name, 4), $id, $columns);
        }
        return parent::__call($name, $args);
    }

    public function getIdAttribute()
    {
        if (isset($this->id)) {
            return $this->id;
        }

        $primaryKey = $this->primaryKey;
        return $this->$primaryKey;
    }
}

