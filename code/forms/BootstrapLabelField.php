<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BootstrapLabelField extends FormField {

	/**
	 * @var bool $allowHTML
	 */
	protected $allowHTML;
	/**
	 * @param string $name
	 * @param null|string $title
	 */
	public function __construct($name, $title = null) {
		// legacy handling:
		// $title, $headingLevel...
		$args = func_get_args();

		if(!isset($args[1])) {
			$title = (isset($args[0])) ? $args[0] : null;

			if(isset($args[0])) {
				$title = $args[0];
			}

			// Prefix name to avoid collisions.
			$name = 'LabelField' . $title;
		}

		parent::__construct($name, $title);
	}

	/**
	 * function that returns whether this field contains data.
	 * Always returns false.
	 */
	public function hasData() { return false; }

	public function getAttributes() {
		return array_merge(
			parent::getAttributes(),
			array(
				'type' => 'hidden',
			)
		);
	}

	/**
	 * Returns a readonly version of this field
	 */
	public function performReadonlyTransformation() {
		$clone = clone $this;
		$clone->setReadonly(true);
		return $clone;
	}

	/**
	 * @param bool $bool
	 */
	public function setAllowHTML($bool) {
		$this->allowHTML = $bool;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function getAllowHTML() {
		return $this->allowHTML;
	}

	public function Type() {
		return 'readonly';
	}
	
}