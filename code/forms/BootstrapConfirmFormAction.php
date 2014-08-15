<?php
/**
 * Two masked input fields, checks for matching passwords.
 * Optionally hides the fields by default and shows
 * a link to toggle their visibility.
 * 
 * @package forms
 * @subpackage fields-formattedinput
 */
class BootstrapConfirmFormAction extends FormAction {
    
    protected $confirmMessage;
    
    public function setConfirmMessage($message){        
        $this->confirmMessage = $message;
        $this->setAttribute('onclick', "javascript:return confirm('".$this->confirmMessage."');");
        return $this;
    }
}
