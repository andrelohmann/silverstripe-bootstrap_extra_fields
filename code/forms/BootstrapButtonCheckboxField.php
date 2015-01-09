<?php

/**
 * BootstrapStyledDropdownField
 * 
 * Look up DropdownField, to see how it works.
 * 
 * This FormField additionally offers the funtionality to setup a class for each Option Tag (to set e.g. Background Color).
 * 
 * <b>Setting indiviual class for individual items</b>
 * 
 * Individual items can set individual classes by feeding their array keys and the class to setOptionClasses.
 * 
 * <code>
 * $DrDownField->setOptionClasses( array( NZ' => 'green', 'US' => 'yellow', 'GEM' => 'red' ) );
 * </code>
 * 
 * @package bootstrap_extra_fields
 * @subpackage forms
 */
class BootstrapButtonCheckboxField extends CheckboxField {
    
    

	/**
	 * Creates a new field.
	 *
	 * @param string $name The internal field name, passed to forms.
	 * @param string $title The human-readable field label.
	 * @param mixed $value The value of the field.
	 */
	public function __construct($name, $title = null, $value = null) {
            parent::__construct($name, $title, $value);
            
            $this->setFieldHolderTemplate('FormField_holder');
	}
}
