<?php
namespace TYPO3\Recaptcha\Validation\Validator;

/*                                                                    *
 * This script belongs to the TYPO3 Flow package "TYPO3.Recaptcha".   *
 *                                                                    */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Validation\Validator\AbstractValidator;
use TYPO3\Recaptcha\Domain\Model\Recaptcha;

/**
 * Captcha Validator for the TYPO3 Recaptcha Package
 */
class CaptchaValidator extends AbstractValidator {

	/**
	 * This validator always needs to be executed even if the given value is empty.
	 * See AbstractValidator::validate()
	 *
	 * @var boolean
	 */
	protected $acceptsEmptyValues = FALSE;



	/**
	 * @Flow\Inject
	 * @var Recaptcha
	 */
	protected $recaptcha;



	/**
	 * Check, if the given captcha value is valid.
	 *
	 * @param array $value The response value for the captcha
	 * @return void
	 */
	protected function isValid($value) {
		// Check whether captcha is empty
		if ($value === '' || $value === NULL) {
			$this->addError('The captcha must not be empty!', 1395205827);
			return;
		}

		// Check whether captcha response is what we expected
		$captchaChallenge = $_POST['recaptcha_challenge_field'];
		$validationResult = $this->recaptcha->validate($captchaChallenge, $value);
		if (!($validationResult === TRUE)) {
			$this->addError($validationResult, 1395205826);
		}
	}

}