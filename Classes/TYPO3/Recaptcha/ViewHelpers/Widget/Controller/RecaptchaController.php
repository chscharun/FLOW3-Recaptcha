<?php

namespace TYPO3\Recaptcha\ViewHelpers\Widget\Controller;

use TYPO3\Flow\Annotations as Flow;

/**
 * Recaptcha widget controller for the TYPO3.Recaptcha package
 *
 * Handles all stuff that has to do with the recaptcha widget
 *
 * @Flow\Scope("singleton")
 */
class RecaptchaController extends \TYPO3\Fluid\Core\Widget\AbstractWidgetController {

	/**
	 * @Flow\Inject
	 * @var TYPO3\Recaptcha\Domain\Model\Recaptcha
	 */
	protected $recaptcha;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Session\SessionInterface
	 */
	protected $session;

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * @param array $settings
	 * @return void
	 */
	public function injectSettings(array $settings) {
			$this->settings = $settings;
	}

	/*
	 * Add Recaptcha Template to the current view
	 * @return void
	 */
	public function indexAction() {
		if(!$this->session->isStarted())
			$this->session->start();

		$this->view->assign("publickey", $this->settings["security"]["publicKey"]);
		// If user comes with a valid session, we dont show the captcha
		$this->view->assign("hidecaptcha",$this->recaptcha->isRemembered());
	}

}

?>