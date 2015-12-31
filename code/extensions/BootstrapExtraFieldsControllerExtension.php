<?php

class BootstrapExtraFieldsControllerExtension extends Extension
{
        
    public function onAfterInit()
    {
        Requirements::javascript('bootstrap_extra_fields/javascript/tooltip.js');
    }
}
