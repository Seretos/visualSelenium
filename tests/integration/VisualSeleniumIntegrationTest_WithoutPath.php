<?php
use visualSelenium\PHPUnit_Extensions_VisualSelenium2TestCase;

/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 19.09.16
 * Time: 15:57
 */
class VisualSeleniumIntegrationTest_WithoutPath extends PHPUnit_Extensions_VisualSelenium2TestCase {
    public static $browsers = [
        ['browserName' => 'firefox'],
        // ['browserName' => 'chrome']
    ];

    protected function setUp () {
        parent::setUp();
        $this->setHost('192.168.56.2');
        $this->setBrowserUrl('http://www.google.com');
    }

    /**
     * @test
     */
    public function myTest () {
        $this->url("/");
        $this->createScreenshot('call '.$this->getBrowserUrl().'/');
        $this->byXPath(".//*[@id='tsf']/div[2]/div[3]/center/input[2]")
             ->click();
        $this->createScreenshot('click button');
        $this->url("/maps");
        $this->createScreenshot('call '.$this->getBrowserUrl().'/maps');
    }
}