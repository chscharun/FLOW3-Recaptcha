<?php
namespace TYPO3\Recaptcha\ViewHelpers\Form;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Fluid\ViewHelpers\Form\AbstractFormFieldViewHelper;

/**
 * = Basic usage =
 *
 * <code title="Example">
 * <captcha:form.captcha publicKey="...your recaptcha public key..." />
 * </code>
 *
 * @api
 */
class CaptchaViewHelper extends AbstractFormFieldViewHelper {

	/**
	 * Holds the default template to be used for rendering the content of the view helper
	 *
	 * @var string
	 */
	protected $templateResource = 'resource://TYPO3.Recaptcha/Private/Templates/ViewHelpers/Form/Captcha.html';



	/**
	 * Initialize arguments.
	 *
	 * @return void
	 */
	public function initializeArguments() {
		$this->registerTagAttribute('template', 'string', 'Resource string for the template to be used for rendering the captcha view helper (optional)', FALSE);
		$this->registerTagAttribute('publicKey', 'string', 'The public key for the Recaptcha account to be used for this captcha (required!)', TRUE);
	}



	/**
	 * @return string The rendered captcha HTML code
	 */
	public function render() {
		if ($this->arguments['template']) {
			$this->templateResource = $this->arguments['template'];
		}
		$view = $this->objectManager->get('\TYPO3\Fluid\View\StandaloneView');
		/* @var $view \TYPO3\Fluid\View\StandaloneView */

		$view->setTemplatePathAndFilename($this->templateResource);
		$view->assign('fieldNamePrefix', $this->viewHelperVariableContainer->get('TYPO3\Fluid\ViewHelpers\FormViewHelper', 'fieldNamePrefix'));
		$view->assign('publicKey', $this->arguments['publicKey']);
		return $view->render();
	}

}