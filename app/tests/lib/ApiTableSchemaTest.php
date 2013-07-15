<?php

class ApiTableSchemaTest extends TestCase
{
    private $defaultConnection;
    private $testTableCreator;

    public function setUp()
    {
        $this->defaultConnection = DB::connection()->getName();
        DB::setDefaultConnection('test');
        $this->testTableCreator = new CreateTestTable;
    }   

    public function tearDown()
    {
        DB::setDefaultConnection($this->defaultConnection);
    }

    public function getFieldData()
    {
        return array(
            array('id', 'name', 'id'),
            array('id', 'fillable', False),
            array('text1', 'display', 'Text1'),
            array('text1', 'fillable', True),
            array('oid', 'display', 'Object Identifier'),
        );
    }

    public function testCreateDB()
    {
        $this->assertEquals('test', DB::connection()->getName());
        $this->testTableCreator->up();
        $this->assertTrue(Schema::hasTable('foo'));
    }

    public function testGetFieldsReturnsFieldNames()
    {
        $schema = new ApiTableSchema(new TestFoo);
        $fields = $schema->getFields();
        $this->assertArrayHasKey('code', $fields);
    }

    /**
     * @dataProvider getFieldData
     */
    public function testGetFieldData($field, $attr, $expected)
    {
        $schema = new ApiTableSchema(new TestFoo);
        $fields = $schema->getFields();
        $this->assertEquals($expected, $fields[$field][$attr]);
    }

    public function testRequiredFields()
    {
        $schema = new ApiTableSchema(new TestFoo);
        $fields = $schema->getFields();
        $this->assertContains('required', $fields['code']['rules']);        
    }

    public function testGetIndexFields()
    {
        $schema = new ApiTableSchema(new TestFoo);
        $this->assertContains('code', $schema->getIndexFields());
    }

    public function testOverrideIndexFields()
    {
        // TODO: test index field overrides
        // $schema = new ApiTableSchema(new TestFoo);
        // var_dump($schema->getIndexFields());
    }

}

