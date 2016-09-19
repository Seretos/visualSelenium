<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 17.09.16
 * Time: 22:40
 */

use visualSelenium\PHPUnit_Extensions_VisualSelenium2TestCase;

class VisualSeleniumIntegrationTest extends PHPUnit_Extensions_VisualSelenium2TestCase {
    public static $browsers = [
        ['browserName' => 'firefox'],
        // ['browserName' => 'chrome']
    ];

    protected function setUp () {
        parent::setUp(__DIR__.'/../output/');
        $this->setHost('192.168.56.2');
        $this->setBrowserUrl('http://www.google.com');
    }

    /**
     * @test
     */
    public function myTest () {
        $this->url("/");
        $this->byXPath(".//*[@id='tsf']/div[2]/div[3]/center/input[2]")
             ->click();
        $this->url("/maps");
    }
}