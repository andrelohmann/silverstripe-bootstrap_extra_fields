<?php

/**
 * BootstrapDropdownDateField
 * Form field to display an editable date string
 * in three separate dropdown fields for day, month and year.
 * 
 * # Configuration
 * 
 * - 'range': set the range of the Year Drowpdown
 * - 'dateformat' (string): Date format compatible with Zend_Date.
 *    Usually set to default format for {@link locale} through {@link Zend_Locale_Format::getDateFormat()}.
 * - 'datavalueformat' (string): Internal ISO format string used by {@link dataValue()} to save the
 *    date to a database.
 * - 'min' (string): Minimum allowed date value (in ISO format, or strtotime() compatible).
 *    Example: '2010-03-31', or '-7 days'
 * - 'max' (string): Maximum allowed date value (in ISO format, or strtotime() compatible).
 *    Example: '2010-03-31', or '1 year'
 * 
 * # Localization
 * 
 * The field will get its default locale from {@link i18n::get_locale()}, and set the `dateformat`
 * configuration accordingly. Changing the locale through {@link setLocale()} will not update the 
 * `dateformat` configuration automatically.
 * 
 * See http://doc.silverstripe.org/framework/en/topics/i18n for more information about localizing form fields.
 * 
 * # Usage
 * 
 * ## Example: German dates with separate fields for day, month, year
 * 
 *   $f = new DropdownDateField('MyDate');
 *   $f->setLocale('de_DE');
 * 
 * # Validation
 * 
 * Caution: JavaScript validation is only supported for the 'en_NZ' locale at the moment,
 * it will be disabled automatically for all other locales.
 * 
 * @package forms
 * @subpackage fields-datetime
 */
class BootstrapDropdownDateField extends DropdownDateField {

	public function Field($properties = array()) {
            
        $this->setConfig('dmyseparator', '</div><div class="col-sm-4">');
        return '<div class="row"><div class="col-sm-4">'.parent::Field($properties).'</div></div>';
	}
}
