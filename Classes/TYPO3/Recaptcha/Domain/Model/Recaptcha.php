<?php
namespace TYPO3\Recaptcha\Domain\Model;

/*                                                                        *
 * This script belongs to the vendor package "TYPO3.Recaptcha".           *
 *                                                                        *
 *                                                                        */

use TYPO3\Recaptcha\External as Ext;
use TYPO3\Flow\Annotations as Flow;

/**
 * The Recaptcha Model
 *
 * @Flow\Scope("singleton")
 */
class Recaptcha {

	/**
	 * @Flow\Inject
	 * @var TYPO3\Flow\Utility\Environment
	 */
	protected $environment;

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

	/**
	 * Validate the Captcha in the current request by asking the recaptcha server.
	 * For this to work, the form of the current request has to contain the <x:recaptcha /> template
	 * function.
	 * @param string $challenge The challenge that was given by recaptcha
	 * @param string $response The response the user put in
	 * @param boolean $remember Optional. If true, the correctly solved captcha is remembered and the
	 * user does not have to fill it out again. Remember to use invalidate() in this case!
	 * @return mixed Boolean true on success, the localized error string on failure (check with ===).
	 */
	public function validate($challenge, $response, $remember = false) {
		if(!$this->session->isStarted())
			$this->session->start();

		if($remember && $this->isRemembered())
			return true;

		if (empty($response))
			return "Please type in the confirmation code!";

		// Check via recaptcha lib
		require_once("resource://TYPO3.Recaptcha/PHP/recaptchalib.php");

		$remoteAddress = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : NULL;
		$resp = Ext\recaptcha_check_answer($this->settings["security"]["privateKey"], $remoteAddress, $challenge, $response);

		if (!$resp->is_valid)
			return $this->decodeError($resp->error);

		// remember if we want to remember
		if ($remember)
			$this->session->putData("recaptcha_timestamp", time());

		return true;
	}

	/**
	 * If a captcha is remembered as solved correctly, this function resets this memory. Use
	 * this always if you use validate(remember = true).
	 */
	public function invalidate() {
		$this->session->putData("recaptcha_timestamp", 0);
	}


	// HELPERS /////////////////////////////////////////////////////////////////

	protected function decodeError($errormsg) {
		switch ($errormsg)
		{
			case "invalid-site-public-key":
			case "invalid-site-private-key":
			case "invalid-referrer":
			case "verify-params-incorrect":
			case "invalid-request-cookie": //challange field incorrect
				$errorstr = "A technical problem occured:". $errormsg;
				break;

			case "incorrect-captcha-sol":
				$errorstr = "You entered an invalid confirmation code. Please try again.";
				break;

			case "recaptcha-not-reachable":
				$errorstr = "The Captcha service is unfortunately not reachable. Please try again in 5 minutes.";
				break;

			default:
				$errorstr = "A technical problem occured: ".$errormsg;
		}

		return $errorstr;
	}

	/*
	 * @return boolean True if this a captcha has already been solved in this session
	 */
	public function isRemembered () {
		return $this->session->hasKey("recaptcha_timestamp") && $this->session->getData("recaptcha_timestamp") > time()- (int)$this->settings["security"]["validTime"];
	}
}

?>