<?php //-->
/**
 * This file is part of the Eden PHP Library.
 * (c) 2014-2016 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

namespace Eden\Registry;

/**
 * Registry class implementation
 *
 * @vendor   Eden
 * @package  Registry
 * @author   Christian Blanquera <cblanquera@openovate.com>
 * @standard PSR-2
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
        if (func_num_args() > 1 || !is_array($data)) {
            //just get the args
            $data = func_get_args();
        }
        
        foreach ($data as $key => $value) {
            if (!is_array($value)) {
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
     * @param scalar[, scalar..] $modified The registry path; yea i know this is wierd
     *
     * @return mixed
     */
    public function get($modified = true)
    {
        //get args
        $args = func_get_args();
        
        //if no args
        if (count($args) == 0) {
            //just return the array
            return $this->getArray();
        }
        
        //shift out the key
        $key = array_shift($args);
        
        //if there is no key in our data
        if (!isset($this->data[$key])) {
            //return null
            return null;
        }
        
        //if our args are now empty
        if (count($args) == 0) {
            //if data key is a registry
            if ($this->data[$key] instanceof Base) {
                //just return the array
                return $this->data[$key]->getArray();
            }
            
            //return the data key
            return $this->data[$key];
        }
        
        //there are still arguments
        if ($this->data[$key] instanceof Base) {
            //traverse
            return call_user_func_array(array($this->data[$key], __FUNCTION__), $args);
        }
        
        return null;
    }
    
    /**
     * Returns the raw array recursively
     *
     * @param bool $modified whether to return the original data
     *
     * @return array
     */
    public function getArray($modified = true)
    {
        $array = array();
        foreach ($this->data as $key => $data) {
            if ($data instanceof Base) {
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
        
        if (count($args) == 0) {
            return $this;
        }
        
        $key = array_shift($args);
        
        if (!isset($this->data[$key])) {
            return false;
        }
        
        if (count($args) == 0) {
            return true;
        }
        
        if ($this->data[$key] instanceof Base) {
            return call_user_func_array(array($this->data[$key], __FUNCTION__), $args);
        }
        
        return false;
    }
    
    /**
     * returns data using the ArrayAccess interface
     *
     * @param *scalar|null|bool $offset The key to get
     *
     * @return bool
     */
    public function offsetGet($offset)
    {
        if (!isset($this->data[$offset])) {
            return null;
        }
        
        if ($this->data[$offset] instanceof Base) {
            return $this->data[$offset]->getArray();
        }
        
        return $this->data[$offset];
    }
    
    /**
     * Removes a key and everything associated with it
     *
     * @return Eden\Registry\Index
     */
    public function remove()
    {
        $args = func_get_args();
        
        if (count($args) == 0) {
            return $this;
        }
        
        $key = array_shift($args);
        
        if (!isset($this->data[$key])) {
            return $this;
        }
        
        if (count($args) == 0) {
            unset($this->data[$key]);
            return $this;
        }
        
        if ($this->data[$key] instanceof Base) {
            return call_user_func_array(array($this->data[$key], __FUNCTION__), $args);
        }
        
        return $this;
    }
    
    /**
     * Creates the name space given the space
     * and sets the value to that name space
     *
     * @param scalar[, scalar..],*mixed $value The registry path; yea i know this is wierd
     *
     * @return Eden\Registry\Index
     */
    public function set($value = null)
    {
        $args = func_get_args();
        
        if (count($args) < 2) {
            return $this;
        }
        
        $key = array_shift($args);
        
        if (count($args) == 1) {
            if (is_array($args[0])) {
                $args[0] = self::i($args[0]);
            }
            
            $this->data[$key] = $args[0];
            
            return $this;
        }
        
        if (!isset($this->data[$key]) || !($this->data[$key] instanceof Base)) {
            $this->data[$key] = self::i();
        }
        
        call_user_func_array(array($this->data[$key], __FUNCTION__), $args);
        
        return $this;
    }
}
