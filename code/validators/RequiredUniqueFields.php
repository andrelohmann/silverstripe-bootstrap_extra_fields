<?php

/**
 * Required Unique Fields allows you to set which fields need to be present before
 * submitting the form and which fields need to be unique on a special Object.
 * Submit an array of arguments for required fileds, one associative array for unique fields with FieldName => Error Message
 * and the objectClass, on which the field shall be unique.
 *
 * Validation is performed on a field by field basis through
 * {@link FormField::validate}.
 *
 * @package forms
 * @subpackage validators
 */
class RequiredUniqueFields extends RequiredFields
{

    protected $unique;
    protected $objectClass;

    /**
     * Pass required and unique fields as arrays.
         * 
         * Example:
         * new RequiredUniqueFields(
         *  $required = array(
         *      "FirstName",
         *      "Surname",
         *      "Email"
         *  ), $unique = array(
         *      "Email" => _t('Member.EMAILEXISTS', 'Member.EMAILEXISTS')
         *  ), $objectClass = 'Member'
         * )
         * 
         * @param array $required
         * @param array $unique
         * @param string $objectClass
     */
    public function __construct($required = array(), $unique = array(), $objectClass = null)
    {
        $this->unique = $unique;
                
        $this->objectClass = $objectClass;

        parent::__construct($required);
    }

    /**
     * Allows validation of fields via specification of a php function for
     * validation which is executed after the form is submitted.
     *
     * @param array $data
     *
     * @return boolean
     */
    public function php($data)
    {
        $valid = parent::php($data);
                
        $fields = $this->form->Fields();

        if ($this->unique) {
            foreach ($this->unique as $fieldName=>$Message) {
                if (!$fieldName) {
                    continue;
                }

                if ($fieldName instanceof FormField) {
                    $formField = $fieldName;
                    $fieldName = $fieldName->getName();
                } else {
                    $formField = $fields->dataFieldByName($fieldName);
                }
                       
                if ($o = DataObject::get_one($this->objectClass, $fieldName."='".Convert::raw2sql($data[$fieldName])."'")) {
                    $this->validationError(
                        $fieldName,
                        $Message
                    );
                            
                    $valid = false;
                }
            }
        }

        return $valid;
    }
}
