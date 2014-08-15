<?php
/**
 * Two masked input fields, checks for matching passwords.
 * Optionally hides the fields by default and shows
 * a link to toggle their visibility.
 * 
 * @package forms
 * @subpackage fields-formattedinput
 */
class BootstrapConfirmedPasswordField extends ConfirmedPasswordField {
	
	/**
	 * @param string $name
	 * @param string $title
	 * @param mixed $value
	 * @param Form $form
	 * @param boolean $showOnClick
	 * @param string $titleConfirmField Alternate title (not localizeable)
	 */
	public function __construct($name, $title = null, $value = "", $form = null, $showOnClick = false, $titleConfirmField = null) {
		
		parent::__construct($name, $title, $value, $form, $showOnClick, $titleConfirmField);
		$this->setValue($value);
                $this->setTitle($title);
	}
	
	public function Field($properties = array()) {
        
                Requirements::javascript(FRAMEWORK_DIR . '/thirdparty/jquery/jquery.min.js');
		Requirements::javascript('bootstrap_extra_fields/javascript/BootstrapConfirmedPasswordField.js');
		Requirements::css(FRAMEWORK_DIR . '/css/ConfirmedPasswordField.css');
		
		$content = '';
		
		if($this->showOnClick) {
			if($this->showOnClickTitle) {
				$title = $this->showOnClickTitle;
			} else {
				$title = _t(
					'ConfirmedPasswordField.SHOWONCLICKTITLE', 
					'Change Password', 
					
					'Label of the link which triggers display of the "change password" formfields'
				);
			}
			
			$content .= "<div class=\"showOnClick\">\n";
			$content .= "<a href=\"#\">{$title}</a>\n";
			$content .= "<div class=\"showOnClickContainer\" style=\"display:none;\">";
		}

		foreach($this->children as $field) {
			$field->setDisabled($this->isDisabled()); 
			$field->setReadonly($this->isReadonly());
			if(count($this->attributes)) {
				foreach($this->attributes as $name => $value) {
					$field->setAttribute($name, $value);
				}
			}
			$content .= $field->FieldHolder();
		}

		if($this->showOnClick) {
			$content .= "</div>\n";
			$content .= "</div>\n";
		}
		
		return $content;
	}
	
	public function Fields() {
        
                Requirements::javascript(FRAMEWORK_DIR . '/thirdparty/jquery/jquery.min.js');
		Requirements::javascript('bootstrap_extra_fields/javascript/BootstrapConfirmedPasswordField.js');
		Requirements::css(FRAMEWORK_DIR . '/css/ConfirmedPasswordField.css');
		
		$Fields = new FieldList();
                
                foreach($this->children as $field) {
			$field->setDisabled($this->isDisabled()); 
			$field->setReadonly($this->isReadonly());
			if(count($this->attributes)) {
				foreach($this->attributes as $name => $value) {
					$field->setAttribute($name, $value);
				}
			}
			$Fields->add($field);
		}
		
		return $Fields;
	}
        
        public function getShowTitle(){
            if($this->showOnClickTitle){
                $title = $this->showOnClickTitle;
            }else{
                $title = _t(
                        'ConfirmedPasswordField.SHOWONCLICKTITLE', 
			'Change Password', 
			'Label of the link which triggers display of the "change password" formfields'
		);
            }
            
            return $title;
        }
	
	public function setShowOnClick($show) {
		$this->showOnClick = (bool)$show;

		return $this;
	}
        
	public function getShowOnClick(){
            return $this->showOnClick;
	}
}
