<?php //-->
/**
 * This file is part of the Eden PHP Library.
 * (c) 2014-2016 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
 
class EdenRegistryIndexTest extends PHPUnit_Framework_TestCase
{
    public function testSet() 
    {
		$registry = eden('registry') //instantiate
			->set('path', 'to', 'value1', 123)   //set path 'path','to', 'value' to 123
			->set('path', 'to', 'value2', 456);  //set path 'path','to', 'value' to 456
		
		$this->assertInstanceOf('Eden\\Registry\\Base', $registry);
		
		//overriding
		$results = $registry
			->set('path', 'to', 'value1', 'value2', 123)
			->getArray();
		
		$this->assertEquals(123, $results['path']['to']['value1']['value2']);
		
		//overriding
		$results = $registry
			->set('path', 123)
			->getArray();
		
		$this->assertEquals(123, $results['path']);
	}
	
	public function testGet() 
    {
		$registry = eden('registry') //instantiate
			->set('path', 'to', 'value1', 123)   //set path 'path','to', 'value' to 123
			->set('path', 'to', 'value2', 456);  //set path 'path','to', 'value' to 456
		
		$value1 = $registry->get('path', 'to', 'value1'); //--> 123
		$value2 = $registry->get('path', 'to', 'value2'); //--> 456
		$value3 = $registry->get('path', 'to');   //--> {value1:123,value2:456}
		
		$this->assertEquals(123, $value1);
		
		$this->assertEquals(456, $value2);
		
		$this->assertTrue(is_array($value3));
		
		$registry['name'] = 'value';
		
		$this->assertEquals('value', $registry['name']);
		
		$this->assertEquals(123, $registry['path']['to']['value1']);
		$this->assertTrue(!isset($registry['path']['to']['value3']));
		$this->assertNull($registry->get('path', 'to', 'value3', 'and', 'beyond'));
		$this->assertEquals(123, $registry->path['to']['value1']);
	}
	
	public function testRemove()
	{
		$registry = eden('registry') //instantiate
			->set('path', 'to', 'value1', 123)   //set path 'path','to', 'value' to 123
			->set('path', 'to', 'value2', 456);  //set path 'path','to', 'value' to 456
		
		$registry->remove('path', 'to', 'value1');
		
		$this->assertTrue(!isset($registry['path']['to']['value1']));
		$this->assertNull($registry->get('path', 'to', 'value1'));
		
		$this->assertEquals('{"path":{"to":{"value2":456}}}', (string) $registry);
	}
	
	public function testIsKey()
	{
		$registry = eden('registry') //instantiate
			->set('path', 'to', 'value1', 123)   //set path 'path','to', 'value' to 123
			->set('path', 'to', 'value2', 456);  //set path 'path','to', 'value' to 456
		
		$this->assertTrue($registry->isKey('path', 'to', 'value1'));
		$this->assertTrue($registry->isKey('path', 'to', 'value2'));
		$this->assertTrue($registry->isKey('path', 'to'));
		$this->assertFalse($registry->isKey('path', 'to', 'value3'));
	}
	
	public function testIsDot()
	{
		$registry = eden('registry') //instantiate
			->set('path', 'to', 'value1', 123)   //set path 'path','to', 'value' to 123
			->set('path', 'to', 'value2', 456);  //set path 'path','to', 'value' to 456
		
		$this->assertTrue($registry->isDot('path.to.value1'));
		$this->assertTrue($registry->isDot('path-to-value2', '-'));
		$this->assertTrue($registry->isDot('path.to'));
		$this->assertFalse($registry->isDot('path.to.value3'));
		$this->assertFalse($registry->isDot('path-to-value3'));
	}
	
	public function testDot()
	{
		$registry = eden('registry')
			->setDot('path.to.value1', 123)
			->setDot('path-to-value2', 456, '-')
			->setDot('path-to-value3', 789);
			
		$results = $registry->getDot('path.to');
		
		$this->assertEquals(123, $results['value1']);
		$this->assertEquals(456, $results['value2']);
		$this->assertTrue(!isset($results['value3']));
	}
}