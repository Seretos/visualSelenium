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
        parent::setUp(__DIR__.'/../../output/');
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

        $this->assertSame(true,
                          file_exists(__DIR__.
                                      '/../../output/VisualSeleniumIntegrationTest/myTest/firefox/00000000_call_http___www.google.com_.png'));
        $this->assertSame(true,
                          file_exists(__DIR__.
                                      '/../../output/VisualSeleniumIntegrationTest/myTest/firefox/00000001_click_button.png'));
        $this->assertSame(true,
                          file_exists(__DIR__.
                                      '/../../output/VisualSeleniumIntegrationTest/myTest/firefox/00000002_call_http___www.google.com_maps.png'));
    }
}