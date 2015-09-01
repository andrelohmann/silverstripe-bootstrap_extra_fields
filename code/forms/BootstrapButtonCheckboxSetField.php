<?php

/**
 * BootstrapButtonCheckboxSetField
 * 
 * http://getbootstrap.com/javascript/#buttons-checkbox-radio
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
class BootstrapButtonCheckboxSetField extends CheckboxSetField {
	
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

	/**
	 * @todo Explain different source data that can be used with this field,
	 * e.g. SQLMap, ArrayList or an array.
	 */
	public function Field($properties = array()) {

		$properties = array_merge($properties, array(
			'Options' => $this->getOptions()
		));

		return $this->customise($properties)->renderWith(
			$this->getTemplates()
		);
	}

	/**
	 * @return ArrayList
	 */
	public function getOptions() {

		$source = $this->source;
		$values = $this->value;
		$items = array();

		// Get values from the join, if available
		if(is_object($this->form)) {
			$record = $this->form->getRecord();
			if(!$values && $record && $record->hasMethod($this->name)) {
				$funcName = $this->name;
				$join = $record->$funcName();
				if($join) {
					foreach($join as $joinItem) {
						$values[] = $joinItem->ID;
					}
				}
			}
		}
		
		// Source is not an array
		if(!is_array($source) && !is_a($source, 'SQLMap')) {
			if(is_array($values)) {
				$items = $values;
			} else {
				// Source and values are DataObject sets.
				if($values && is_a($values, 'SS_List')) {
					foreach($values as $object) {
						if(is_a($object, 'DataObject')) {
							$items[] = $object->ID;
						}
					}
				} elseif($values && is_string($values)) {
					$items = explode(',', $values);
					$items = str_replace('{comma}', ',', $items);
				}
			}
		} else {
			// Sometimes we pass a singluar default value thats ! an array && !SS_List
			if($values instanceof SS_List || is_array($values)) {
				$items = $values;
			} else {
				if($values === null) {
					$items = array();
				}
				else {
					$items = explode(',', $values);
					$items = str_replace('{comma}', ',', $items);
				}
			}
		}

		if(is_array($source)) {
			unset($source['']);
		}
		
		$options = array();
		
		if ($source == null) {
			$source = array();
		}

		foreach($source as $value => $item) {
			if($item instanceof DataObject) {
				$value = $item->ID;
				$title = $item->Title;
			} else {
				$title = $item;
			}

			$itemID = $this->ID() . '_' . preg_replace('/[^a-zA-Z0-9]/', '', $value);
				
			$class = false;
			if(array_key_exists($value, $this->optionClasses)){
                $class = $this->optionClasses[$value];
            }

			$options[] = new ArrayData(array(
				'ID' => $itemID,
				'ButtonClass' => $this->buttonClass,
				'ExtraClass' => $class,
				'Name' => "{$this->name}[{$value}]",
				'Value' => $value,
				'Title' => $title,
				'isChecked' => in_array($value, $items) || in_array($value, $this->defaultItems),
				'isDisabled' => $this->disabled || in_array($value, $this->disabledItems)
			));
		}

		$options = new ArrayList($options);

		$this->extend('updateGetOptions', $options);

		return $options;
	}
}
