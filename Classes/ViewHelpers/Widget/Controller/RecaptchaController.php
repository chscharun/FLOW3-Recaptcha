<?php
namespace Incloud\Recaptcha\ViewHelpers\Widget\Controller;

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * Recaptcha widget controller for the Incloud.Recaptcha package 
 *
 * Handles all stuff that has to do with the recaptcha widget
 * 
 * @FLOW3\Scope("singleton")
 */
class RecaptchaController extends \TYPO3\Fluid\Core\Widget\AbstractWidgetController

{
	
	/**
	 * @FLOW3\Inject
	 * @var Incloud\Recaptcha\Domain\Model\Recaptcha
	 */
	protected $recaptcha;
	
	/**
	 * @FLOW3\Inject
	 * @var \TYPO3\FLOW3\Session\SessionInterface
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
	public function indexAction ()
	{
		if(!$this->session->isStarted())
			$this->session->start();
		
		$this->view->assign("publickey", $this->settings["security"]["publicKey"]);
		// If user comes with a valid session, we dont show the captcha
		$this->view->assign("hidecaptcha",$this->recaptcha->isRemembered());

	}

}
?>
