<?php
/**
 * extends the Decimal Field
 *
 * @package framework
 * @subpackage model
 */
class ExtendedDatetime extends DataExtension
{
    
    protected $locale_formats = array(
        'en_US' => 'm/d/Y g:i A', //
        'de_DE' => 'd.m.Y H:i \U\h\r',
        'en_GB' => 'd/m/Y H:i'
    );
        
    protected function getFormat()
    {
        if (array_key_exists(i18n::get_locale(), $this->locale_formats)) {
            $locale = i18n::get_locale();
        } else {
            $locale = 'en_US';
        }
        
        return $this->locale_formats[$locale];
    }
    
    /**
     * returns the value formatet in the current locales format
     * 
     * @return string
     */
    public function NiceLocale()
    {
        if ($this->owner->value) {
            return date($this->getFormat(), strtotime($this->owner->value));
        }
    }
}
