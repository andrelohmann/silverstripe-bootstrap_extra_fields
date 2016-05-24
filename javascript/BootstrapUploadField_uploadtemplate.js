window.tmpl.cache['ss-uploadfield-uploadtemplate'] = tmpl(
	'{% for (var i=0, files=o.files, l=files.length, file=files[0]; i<l; file=files[++i]) { %}' +
		'<li class="ss-uploadfield-item template-upload{% if (file.error) { %} ui-state-error{% } %}">' +
			'<div class="ss-uploadfield-item-preview preview"><span></span></div>' +
			'<div class="ss-uploadfield-item-info">' +
				'<label class="ss-uploadfield-item-name">' + 
					'<span class="name" title="{% if (file.name) { %}{%=file.name%}{% } else { %}' + ss.i18n._t('UploadField.NOFILENAME', 'Untitled') + '{% } %}">' +
					'{% if (file.name) { %}{%=file.name%}{% } else { %}' + ss.i18n._t('UploadField.NOFILENAME', 'Untitled') + '{% } %}</span> ' + 
					'{% if (!file.error) { %}' +
						'<div class="ss-uploadfield-item-status">0%</div>' +						
					'{% } else {  %}' +
						'<div class="ss-uploadfield-item-status ui-state-error-text" title="{%=o.options.errorMessages[file.error] || file.error%}">{%=o.options.errorMessages[file.error] || file.error%}</div>' + 
					'{% } %}' + 
					'<div class="clear"><!-- --></div>' + 
				'</label>' +
				'{% if (!file.error) { %}' +
                                    '<div class="ss-uploadfield-item-actions">' +                             				
                                            '<div class="ss-uploadfield-item-progress"><div class="ss-uploadfield-item-progressbar"><div class="ss-uploadfield-item-progressbarvalue"></div></div></div>' +
                                            '{% if (!o.options.autoUpload) { %}' + 
                                                    '<div class="ss-uploadfield-item-start start"><button type="button" class="icon icon-16 btn btn-info" data-icon="navigation">' + ss.i18n._t('UploadField.START', 'Start') + '</button></div>' + 
                                            '{% } %}' +                                    
                                    '</div>' +
                                '{% } %}' + 
				'<div class="ss-uploadfield-item-actions">' + 
					'<div class="ss-uploadfield-item-cancel cancel">' +
						'<button type="button" class="icon icon-16 btn btn-danger" data-icon="minus-circle" title="' + ss.i18n._t('UploadField.CANCELREMOVE', 'Cancel/Remove') + '">' + ss.i18n._t('UploadField.CANCELREMOVE', 'Cancel/Remove') + '</button>' +
					'</div>' +
					'<div class="ss-uploadfield-item-overwrite hide ">'+
						'<button type="button" data-icon="drive-upload" class="ss-uploadfield-item-overwrite-warning btn btn-warning" title="' + ss.i18n._t('UploadField.OVERWRITE', 'Overwrite') + '">' + ss.i18n._t('UploadField.OVERWRITE', 'Overwrite') + '</button>' +
					'</div>' +
				'</div>' +
			'</div>' +
		'</li>' + 
	'{% } %}'
);
