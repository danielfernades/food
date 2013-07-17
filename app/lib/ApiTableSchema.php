<?php

/**
 * This is a helper class used to tell any ApiController what fields are available,
 * what validation rules to use, what fields are editable, and so on.
 * 
 */
class ApiTableSchema
{
    const MAXCOLS = 5;
    const MAXLEN  = 150;

    protected $model;
    protected $tableCache;
    protected $fieldCache;
    protected $userSchema;
    protected $schemaManager;
    protected $userAttributes;

    public function __construct($model, $controller = Null)
    {
        $this->model = $model;
        $this->schemaManager = DB::connection()->getDoctrineSchemaManager();
        $this->userSchema = array();
        $this->userAttributes = array('controller' => $controller);
    }

    /**
     * Returns an associative array with information about the table:
     * 
     *   name        The database table name
     *   display     What should be shown to the user as the table's name
     *   type        The 2-letter object type code for this particular type of data (listed in kalani_object_types table)
     *   index       The fields that should be shown in the index view
     *   count       The default record count to be shown in index view
     */
    public function getTable()
    {
        if ($this->tableCache) {
            return $this->tableCache;
        }

        $name = $this->model->getTable();
        $class = get_class($this->model);

        $table = array(
            'name'      => $name,
            'display'   => getDisplayName($name),
            'index'     => $this->getIndexFields(),
            'count'     => 50,
        );

        $table = array_merge($table, $this->getTableAttributes());
        $this->tableCache = $table;
        return $table;
    }


    /**
     * Return an associative array of the fields for this table with relevant data.
     * Optionally, just return one parameter.
     * 
     *   name        The database column name of the field
     *   display     What should be shown to the user as the field's name
     *   type        Data type for field data (eg, string, integer, etc.) 
     *   length      Maximum length (for string fields)
     *   fillable    True/False: Can this field be filled via mass-assignment? (True is required for it to be editable by api) 
     *   searchable  True/False: Can this field be searched? (Default is True for all indexed fields)
     *   lookup      Instructions for a lookup to another table
     *   rules       All validation rules applicable to this field (get from the database, and from passed-in values)
     */
    public function getFields()
    {
        // Cache this data -- it shouldn't ever change during the lifespan of a request 
        if ($this->fieldCache) {
            return $this->fieldCache;
        } 

        $fields = array();
        $tableName = $this->model->getTable();
        $schema    = $this->getUserSchema();

        $cols = $this->schemaManager->listTableColumns($tableName);
        foreach($cols as $col) {
            $colName = $col->getName();
            $attributes = array(
                'name'      => $colName,
                'display'   => getDisplayName($colName),
                'type'      => (string) $col->getType(),
                'length'    => $col->getLength(),
                'fillable'  => $this->model->isFillable($colName),
                'searchable'=> $this->isIndexed($tableName, $colName),
                'lookup'    => Null,        // TODO: Automatically set up lookups for foreign keys
                'rules'     => Null,
            );

            if (isset($schema[$colName])) {
                $attributes = array_merge($attributes, $schema[$colName]);
            }
            $attributes['rules'] = ValidationRuleGenerator::getRules($tableName, $colName, $attributes['rules']);

            $fields[$colName] = $attributes;
        }
        $this->fieldCache = $fields;

        return $fields;
    }

    public function isIndexed($table, $column)
    {
        $indexArray = array();
        $indexList = $this->schemaManager->listTableIndexes($table);
        foreach($indexList as $item) {
            if(strpos($item->getName(), $column)!==False && count($item->getColumns())==1) {
                return True;
            }
        }
        return False;
    }

    /**
     * Return a single parameter from a single field
     * @param  [type] $field [description]
     * @param  [type] $param [description]
     * @return [type]        [description]
     */
    public function getFieldParam($field, $param)
    {
        $fields = $this->getFields();
        $returnField = $fields[$field];
        return $returnField[$param];
    }

    public function getFillableFields()
    {
        $allFields = $this->getFields();
        $fillable = array();

        foreach($allFields as $field) {
            if ($field['fillable']) {
                $fillable[] = $field;
            }
        }
        return $fillable;
    }

    /**
     * Return a list of fields to show on an index page
     * 
     * @return [type] [description]
     */
    public function getIndexFields()
    {
        if ($this->tableCache) {
            return $this->tableCache['index'];
        }

        $fields = $this->getFields();
        $fieldCount = 1;
        $fieldLen   = 0;
        $fieldList  = array();

        foreach($fields as $field) {
            if($field['fillable']) {
                $fieldList[] = $field['name'];
                $fieldCount += 1;
                $fieldLen   += ($field['type']=='String') ? $field['length'] : 15;
            }
            if ($fieldCount >= self::MAXCOLS || $fieldLen >= self::MAXLEN) {
                return $fieldList; 
            }
        }
        return $fieldList;
    }

    /**
     * Read the $schema variable from the model and merge it with the auto-calculated schema.
     * Model $schema variables will override any automatic calculations.
     */
    public function getUserSchema()
    {
        $class = get_class($this->model);
        $schema = isset($class::$schema) ? $class::$schema : array();
        $schema = array_merge($schema, $this->userSchema);
        return $schema;
    }

    public function setUserSchema($schema)
    {
        $this->userSchema = $schema;
    }

    /**
     * Return an associative array applicable to the entire table (eg, name, display, type, index, count)
     */
    public function getTableAttributes()
    {
        $class = $this->getController();
        $attr = ( ! is_null($class) && isset($class::$schema)) ? $class::$schema : array();
        $attr = array_merge($attr, $this->userAttributes);
        return $attr;
    }

    /**
     * Set variables or overrides applicable to the entire table
     */
    public function setTableAttributes($attributes)
    {
        $this->userAttributes = $attributes;
    }

    /**
     * Return the name of the controller calling this schema
     */
    public function getController()
    {
        return $this->userAttributes['controller'] ?: Null;
    }

    /**
     * Set the name of the controller calling this schema
     */
    public function setController($controllerName)
    {
        $attributes = $this->userAttributes;
        $attributes['controller'] = $controllerName;
        $this->setTableAttributes($attributes);
    }

    public function getRules($id = Null)
    {
        $fields = $this->getFields();
        $rules = array();
        foreach( $fields as $field ) {
            if ($field['fillable']) {
                if ($id) {
                    $rules[$field['name']] = ValidationRuleGenerator::getUniqueRules($field['rules'], $id);
                } else {
                    $rules[$field['name']] = $field['rules'];
                }                
            }
        }
        return $rules;
    }

    public function getDisplayName($name)
    {
        $name = implode(array_map('ucfirst',explode('-',$name)),' ');
        $name = implode(array_map('ucfirst',explode('_',$name)),' ');
        return $name;        
    }

    public function __call($name, $args)
    {
        $fn = strtolower($name);

        if (substr($fn, 0, 8) == 'gettable'){
            $table = $this->getTable();
            return $table[substr($fn, 8)];
        } elseif (substr($fn, 0, 8) == 'getfield') {
            $fields = $this->getFields();
            return $fields[substr($fn, 8)];
        }
        return strtolower($name);
    }

}

