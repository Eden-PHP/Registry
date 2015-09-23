<?php //-->
/*
 * This file is part of the Registry package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\Registry;


/**
 * This class allows the reference of a global registry. This
 * is a better registry in memory design. What makes this
 * registry truly unique is that it uses a pathing design 
 * similar to a file/folder structure to organize data which also 
 * in turn allows you to get a data set based on similar
 * pathing. 
 *
 * @vendor Eden
 * @package registry
 * @author Christian Blanquera cblanquera@openovate.com
 */
class Index extends Base
{
	/**
	 * Construct - load data
	 *
	 * @param array
	 */
	public function __construct($data = array())
	{
		//if there is more arguments or data is not an array
		if(func_num_args() > 1 || !is_array($data)) {
			//just get the args
			$data = func_get_args();
		}
		
		foreach($data as $key => $value) {
			if(!is_array($value)) {
				continue;
			}
			
			$class = get_class($this);
			
			$data[$key] = $this->$class($value);
		}
		
		parent::__construct($data);
	}
	
	/**
	 * Converts data to JSON format
	 *
	 * @return string
	 */
	public function __toString()
	{
		return json_encode($this->getArray());
	}
	
	/**
	 * Gets a value given the path in the registry.
	 * 
	 * @return mixed
	 */
	public function get($modified = true)
	{
		$args = func_get_args();
		
		if(count($args) == 0) {
			return $this;
		}
		
		$key = array_shift($args);
		
		if($key === false) {
			if(count($args) == 0) {
				return $this->getArray();
			}
			
			$modified = $key;
			$key = array_shift($args);
			array_unshift($args, $modified);
		}
		
		if(!isset($this->data[$key])) {
			return NULL;
		}
		
		if(count($args) == 0) {
			return $this->data[$key];
		}
		
		if($this->data[$key] instanceof Base) {
			return call_user_func_array(array($this->data[$key], __FUNCTION__), $args);
		}
		
		return NULL;
	}
	
	/**
	 * Returns the raw array recursively
	 *
	 * @return array
	 */
	public function getArray($modified = true)
	{
		$array = array();
		foreach($this->data as $key => $data) {
			if($data instanceof Base) {
				$array[$key] = $data->getArray($modified);
				continue;
			}
			
			$array[$key] = $data;
		}
		
		return $array;
	}
	
	/**
	 * Checks to see if a key is set
	 *
	 * @return bool
	 */
	public function isKey()
	{
		$args = func_get_args();
		
		if(count($args) == 0) {
			return $this;
		}
		
		$key = array_shift($args);
		
		if(!isset($this->data[$key])) {
			return false;
		}
		
		if(count($args) == 0) {
			return true;
		}
		
		if($this->data[$key] instanceof Base) {
			return call_user_func_array(array($this->data[$key], __FUNCTION__), $args);
		}
		
		return false;
	}
	
	/**
	 * returns data using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
	public function offsetGet($offset)
	{
        if(!isset($this->data[$offset])) {
			return NULL;
		}
		
		if($this->data[$offset] instanceof Base) {
			return $this->data[$offset]->getArray();
		}
		
		return $this->data[$offset];
    }
	
	/**
	 * Removes a key and everything associated with it
	 * 
	 * @return Eden\Registry\Base
	 */
	public function remove()
	{
		$args = func_get_args();
		
		if(count($args) == 0) {
			return $this;
		}
		
		$key = array_shift($args);
		
		if(!isset($this->data[$key])) {
			return $this;
		}
		
		if(count($args) == 0) {
			unset($this->data[$key]);
			return $this;
		}
		
		if($this->data[$key] instanceof Base) {
			return call_user_func_array(array($this->data[$key], __FUNCTION__), $args);
		}
		
		return $this;
	}
	
	/**
	 * Creates the name space given the space
	 * and sets the value to that name space
	 *
	 * @return Registry
	 */
	public function set($value)
	{
		$args = func_get_args();
		
		if(count($args) < 2) {
			return $this;
		}
		
		$key = array_shift($args);
		
		if(count($args) == 1) {
			if(is_array($args[0])) {
				$args[0] = self::i($args[0]);
			}
			
			$this->data[$key] = $args[0];
			
			return $this;
		}
		
		if(!isset($this->data[$key]) || !($this->data[$key] instanceof Base)) {
			$this->data[$key] = self::i();
		}
		
		call_user_func_array(array($this->data[$key], __FUNCTION__), $args);
		
		return $this;
	}
}