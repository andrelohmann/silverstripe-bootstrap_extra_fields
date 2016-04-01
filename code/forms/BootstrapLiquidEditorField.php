<?php
/**
 * @author Andre Lohmann
 * 
 * @package bootstrap-extra-fields
 */
class BootstrapLiquidEditorField extends TextareaField {
	
	public function Field($properties = array()) {
		Requirements::javascript('bootstrap_extra_fields/thirdparty/ace-min-noconflict/ace.js');
		
		// set caption if required
		$js = <<<JS
$(document).ready(function() {
	var editor = ace.edit("{$this->ID()}-ace-editor");
	editor.setTheme("ace/theme/monokai");
    editor.getSession().setMode("ace/mode/liquid");
    editor.getSession().on('change', function(e) {
		$('#{$this->ID()}').html(editor.getValue());
	});
});
JS;
        
		Requirements::customScript($js, 'BootstrapLiquidEditorField_Js_'.$this->ID());
        
        return parent::Field($properties);
	}
}