<?php

/**
 * A helper class for Codeception (http://codeception.com/) that allows automated HTML5 Validation
 * using the Nu Html Checker (http://validator.github.io/validator/) during acceptance testing.
 * It uses local binaries and can therefore be run offline.
 *
 *
 * Requirements:
 * =============
 *
 * - Codeception with WebDriver set up (PhpBrowser doesn't work)
 * - java is installed locally
 * - The vnu.jar is installed locally (download the .zip from https://github.com/validator/validator/releases,
 *   it contains the .jar file)
 *
 *
 * Installation:
 * =============
 *
 * - Copy this file to _support/Helper/ in the codeception directory
 * - Merge the following configuration to acceptance.suite.yml:
 *
 * modules:
 *   enabled:
 *     - \Helper\HTMLValidator
 *   config:
 *     \Helper\HTMLValidator:
 *       javaPath: /usr/bin/java
 *       vnuPath: /usr/local/bin/vnu.jar
 *
 *
 *
 * Usage:
 * ======
 *
 * Validate the HTML of the current page:
 * $I->validateHTML();
 *
 * Validate the HTML of the current page, but ignore errors containing the string "Ignoreit":
 * $I->validateHTML(["Ignoreme"]);
 *
 *
 *
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @author Tobias Hößl <tobias@hoessl.eu>
 */

namespace Helper;

use Codeception\TestCase;

class HTMLValidator extends \Codeception\Module
{
    /**
     * @param string $html
     * @return array
     * @throws \Exception
     */
    private function validateByVNU($html)
    {
        $javaPath = $this->_getConfig('javaPath');
        if (! $javaPath) {
            $javaPath = 'java';
        }
        $vnuPath = $this->_getConfig('vnuPath');
        if (! $vnuPath) {
            $vnuPath = '/usr/local/bin/vnu.jar';
        }

        $filename = DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.uniqid('html-validate').'.html';
        file_put_contents($filename, $html);
        exec($javaPath.' -Xss1024k -jar '.$vnuPath.' --format json '.$filename.' 2>&1', $return);
        $data = json_decode($return[0], true);
        if (! $data || ! isset($data['messages']) || ! is_array($data['messages'])) {
            throw new \Exception('Invalid data returned from validation service: '.$return);
        }

        return $data['messages'];
    }

    /**
     * @return string
     * @throws \Codeception\Exception\ModuleException
     * @throws \Exception
     */
    private function getPageSource()
    {
        if (! $this->hasModule('WebDriver')) {
            throw new \Exception('This validator needs WebDriver to work');
        }

        /** @var \Codeception\Module\WebDriver $webdriver */
        $webdriver = $this->getModule('WebDriver');

        return $webdriver->webDriver->getPageSource();
    }

    /**
     * @param string[] $ignoreMessages
     */
    public function validateHTML($ignoreMessages = [])
    {
        $source = $this->getPageSource();
        try {
            $messages = $this->validateByVNU($source);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());

            return;
        }
        $failMessages = [];
        $lines = explode("\n", $source);
        foreach ($messages as $message) {
            if ($message['type'] == 'error') {
                $formattedMsg = '- Line '.$message['lastLine'].', column '.$message['lastColumn'].': '.
                    $message['message']."\n  > ".$lines[$message['lastLine'] - 1];
                $ignoring = false;
                foreach ($ignoreMessages as $ignoreMessage) {
                    if (mb_stripos($formattedMsg, $ignoreMessage) !== false) {
                        $ignoring = true;
                    }
                }
                if (! $ignoring) {
                    $failMessages[] = $formattedMsg;
                }
            }
        }
        if (count($failMessages) > 0) {
            \PHPUnit_Framework_Assert::fail('Invalid HTML: '."\n".implode("\n", $failMessages));
        }
    }
}
