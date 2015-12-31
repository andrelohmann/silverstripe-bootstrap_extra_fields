<?php
/**
 * Two masked input fields, checks for matching passwords.
 * Optionally hides the fields by default and shows
 * a link to toggle their visibility.
 * 
 * @package forms
 * @subpackage fields-formattedinput
 */
class BootstrapToggleField extends CheckboxField
{
    
    /**
     * Child fields
     * 
     * @var FieldList
     */
    public $children;
    
    /**
     * @param string $name
     * @param string $title
     * @param mixed $value
     */
    public function __construct($name, $title = null, $value = "")
    {
        parent::__construct($name, $title, $value);
    }
        
    /**
     * Add Fields to the Toogle Field
     * 
     * $fieldlist = new FieldList(
        new PasswordField(
            "{$name}[_Password]", 
            (isset($title)) ? $title : _t('Member.PASSWORD', 'Password')
        ),
        new PasswordField(
            "{$name}[_ConfirmPassword]",
            (isset($titleConfirmField)) ? $titleConfirmField : _t('Member.CONFIRMPASSWORD', 'Confirm Password')
        )
    );
     */
    public function setFieldList(FieldList $fieldlist)
    {
        $this->children = $fieldlist;
    }

    /**
     * Returns all the sub-fields, suitable for <% loop FieldList %>
     *
     * @return FieldList
     */
    public function FieldList()
    {
        return $this->children;
    }

    /**
     * Accessor method for $this->children
     *
     * @return FieldList
     */
    public function getChildren()
    {
        return $this->children;
    }
    
    /**
     * @param FieldList $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
        return $this;
    }

    public function setForm($form)
    {
        foreach ($this->children as $f) {
            if (is_object($f)) {
                $f->setForm($form);
            }
        }
            
        parent::setForm($form);
        
        return $this;
    }

    /**
     * Add all of the non-composite fields contained within this field to the 
     * list.
     *
     * Sequentialisation is used when connecting the form to its data source
     */
    public function collateDataFields(&$list, $saveableOnly = false)
    {
        foreach ($this->children as $field) {
            if (is_object($field)) {
                if ($field->isComposite()) {
                    $field->collateDataFields($list, $saveableOnly);
                }
                if ($saveableOnly) {
                    $isIncluded =  ($field->hasData() && !$field->isReadonly() && !$field->isDisabled());
                } else {
                    $isIncluded =  ($field->hasData());
                }
                if ($isIncluded) {
                    $name = $field->getName();
                    if ($name) {
                        $formName = (isset($this->form)) ? $this->form->FormName() : '(unknown form)';
                        if (isset($list[$name])) {
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
    
    public function isComposite()
    {
        return true;
    }

    public function fieldByName($name)
    {
        return $this->children->fieldByName($name);
    }
    
    /**
     * Add a new child field to the end of the set.
     * 
     * @param FormField
     */
    public function push(FormField $field)
    {
        $this->children->push($field);
    }
    
    /**
     * @uses FieldList->insertBefore()
     */
    public function insertBefore($field, $insertBefore)
    {
        $ret = $this->children->insertBefore($field, $insertBefore);
        $this->sequentialSet = null;
        return $ret;
    }

    public function insertAfter($field, $insertAfter)
    {
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
    public function removeByName($fieldName, $dataFieldOnly = false)
    {
        $this->children->removeByName($fieldName, $dataFieldOnly);
    }

    public function replaceField($fieldName, $newField)
    {
        return $this->children->replaceField($fieldName, $newField);
    }

    public function rootFieldList()
    {
        if (is_object($this->containerFieldList)) {
            return $this->containerFieldList->rootFieldList();
        } else {
            return $this->children;
        }
    }
    
    /**
     * Return a readonly version of this field. Keeps the composition but returns readonly
     * versions of all the child {@link FormField} objects.
     *
     * @return CompositeField
     */
    public function performReadonlyTransformation()
    {
        parent::performReadonlyTransformation();
                
        $newChildren = new FieldList();
        $clone = clone $this;
        if ($clone->getChildren()) {
            foreach ($clone->getChildren() as $idx => $child) {
                if (is_object($child)) {
                    $child = $child->transform(new ReadonlyTransformation());
                }
                $newChildren->push($child, $idx);
            }
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
    public function performDisabledTransformation()
    {
        parent::performDisabledTransformation();
                
        $newChildren = new FieldList();
        $clone = clone $this;
        if ($clone->getChildren()) {
            foreach ($clone->getChildren() as $idx => $child) {
                if (is_object($child)) {
                    $child = $child->transform(new DisabledTransformation());
                }
                $newChildren->push($child, $idx);
            }
        }

        $clone->children = $newChildren;
        $clone->readonly = true;
        $clone->addExtraClass($this->extraClass());
        $clone->setDescription($this->getDescription());
        foreach ($this->attributes as $k => $v) {
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
    public function fieldPosition($field)
    {
        if (is_string($field)) {
            $field = $this->fieldByName($field);
        }
        if (!$field) {
            return false;
        }
        
        $i = 0;
        foreach ($this->children as $child) {
            if ($child->getName() == $field->getName()) {
                return $i;
            }
            $i++;
        }
        
        return false;
    }
    
    /**
     * Transform the named field into a readonly feld.
     * 
     * @param string|FormField
     */
    public function makeFieldReadonly($field)
    {
        $fieldName = ($field instanceof FormField) ? $field->getName() : $field;
        
        // Iterate on items, looking for the applicable field
        foreach ($this->children as $i => $item) {
            if ($item->isComposite()) {
                $item->makeFieldReadonly($fieldName);
            } else {
                // Once it's found, use FormField::transform to turn the field into a readonly version of itself.
                if ($item->getName() == $fieldName) {
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
    
    public function Fields()
    {
        Requirements::javascript(FRAMEWORK_DIR . '/thirdparty/jquery/jquery.min.js');
        Requirements::javascript('bootstrap_extra_fields/javascript/BootstrapToggleField.js');
        //Requirements::css(FRAMEWORK_DIR . '/css/ConfirmedPasswordField.css');

        $Fields = new FieldList();
                
        foreach ($this->children as $field) {
            $field->setDisabled($this->isDisabled());
            $field->setReadonly($this->isReadonly());
            if (count($this->attributes)) {
                foreach ($this->attributes as $name => $value) {
                    $field->setAttribute($name, $value);
                }
            }
            $Fields->add($field);
        }
        
        return $Fields;
    }

    public function validate($validator)
    {
        $valid = parent::validate($validator);
        foreach ($this->children as $idx => $child) {
            $valid = ($child && $child->validate($validator) && $valid);
        }
        return $valid;
    }
}
