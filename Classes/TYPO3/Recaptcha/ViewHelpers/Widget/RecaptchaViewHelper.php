<?php

namespace TYPO3\Recaptcha\ViewHelpers\Widget;

use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Scope("prototype")
 * @api
 */
class RecaptchaViewHelper extends \TYPO3\Fluid\Core\Widget\AbstractWidgetViewHelper {

	/**
	 * @Flow\Inject
	 * @var TYPO3\Recaptcha\ViewHelpers\Widget\Controller\RecaptchaController
	 */
	protected $controller;

	/**
	 * @return string
	 * @api
	 */
	public function render() {
		return $this->initiateSubRequest();
	}
}

?>