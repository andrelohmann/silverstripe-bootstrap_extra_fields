<?php
/**
 * @author Andre Lohmann
 * 
 * @package bootstrap-extra-fields
 */
class BootstrapLiquidEditorField extends TextareaField {
	
	public function Field($properties = array()) {
		$css = <<<CSS
#{$this->ID()}-ace-editor {
    height: 300px;
}
CSS;
		Requirements::customCSS($css, 'BootstrapLiquidEditorField_Css_'.$this->ID());
		Requirements::javascript('bootstrap_extra_fields/thirdparty/ace-min-noconflict/ace.js');
		
		// set caption if required
		$js = <<<JS
$(document).ready(function() {
	var editor = ace.edit("{$this->ID()}-ace-editor");
	editor.setValue($('#{$this->ID()}').val());
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