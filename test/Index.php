<?php //-->
/*
 * This file is part of the Model package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
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
	}
}