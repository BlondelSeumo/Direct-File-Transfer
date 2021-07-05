<?php 

/*==========================================================================
 * Copyright (c) 2020
 * =========================================================================
 * 
 *
 * Project: Upload & Share
 * Author: Berkine 
 * Version: 1.0.0
 * 
 * 
 * =========================================================================
 */

class Validate {

	private $_passed = false;
	private	$_errors = array();
	private	$_db = null;


	public function __construct() {
		$this->_db = DB::getInstance();
	}


	/**
	*
	* Check validation passed
	* @param source(POST or GET), requirements
	* @return bool value
	*
	*/
	public function check($source, $items = array()) {
		foreach($items as $item => $rules) {
			foreach ($rules as $rule => $rule_value) {
				
				$value = trim($source[$item]);
				$item = escape($item);

				if ($rule === 'required' && empty($value)) {
					$this->addError("{$item} is required");
				} else if (!empty($value)) {
					switch ($rule) {
						case 'min':
								if (strlen($value) < $rule_value) {
									$this->addError("{$item} must be a minimum of {$rule_value}");
								}
							break;
						case 'max':
								if (strlen($value) > $rule_value) {
									$this->addError("{$item} must be a maximum of {$rule_value}");
								}
							break;
						case 'matches':
								if ($value != $source[$rule_value]) {
									$this->addError("{$rule_value} must match {$item}");
								}
							break;
						case 'unique':
								$check = $this->_db->get($rule_value, array($item, '=', $value));
								if ($check->count()) {
									$this->addError("{$item} already exists");
								}
							break;
					}
				}
			}
		}

		if (empty($this->_errors)) {
			$this->_passed = true;
		}

		return $this;
	}


	/**
	*
	* Add error to errors array
	* @param error
	*
	*/
	private function addError($error) {
		$this->_errors[] = $error;
	}


	/**
	*
	* Check if there were errors
	* @return errors list
	*
	*/
	public function errors() {
		return $this->_errors;
	}


	/**
	*
	* Check if validation passed
	* @return bool value
	*
	*/
	public function passed() {
		return $this->_passed;
	}
}