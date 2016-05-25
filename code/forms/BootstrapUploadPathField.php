<?php

/**
 * Bootstrap Frontend Upload Filed
 * 
 * Selecting from Storage is allready disabled
 * 
 * @package bootstrap_extra_fields
 */
class BootstrapUploadPathField extends BootstrapUploadField {

	public function Field($properties = array()) {
		Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
		Requirements::javascript(THIRDPARTY_DIR . '/jquery-ui/jquery-ui.js');
		Requirements::javascript(THIRDPARTY_DIR . '/jquery-entwine/dist/jquery.entwine-dist.js');
		Requirements::javascript(FRAMEWORK_ADMIN_DIR . '/javascript/ssui.core.js');
                Requirements::add_i18n_javascript(FRAMEWORK_DIR . '/javascript/lang');

		Requirements::combine_files('uploadfield.js', array(
			// @todo jquery templates is a project no longer maintained and should be retired at some point.
			THIRDPARTY_DIR . '/javascript-templates/tmpl.js', 
			THIRDPARTY_DIR . '/javascript-loadimage/load-image.js',
			THIRDPARTY_DIR . '/jquery-fileupload/jquery.iframe-transport.js',
			THIRDPARTY_DIR . '/jquery-fileupload/cors/jquery.xdr-transport.js',
			THIRDPARTY_DIR . '/jquery-fileupload/jquery.fileupload.js',
			THIRDPARTY_DIR . '/jquery-fileupload/jquery.fileupload-ui.js',
			'bootstrap_extra_fields/javascript/BootstrapUploadField_uploadtemplate.js',
			'bootstrap_extra_fields/javascript/BootstrapUploadPathField_downloadtemplate.js',
			FRAMEWORK_DIR . '/javascript/UploadField.js',
		));
		Requirements::css(THIRDPARTY_DIR . '/jquery-ui-themes/smoothness/jquery-ui.css'); // TODO hmmm, remove it?
		Requirements::css('bootstrap_extra_fields/css/BootstrapUploadPathField.css');

		// Calculated config as per jquery.fileupload-ui.js
		$allowedMaxFileNumber = $this->getAllowedMaxFileNumber();
		$config = array(
			'url' => $this->Link('upload'),
			'urlSelectDialog' => $this->Link('select'),
			'urlAttach' => $this->Link('attach'),
			'urlFileExists' => $this->link('fileexists'),
			'acceptFileTypes' => '.+$',
			// Fileupload treats maxNumberOfFiles as the max number of _additional_ items allowed
			'maxNumberOfFiles' => $allowedMaxFileNumber ? ($allowedMaxFileNumber - count($this->getItemIDs())) : null,
			'replaceFile' => $this->getUpload()->getReplaceFile()
		);
		
		// Validation: File extensions
		if ($allowedExtensions = $this->getAllowedExtensions()) {
			$config['acceptFileTypes'] = '(\.|\/)(' . implode('|', $allowedExtensions) . ')$';
			$config['errorMessages']['acceptFileTypes'] = _t(
				'File.INVALIDEXTENSIONSHORT', 
				'Extension is not allowed'
			);
		}
		
		// Validation: File size
		if ($allowedMaxFileSize = $this->getValidator()->getAllowedMaxFileSize()) {
			$config['maxFileSize'] = $allowedMaxFileSize;
			$config['errorMessages']['maxFileSize'] = _t(
				'File.TOOLARGESHORT', 
				'Filesize exceeds {size}',
				array('size' => File::format_size($config['maxFileSize']))
			);
		}
		
		// Validation: Number of files
		if ($allowedMaxFileNumber) {
			if($allowedMaxFileNumber > 1) {
				$config['errorMessages']['maxNumberOfFiles'] = _t(
					'UploadField.MAXNUMBEROFFILESSHORT', 
					'Can only upload {count} files',
					array('count' => $allowedMaxFileNumber)
				);
			} else {
				$config['errorMessages']['maxNumberOfFiles'] = _t(
					'UploadField.MAXNUMBEROFFILESONE', 
					'Can only upload one file'
				);
			}
		}

		//get all the existing files in the current folder
		if ($this->getOverwriteWarning()) {
			//add overwrite warning error message to the config object sent to Javascript
			$config['errorMessages']['overwriteWarning'] =
				_t('UploadField.OVERWRITEWARNING', 'File with the same name already exists');
		}
		
		$mergedConfig = array_merge($config, $this->ufConfig);
		return $this->customise(array(
			'configString' => str_replace('"', "&quot;", Convert::raw2json($mergedConfig)),
			'config' => new ArrayData($mergedConfig),
			'multiple' => $allowedMaxFileNumber !== 1
		))->renderWith($this->getTemplates());
	}
}
