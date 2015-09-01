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
class BootstrapStyledDropdownField extends DropdownField {
	
	/**
	 * @var array $optionClasses The keys for items that should an extra class in the dropdown
	 */
	protected $optionClasses = array();
	
	/**
	 * Mark certain elements as disabled,
	 * regardless of the {@link setDisabled()} settings.
	 * 
	 * @param array $items Collection of array keys, as defined in the $source array
	 */
	public function setOptionClasses($classes = array()){
		$this->optionClasses = $classes;
		return $this;
	}
	
	/**
	 * @return Array
	 */
	public function getOptionClasses(){
		return $this->optionClasses;
	}
	
	public function Field($properties = array()) {
		$source = $this->getSource();
		$options = array();
		if($source) {
			// SQLMap needs this to add an empty value to the options
			if(is_object($source) && $this->emptyString) {
				$options[] = new ArrayData(array(
					'Value' => '',
					'Title' => $this->emptyString,
				));
			}

			foreach($source as $value => $title) {
				$selected = false;
				if($value === '' && ($this->value === '' || $this->value === null)) {
					$selected = true;
				} else {
					// check against value, fallback to a type check comparison when !value
					if($value) {
						$selected = ($value == $this->value);
					} else {
						$selected = ($value === $this->value) || (((string) $value) === ((string) $this->value));
					}

					$this->isSelected = $selected;
				}
				
				$disabled = false;
				if(in_array($value, $this->disabledItems) && $title != $this->emptyString ){
					$disabled = 'disabled';
				}
				
				$class = false;
				if(array_key_exists($value, $this->optionClasses)){
					$class = $this->optionClasses[$value];
				}

				$options[] = new ArrayData(array(
					'Title' => $title,
					'Value' => $value,
					'Selected' => $selected,
					'Disabled' => $disabled,
                                        'Class' => $class
				));
			}
		}

		$properties = array_merge($properties, array('Options' => new ArrayList($options)));
                
        $obj = ($properties) ? $this->customise($properties) : $this;
		$this->extend('onBeforeRender', $this);
		return $obj->renderWith($this->getTemplates());
	}
}
