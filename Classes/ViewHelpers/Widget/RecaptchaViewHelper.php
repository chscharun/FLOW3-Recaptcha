<?php
namespace Incloud\Recaptcha\ViewHelpers\Widget;

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * @FLOW3\Scope("prototype")
 * @api
 */
class RecaptchaViewHelper extends \TYPO3\Fluid\Core\Widget\AbstractWidgetViewHelper
{
	/**
	 * @FLOW3\Inject
	 * @var Incloud\Recaptcha\ViewHelpers\Widget\Controller\RecaptchaController
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
