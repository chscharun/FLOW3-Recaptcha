<?php

namespace TYPO3\Flow\Build;

@require_once('vfsStream/vfsStream.php');
if (!class_exists('vfsStreamWrapper')) {
	exit(PHP_EOL . 'TYPO3 Flow Bootstrap Error: The functional test bootstrap requires vfsStream to be installed (e.g. via PEAR). Please also make sure that it is accessible via the PHP include path.' . PHP_EOL . PHP_EOL);
}

$_SERVER['FLOW_ROOTPATH'] = dirname(__FILE__) . '/../../../../';

/*The remote address is needed to be able to talk with the google api. So if we test our application using the cli, we have to hack it*/
if(!isset($_SERVER['REMOTE_ADDR']))
	$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

require_once($_SERVER['FLOW_ROOTPATH'] . 'Packages/Framework/TYPO3.Flow/Classes/Core/Bootstrap.php');

$bootstrap = new \TYPO3\Flow\Core\Bootstrap('Testing');
$bootstrap->run();

?>