<?php

/**
 * BootstrapButtonOptionsetField
 * 
 * Look up OptionsetField, to see how it works.
 * 
 * This FormField additionally offers the funtionality to replace a radio field set with a Bootstrap like Buttons Field http://getbootstrap.com/javascript/#buttons-checkbox-radio
 * 
 * <b>Setting indiviual button class for individual items</b>
 * 
 * Individual items can set individual button classes by feeding their array keys and the class to setOptionClasses.
 * 
 * <code>
 * $BSBtnField->setOptionClasses( array( 'NZ' => 'btn-primary', 'US' => 'btn-success', 'GEM' => 'btn-danger' ) );
 * </code>
 * 
 * @package bootstrap_extra_fields
 * @subpackage forms
 */
class BootstrapButtonOptionsetField extends OptionsetField {
	
	/**
	 * @var array $optionClasses The keys for items that should get an extra class in the dropdown
	 */
	protected $optionClasses = array();
        
    /**
     * @var string $buttonClass class for the buttons (default/info/primary/success/warning/danger)
     */
    protected $buttonClass = 'default';
	
	/**
	 * Set the specific classes for single items
	 * 
	 * @param array $classes Collection of array keys, as defined in the $source array
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
	
	/**
	 * set the general button class for the Buttons Optionset field
	 * 
	 * @param string $class set the button class (default/info/primary/success/warning/danger)
	 */
	public function setButtonClass($class = 'default'){
		switch($class){
            case 'info':
                $this->buttonClass = 'info';
            break;
            case 'primary':
                $this->buttonClass = 'primary';
            break;
            case 'success':
                $this->buttonClass = 'success';
            break;
            case 'warning':
                $this->buttonClass = 'warning';
            break;
            case 'danger':
                $this->buttonClass = 'danger';
            break;
            default:
                $this->buttonClass = 'default';
            break;
        }
		return $this;
	}
	
	/**
	 * @return Array
	 */
	public function getButtonClass(){
		return $this->buttonClass;
	}

	public function Field($properties = array()) {
		$source = $this->getSource();
		$options = array();
		
		if($source) {
			foreach($source as $value => $title) {
				$itemID = $this->ID() . '_' . preg_replace('/[^a-zA-Z0-9]/', '', $value);
				
				$class = false;
				if(array_key_exists($value, $this->optionClasses)){
					$class = $this->optionClasses[$value];
				}
				
				$options[] = new ArrayData(array(
					'ID' => $itemID,
					'ButtonClass' => $this->buttonClass,
					'ExtraClass' => $class,
					'Name' => $this->name,
					'Value' => $value,
					'Title' => $title,
					'isChecked' => $value == $this->value,
					'isDisabled' => $this->disabled || in_array($value, $this->disabledItems),
				));
			}
		}

		$properties = array_merge($properties, array(
			'Options' => new ArrayList($options)
		));

		return $this->customise($properties)->renderWith(
			$this->getTemplates()
		);
	}
}
