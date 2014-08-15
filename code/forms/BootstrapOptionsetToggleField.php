<?php
/**
 * Toggle Formfields by Optionset Selection
 * 
 * <b>Usage</b>
 * 
 * <code>
 * new OptionsetField(
 *    $name = "Foobar",
 *    $title = "FooBar's optionset",
 *    $source = array(
 *       "1" => array("Title" => "Option 1", "FieldList" => new FieldList(FIELDS)),
 *       "2" => array("Title" => "Option 2", "FieldList" => new FieldList(FIELDS)),
 *    ),
 *    $value = "1"
 * );
 * </code>
 * 
 * @package forms
 * @subpackage fields-formattedinput
 */
class BootstrapOptionsetToggleField extends OptionsetField {
	
	/**
	 * Child fields
	 * 
	 * @var FieldList
	 */
	public $children;

	/**
	 * @param array $source
	 */
	public function setSource($source) {
		$this->source = $source;
                if(is_array($this->source)){
                    $this->children = new FieldList();
                    foreach($source as $value => $obj) {
                        foreach($obj['FieldList'] as $f){
                            $this->children->push($f);
                        }
                    }
                }
		return $this;
	}
	

	public function Options() {
            
                Requirements::javascript(FRAMEWORK_DIR . '/thirdparty/jquery/jquery.min.js');
		Requirements::javascript('bootstrap_extra_fields/javascript/BootstrapOptionsetToggleField.js');
		
                $source = $this->getSource();
		$odd = 0;
		$options = array();
		
		if($source) {
			foreach($source as $value => $obj) {
				$itemID = $this->ID() . '_' . preg_replace('/[^a-zA-Z0-9]/', '', $value);
				$odd = ($odd + 1) % 2;
				$extraClass = $odd ? 'odd' : 'even';
				$extraClass .= ' val' . preg_replace('/[^a-zA-Z0-9\-\_]/', '_', $value);
				
				$options[] = new ArrayData(array(
					'ID' => $itemID,
					'Class' => $extraClass,
					'Name' => $this->name,
					'Value' => $value,
					'Title' => $obj['Title'],
                                        'FieldList' => $this->AlternateFields($obj['FieldList']),
					'isChecked' => $value == $this->value,
					'isDisabled' => $this->disabled || in_array($value, $this->disabledItems),
				));
			}
		}

		return new ArrayList($options);
	}

	/**
	 * Accessor method for $this->children
	 *
	 * @return FieldList
	 */
	public function getChildren() {
		return $this->children;
	}
	
	/**
	 * @param FieldList $children
	 */
	public function setChildren($children) {
		$this->children = $children;
		return $this;
	}

	public function setForm($form) {
		foreach($this->children as $f) 
			if(is_object($f)) $f->setForm($form);
			
		parent::setForm($form);
		
		return $this;
	}

	/**
	 * Add all of the non-composite fields contained within this field to the 
	 * list.
	 *
	 * Sequentialisation is used when connecting the form to its data source
	 */
	public function collateDataFields(&$list, $saveableOnly = false) {
		foreach($this->children as $field) {
			if(is_object($field)) {
				if($field->isComposite()) $field->collateDataFields($list, $saveableOnly);
				if($saveableOnly) {
					$isIncluded =  ($field->hasData() && !$field->isReadonly() && !$field->isDisabled());
				} else {
					$isIncluded =  ($field->hasData());
				}
				if($isIncluded) {
					$name = $field->getName();
					if($name) {
						$formName = (isset($this->form)) ? $this->form->FormName() : '(unknown form)';
						if(isset($list[$name])) {
							user_error("collateDataFields() I noticed that a field called '$name' appears twice in"
								. " your form: '{$formName}'.  One is a '{$field->class}' and the other is a"
								. " '{$list[$name]->class}'", E_USER_ERROR);
						}
						$list[$name] = $field;
					}
				}
			}
		}
	}
	
	public function isComposite() {
		return true; 
	}

	public function fieldByName($name) {
		return $this->children->fieldByName($name);
	}
	
	/**
	 * Add a new child field to the end of the set.
	 * 
	 * @param FormField
	 */
	public function push(FormField $field) {
		$this->children->push($field);
	}
	
	/**
	 * @uses FieldList->insertBefore()
	 */
	public function insertBefore($field, $insertBefore) {
		$ret = $this->children->insertBefore($field, $insertBefore);
		$this->sequentialSet = null;
		return $ret;
	}

	public function insertAfter($field, $insertAfter) {
		$ret = $this->children->insertAfter($field, $insertAfter);
		$this->sequentialSet = null;
		return $ret;
	}

	/**
	 * Remove a field from this CompositeField by Name.
	 * The field could also be inside a CompositeField.
	 * 
	 * @param string $fieldName The name of the field
	 * @param boolean $dataFieldOnly If this is true, then a field will only
	 * be removed if it's a data field.  Dataless fields, such as tabs, will
	 * be left as-is.
	 */
	public function removeByName($fieldName, $dataFieldOnly = false) {
		$this->children->removeByName($fieldName, $dataFieldOnly);
	}

	public function replaceField($fieldName, $newField) {
		return $this->children->replaceField($fieldName, $newField);
	}

	public function rootFieldList() {
		if(is_object($this->containerFieldList)) return $this->containerFieldList->rootFieldList();
		else return $this->children;
	}
	
	/**
	 * Return a readonly version of this field. Keeps the composition but returns readonly
	 * versions of all the child {@link FormField} objects.
	 *
	 * @return CompositeField
	 */
	public function performReadonlyTransformation() {
                parent::performReadonlyTransformation();
                
		$newChildren = new FieldList();
		$clone = clone $this;
		if($clone->getChildren()) foreach($clone->getChildren() as $idx => $child) {
			if(is_object($child)) $child = $child->transform(new ReadonlyTransformation());
			$newChildren->push($child, $idx);
		}

		$clone->children = $newChildren;
		$clone->readonly = true;
		$clone->addExtraClass($this->extraClass());
		$clone->setDescription($this->getDescription());

		return $clone;
	}

	/**
	 * Return a disabled version of this field. Keeps the composition but returns disabled
	 * versions of all the child {@link FormField} objects.
	 *
	 * @return CompositeField
	 */
	public function performDisabledTransformation() {
                parent::performDisabledTransformation();
                
		$newChildren = new FieldList();
		$clone = clone $this;
		if($clone->getChildren()) foreach($clone->getChildren() as $idx => $child) {
			if(is_object($child)) $child = $child->transform(new DisabledTransformation());
			$newChildren->push($child, $idx);
		}

		$clone->children = $newChildren;
		$clone->readonly = true;
		$clone->addExtraClass($this->extraClass());
		$clone->setDescription($this->getDescription());
		foreach($this->attributes as $k => $v) {
			$clone->setAttribute($k, $v);
		}

		return $clone;
	}
	
	/**
	 * Find the numerical position of a field within
	 * the children collection. Doesn't work recursively.
	 * 
	 * @param string|FormField
	 * @return int Position in children collection (first position starts with 0). Returns FALSE if the field can't
	 *             be found.
	 */
	public function fieldPosition($field) {
		if(is_string($field)) $field = $this->fieldByName($field);
		if(!$field) return false;
		
		$i = 0;
		foreach($this->children as $child) {
			if($child->getName() == $field->getName()) return $i;
			$i++;
		}
		
		return false;
	}
	
	/**
	 * Transform the named field into a readonly feld.
	 * 
	 * @param string|FormField
	 */
	public function makeFieldReadonly($field) {
		$fieldName = ($field instanceof FormField) ? $field->getName() : $field;
		
		// Iterate on items, looking for the applicable field
		foreach($this->children as $i => $item) {
			if($item->isComposite()) {
				$item->makeFieldReadonly($fieldName);
			} else {
				// Once it's found, use FormField::transform to turn the field into a readonly version of itself.
				if($item->getName() == $fieldName) {
					$this->children->replaceField($fieldName, $item->transform(new ReadonlyTransformation()));

					// Clear an internal cache
					$this->sequentialSet = null;

					// A true results indicates that the field was foudn
					return true;
				}
			}
		}
		return false;
	}
	
	public function Fields() {        
                return $this->AlternateFields($this->children);
	}
        
        protected function AlternateFields(FieldList $fields){
            $Fields = new FieldList();
                
            foreach($fields as $field) {
                $field->setDisabled($this->isDisabled());
                $field->setReadonly($this->isReadonly());
		if(count($this->attributes)){
                    foreach($this->attributes as $name => $value) {
                        $field->setAttribute($name, $value);
                    }
		}
		$Fields->add($field);
            }
            return $Fields;
        }

	public function validate($validator) {
                $valid = parent::validate($validator);
		foreach($this->children as $idx => $child){
			$valid = ($child && $child->validate($validator) && $valid);
		}
		return $valid;
	}
}
