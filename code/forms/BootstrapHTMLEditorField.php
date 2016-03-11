<?php
/**
 * @author Andre Lohmann
 * 
 * @package geoform
 * @subpackage fields-formattedinput
 */
class BootstrapHTMLEditorField extends TextareaField {
	
	public function Field($properties = array()) {
		Requirements::css('bootstrap_extra_fields/thirdparty/summernote/summernote.css');
		Requirements::javascript(FRAMEWORK_DIR . '/thirdparty/jquery/jquery.min.js');
		Requirements::javascript('bootstrap_extra_fields/thirdparty/summernote/summernote.min.js');
		
		// set caption if required
		$js = <<<JS
$(document).ready(function() {
    $('#{$this->ID()}').summernote({
        callbacks: {
            onChange: function(contents) {
                $('##{$this->ID()}').html($('#{$this->ID()}').summernote('code'));
            }
        }
	});
});
JS;
        
		Requirements::customScript($js, 'BootstrapHTMLEditorField_Js_'.$this->ID());
        
        return parent::Field($properties);
	}
}