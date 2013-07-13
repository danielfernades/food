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

    public function testCreateDB()
    {
        $this->assertEquals('test', DB::connection()->getName());
        $this->testTableCreator->up();
        $this->assertTrue(Schema::hasTable('foo'));
    }

    public function testGetFields()
    {
        $schema = new ApiTableSchema(new TestFoo);
        $fields = $schema->getFields();
        $this->assertArrayHasKey('code', $fields);
        $this->assertEquals('id', $fields['id']['name']);
        $this->assertFalse($fields['id']['fillable']);
        $this->assertEquals('Text1', $fields['text1']['display']);
        $this->assertTrue($fields['text1']['fillable']);
        $this->assertContains('required', $fields['code']['rules']);
        $this->assertEquals('Object Identifier', $fields['oid']['display']);
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

