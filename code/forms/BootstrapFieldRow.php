<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BootstrapFieldRow extends FieldGroup {
       
	public function __construct($arg1 = null, $arg2 = null) {
        if(is_array($arg1) || is_a($arg1, 'FieldSet')) {
			$fields = $arg1;
		
		} else if(is_array($arg2) || is_a($arg2, 'FieldList')) {
			$this->title = $arg1;
			$fields = $arg2;
		
		} else {
			$fields = func_get_args();
			if(!is_object(reset($fields))) $this->title = array_shift($fields);
		}
			
		parent::__construct($fields);
	}
    
}