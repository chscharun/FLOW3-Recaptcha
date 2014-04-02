Recaptcha -- TYPO3 Flow v1.0.0
==============================================
-- Integration of google's recaptcha --

(c) Christopher Doerge, Incloud GmbH  
  
The module is finally tested.

Installation
------------

Include the package to the require section in your composer.json file

```
    "require": {
        ................................
        "typo3/recaptcha": "dev-master",
        ................................
    },
```

After this go to [http://www.google.com/recaptcha](http://www.google.com/recaptcha) and create some keys for your website

Add them in Settings.yaml:

```
TYPO3:
  Recaptcha:
    security:
      publicKey: "yourgeneratedpublickey"
      privateKey: "yourgeneratedprivatekey"
```

Usage of the view helper
------------------------

Just add namespace for the view helper and use it in your template without any parameter as shown in the example below:

```
{namespace tr=TYPO3\Recaptcha\ViewHelpers}

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Index view of Recaptcha Demo</title> 
    <f:base />
  </head>
  <body>
    <h1>Recaptcha Demo</h1>
    <f:flashMessages class="flashmessages" />
    <f:form action="validate" controller="Standard" method="post" name="validationform">
      <tr:form.captcha />
      <f:form.submit value="Validate" />
    </f:form>
  </body>
</html>
```

Usage of the validator
----------------------

Now you can use the validator in your validate action.  
Parameters are the recaptcha_challenge_field and the recaptcha_response_field delivered by the form.

```
class StandardController extends \TYPO3\Flow\MVC\Controller\ActionController {

  /**
   * Your validate action with captcha field
   *
   * @Flow\Validate("$captchaResponse", type="TYPO3\Recaptcha\Validation\Validator\CaptchaValidator")
   * @return void
   */
  public function validateAction($captchaResponse) {
    // validation is automatically done and if we reach this code, the captcha was filled successfully
    $this->redirect("index");
  }

}
```

Remember functionality
----------------------

You can can let the recaptcha module add the successfuly solution of the captcha to the session by setting the third parameter of validate function to true.  
Your Application will now remember for specified period of time you can also set in the settings.yaml. The default time for this period is 900 seconds.

```
TYPO3:
  Recaptcha:
    security:
      publicKey: "yourgeneratedpublickey"
      privateKey: "yourgeneratedprivatekey"
    memory:
      validTime: 900
```

You can manually unremember by using the invalidate function of the recaptcha model.

I18N
----

English is the only language that is supported at the moment. It is planned to provide internationalization functionality when FLOW3 1.1 finally appears.

License
-------

All the code is licensed under the GPL license.