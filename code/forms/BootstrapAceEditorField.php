<?php
/**
 * @author Andre Lohmann
 * 
 * @package bootstrap-extra-fields
 */
class BootstrapAceEditorField extends TextareaField {
	
	protected $theme = "textmate";
	
	protected $mode = "javascript";

	/**
	 * Set the theme
	 *
	 * @param string $theme
	 *
	 * @return $this
	 */
	public function setTheme($theme) {
		$this->theme = $theme;

		return $this;
	}

	/**
	 * Set the mode
	 *
	 * @param string $mode
	 *
	 * @return $this
	 */
	public function setMode($mode) {
		$this->mode = $mode;

		return $this;
	}
	
	public function Field($properties = array()) {
		$css = <<<CSS
#{$this->ID()}-ace-editor {
    height: 300px;
}
CSS;
		Requirements::customCSS($css, 'BootstrapAceEditorField_Css_'.$this->ID());
		Requirements::javascript('bootstrap_extra_fields/thirdparty/ace-min-noconflict/ace.js');
		
		// set caption if required
		$js = <<<JS
$(document).ready(function() {
	var editor = ace.edit("{$this->ID()}-ace-editor");
	editor.setValue($('#{$this->ID()}').val());
	editor.setTheme("ace/theme/{$this->theme}");
    editor.getSession().setMode("ace/mode/{$this->mode}");
    editor.getSession().on('change', function(e) {
		$('#{$this->ID()}').html(editor.getValue());
	});
});
JS;
        
		Requirements::customScript($js, 'BootstrapAceEditorField_Js_'.$this->ID());
        
        return parent::Field($properties);
	}
}