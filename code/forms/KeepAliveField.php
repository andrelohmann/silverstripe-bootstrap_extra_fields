<?php

/**
 * Field to send a ping to keep the login alive during huge uploads e.g.
 */

class KeepAliveField extends HiddenField
{

    private static $allowed_actions = array(
        'load'
    );
    

    public function load($request)
    {
        $response = new SS_HTTPResponse();
        $response->addHeader('Content-Type', 'application/json');
        $response->setBody(Convert::array2json(array(
            "_memberID" => Member::currentUserID()
        )));
        return $response;
    }

    public function Field($properties = array())
    {
        Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
        Requirements::javascript('bootstrap_extra_fields/javascript/KeepAliveField.js');

        $this->addExtraClass('keep-alive-field');
        $this->setAttribute('data-link', $this->Link('load'));

        return parent::Field($properties);
    }
}
