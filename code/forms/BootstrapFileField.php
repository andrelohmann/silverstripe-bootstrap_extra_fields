<?php
/**
 * Bootstrap File Field
 * 
 * shows a nice Bootstrap Style Upload Form Button and a Progess Bar
 * 
 * @package forms
 * @subpackage fields-formattedinput
 */
class BootstrapFileField extends FileField {

	/**
	 * Config for this field used in the front-end javascript
	 * (will be merged into the config of the javascript file upload plugin).
	 * See framework/_config/uploadfield.yml for configuration defaults and documentation.
	 * 
	 * @var array
	 */
	protected $bffConfig = array(
		/**
		 * Show the data-icon
		 * 
		 * @var boolean
		 */
		'dataIcon' => true,
                /**
		 * Show the data-input
		 * 
		 * @var boolean
		 */
		'dataInput' => true,
                /**
		 * Button Class
		 * 
		 * @var boolean
		 */
		'dataButtonName' => 'btn btn-primary',
                /**
		 * Button Class
		 * 
		 * @var boolean
		 */
		'dataSize' => 'md',
                /**
		 * Button Class
		 * 
		 * @var boolean
		 */
		'dataIconName' => 'glyphicon-folder-open'
	);

	/**
	 * Assign a front-end config variable for the upload field
	 * 
	 * @see https://github.com/blueimp/jQuery-File-Upload/wiki/Options for the list of front end options available
	 * 
	 * @param string $key
	 * @param mixed $val
	 * @return UploadField self reference
	 */
	public function setConfig($key, $val) {
		$this->bffConfig[$key] = $val;
		return $this;
	}

	/**
	 * Gets a front-end config variable for the upload field
	 * 
	 * @see https://github.com/blueimp/jQuery-File-Upload/wiki/Options for the list of front end options available
	 * 
	 * @param string $key
	 * @return mixed
	 */
	public function getConfig($key) {
		if(!isset($this->bffConfig[$key])) return null;
		return $this->bffConfig[$key];
	}
        
        protected $button_title = null;
	
	/**
	 * Returns the field label - used by templates.
	 */
	public function ButtonTitle() {
		return $this->button_title;
	}
	
	public function setButtonTitle($val) {
		$this->button_title = $val;
		return $this;
	}

	public function __construct($name, $title = null, $value = null) {

		$this->bffConfig = array_merge($this->bffConfig, self::config()->defaultConfig);
                
                parent::__construct($name, $title, $value);

		// filter out '' since this would be a regex problem on JS end
		$this->getValidator()->setAllowedExtensions(
			array_filter(Config::inst()->get('File', 'allowed_extensions'))
		);
                
                $this->addExtraClass('filestyle');
                
                $this->setAttribute('data-icon', $this->getConfig('dataIcon'));
                
                $this->setAttribute('data-input', $this->getConfig('dataInput'));
                
                $this->setAttribute('data-ButtonName', $this->getConfig('dataButtonName'));
                
                $this->setAttribute('data-size', $this->getConfig('dataSize'));
                
                $this->setAttribute('data-IconName', $this->getConfig('dataIconName'));
                
                // Set Button Title
                $this->setAttribute('data-buttonText', _t('BootstrapFileField.CHOOSEFILE', 'BootstrapFileField.CHOOSEFILE'));
	}

	public function Field($properties = array()) {
            
            // Overwrite Button Title
            if($this->button_title) $this->setAttribute('data-buttonText', $this->button_title);
            
            Requirements::javascript(FRAMEWORK_DIR . '/thirdparty/jquery/jquery.min.js');
            Requirements::javascript('bootstrap_extra_fields/javascript/bootstrap-filestyle.min.js');
            //Requirements::css(FRAMEWORK_DIR . '/css/ConfirmedPasswordField.css');
            
            // Fetch the Field Record
	    if($this->form) $record = $this->form->getRecord();
	    $fieldName = $this->name;
	    if(isset($record)&&$record) {
	    	$fileField = $record->$fieldName();
                if($fileField && $fileField->exists()){
                    if($fileField->hasMethod('Thumbnail') && $fileField->Thumbnail()) $Image = $fileField->Thumbnail()->getTag();
                    else if($fileField->CMSThumbnail()) $Image = $fileField->CMSThumbnail();
                    else $Image = false;
                }else{
                    $Image = false;
                }
            }else{
                $Image = false;
            }
            
            $properties = array_merge($properties, array(
                'MaxFileSize' => $this->getValidator()->getAllowedMaxFileSize(),
                'Image' => $Image
            ));
		
            return parent::Field($properties);
	}
}
