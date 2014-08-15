<?php
/**
 * Lets crete you a column group on a field (needs to be child of BootstrapFieldRow)
 * 
 * Note: the child fields within a field group aren't rendered using FieldHolder().  Instead,
 * SmallFieldHolder() is called, which just prefixes $Field with a <label> tag, if the Title is set.
 * 
 * <b>Usage</b>
 * 
 * <code>
 * new BootstrapFieldRow('Row Title',
 * 	new BootstrapFieldColumn(6, 'First Column Title',
 * 		new HeaderField('FieldGroup 1'),
 * 		new TextField('Firstname')
 * 	),
 * 	new BootstrapFieldColumn(6, 'Second Column Title',
 * 		new HeaderField('FieldGroup 2'),
 * 		new TextField('Surname')
 * 	)
 * )
 * </code>
 * 
 * @package bootstrap_extra_fields
 */
class BootstrapFieldColumn extends FieldGroup {
    
        protected $column_width;
	
	public function __construct($arg1 = null, $arg2 = null, $arg3 = null) {
                if(!is_numeric($arg1) || $arg1 < 1 || 12 < $arg1) throw new Exception(sprintf('Invalid Column with on BootstrapFieldColumn: %s', $arg1));
                else $this->column_width = (int)$arg1;
                    
		if(is_array($arg2) || is_a($arg2, 'FieldSet')) {
			$fields = $arg2;
		
		} else if(is_array($arg3) || is_a($arg3, 'FieldList')) {
			$this->title = $arg2;
			$fields = $arg3;
		
		} else {
			$fields = func_get_args();
                        reset($fields);
                        $this->column_width = (int)array_shift($fields);
			if(!is_object(reset($fields))) $this->title = array_shift($fields);
		}
			
		parent::__construct($fields);
	}
        
        public function setColumnWidth($width){
            $this->column_width = (int)$width;
        }
        
        public function getColumnWidth(){
            return $this->column_width;
        }
    
}