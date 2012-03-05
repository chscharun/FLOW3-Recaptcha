Recaptcha -- FLOW3
==============================================
-- Integration of google's recaptcha --

(c) Christopher Doerge, Incloud GmbH

Installation
------------

```
cd <Flow3>/Packages/Application
git clone --recursive git://github.com/incloud-cdoerge/FLOW3-Recaptcha.git Incloud.Recaptcha
cd ../../
./flow3 package:activate Incloud.Recaptcha
```

After this go to [http://www.google.com/recaptcha](http://www.google.com/recaptcha) and create some keys for your site

Add them in Settings.yaml:

```
Incloud:
  Recaptcha:
    security:
      publicKey: "yourgeneratedpublickey"
      privateKey: "yourgeneratedprivatekey"
```

Usage of the view helper
------------------------

Just add namespace for the view helper and use it in your template without any parameter as shown in the example below:

  {namespace ir=Incloud\Recaptcha\ViewHelpers\Widget}

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
        <ir:recaptcha />
        <f:form.submit value="Validate" />
      </f:form>
    </body>
  </html>

Usage of the validator
----------------------

In your Action Controller simply inject the validator model.
Now you can use the validate function.
Parameters are the recaptcha_challenge_field and the recaptcha_response_field delivered by the form.

  class StandardController extends \TYPO3\FLOW3\MVC\Controller\ActionController {

    /**
     * @FLOW3\Inject
     * @var Incloud\Recaptcha\Domain\Model\Recaptcha
     */
    protected $recaptcha;

    /**
     * Index action
     *
     * @return void
     */
    public function indexAction() {
      //only shows form
    }

    /**
     * Validate action
     *
     * @return void
     */
    public function validateAction() {
      $arguments = $this->request->getArguments();
      $resp = $this->recaptcha->validate($arguments["recaptcha_challenge_field"], $arguments["recaptcha_response_field"]);
      
      if($resp !== true)
        $this->addFlashMessage($resp);
      else
        $this->addFlashMessage("Validation successful!");

      $this->redirect("index");
    }

  }

Remember functionality
----------------------

You can can let the recaptcha module add the successfuly solution of the captcha to the session by setting the third parameter of validate function to true.
Your Application will now remember for specified period of time u can also set in the settings.yaml. The default time for this period is 900 seconds.

```
Incloud:
  Recaptcha:
    security:
      publicKey: "yourgeneratedpublickey"
      privateKey: "yourgeneratedprivatekey"
    memory:
      validTime: 900
```

You can manually unremember by using the invalidate function of the recaptcha model.

License
-------

All the code is licensed under the GPL license.