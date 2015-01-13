<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class BootstrapFormFieldExtension extends Extension {
    
    public function setPlaceholder($value){
        return $this->owner->setAttribute('placeholder', $value);
    }
    
    public function IsHorizontal(){
        return $this->owner->form->IsHorizontal();
    }
}

