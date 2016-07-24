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
        
        if (count($args) == 0) {
            return null;
        }
        
        $last = array_pop($args);
        $pointer = &$this->data;
        foreach ($args as $step) {
            if (!isset($pointer[$step])) {
                return null;
            }

            $pointer = &$pointer[$step];
        }
        
        if (!isset($pointer[$last])) {
            return null;
        }
        
        return $pointer[$last];
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
        return $this->data;
    }
    
    /**
     * Gets a value given the path in the registry.
     *
     * @param *string $notation  Name space string notation
     * @param string  $separator If you want to specify a different separator other than dot
     *
     * @return mixed
     */
    public function getDot($notation, $separator = '.')
    {
        Argument::i()
            //argument 1 must be a string
            ->test(1, 'string')
            //argument 2 must be a string
            ->test(2, 'string');

        $args = explode($separator, $notation);
        
        return call_user_func_array(array($this, 'get'), $args);
    }
    
    /**
     * Checks to see if a key is set
     *
     * @param *string $notation  Name space string notation
     * @param string  $separator If you want to specify a different separator other than dot
     *
     * @return mixed
     */
    public function isDot($notation, $separator = '.')
    {
        Argument::i()
            //argument 1 must be a string
            ->test(1, 'string')
            //argument 2 must be a string
            ->test(2, 'string');

        $args = explode($separator, $notation);
        
        return call_user_func_array(array($this, 'isKey'), $args);
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
        
        $last = array_pop($args);
        
        $pointer = &$this->data;
        foreach ($args as $i => $step) {
            if (!isset($pointer[$step])
                || !is_array($pointer[$step])
            ) {
                return false;
            }

            $pointer = &$pointer[$step];
        }
        
        if (!isset($pointer[$last])) {
            return false;
        }
        
        return true;
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
        
        $last = array_pop($args);
        
        $pointer = &$this->data;
        foreach ($args as $i => $step) {
            if (!isset($pointer[$step])
                || !is_array($pointer[$step])
            ) {
                return $this;
            }

            $pointer = &$pointer[$step];
        }
        
        unset($pointer[$last]);
        
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
        //get args
        $args = func_get_args();
        
        if (count($args) < 2) {
            return $this;
        }
        
        $value = array_pop($args);
        $last = array_pop($args);
        
        $pointer = &$this->data;
        foreach ($args as $i => $step) {
            if (!isset($pointer[$step])
                || !is_array($pointer[$step])
            ) {
                $pointer[$step] = array();
            }

            $pointer = &$pointer[$step];
        }
        
        $pointer[$last] = $value;
        
        return $this;
    }
    
    /**
     * Creates the name space given the space
     * and sets the value to that name space
     *
     * @param *string $notation  Name space string notation
     * @param *mixed  $value     Value to set on this namespace
     * @param string  $separator If you want to specify a different separator other than dot
     *
     * @return mixed
     */
    public function setDot($notation, $value, $separator = '.')
    {
        Argument::i()
            //argument 1 must be a string
            ->test(1, 'string')
            //argument 3 must be a string
            ->test(3, 'string');

        $args = explode($separator, $notation);
        
        $args[] = $value;
        
        return call_user_func_array(array($this, 'set'), $args);
    }
}
