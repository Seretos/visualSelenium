<?php
namespace visualSelenium\factory {

    use PHPUnit_Extensions_Selenium2TestCase;
    use PHPUnit_Framework_MockObject_MockObject;
    use PHPUnit_Framework_TestCase;
    use ReflectionClass;
    use visualSelenium\model\Image;
    use visualSelenium\model\ImageMessage;

    function get_class ($argument) {
        ImageBuilderFactoryTest::$functions['get_class']['argument'] = $argument;

        return 'get_class';
    }

    function file_exists ($argument) {
        ImageBuilderFactoryTest::$functions['file_exists']['argument'] = $argument;

        return ImageBuilderFactoryTest::$functions['file_exists']['result'];
    }

    function glob ($argument) {
        ImageBuilderFactoryTest::$functions['glob']['argument'] = $argument;

        return 'glob';
    }

    function array_map ($argument1, $argument2) {
        ImageBuilderFactoryTest::$functions['array_map']['argument'] = [$argument1, $argument2];
    }

    function mkdir ($argument1, $argument2, $argument3) {
        ImageBuilderFactoryTest::$functions['mkdir']['argument'] = [$argument1, $argument2, $argument3];
    }

    /**
     * Created by PhpStorm.
     * User: aappen
     * Date: 18.09.16
     * Time: 04:59
     */
    class ImageBuilderFactoryTest extends PHPUnit_Framework_TestCase {
        public static $functions;

        /**
         * @var ImageBuilderFactory
         */
        private $factory;

        /**
         * @var PHPUnit_Extensions_Selenium2TestCase|PHPUnit_Framework_MockObject_MockObject
         */
        private $mockTest;

        protected function setUp () {
            parent::setUp();
            self::$functions = [];

            $this->mockTest = $this->getMockBuilder(PHPUnit_Extensions_Selenium2TestCase::class)
                                   ->disableOriginalConstructor()
                                   ->getMock();

            $this->factory = new ImageBuilderFactory($this->mockTest, 'directory');

            $this->assertSame($this->mockTest, $this->factory->getTest());
        }

        /**
         * @test
         */
        public function getPath () {
            $this->mockTest->expects($this->once())
                           ->method('getName')
                           ->will($this->returnValue('mockTestName'));
            $this->mockTest->expects($this->once())
                           ->method('getBrowser')
                           ->will($this->returnValue('mockTestBrowser'));

            $this->assertSame('directoryget_class/mockTestName/mockTestBrowser/', $this->factory->getPath());
            $this->assertSame(['get_class' => ['argument' => $this->mockTest]], self::$functions);
        }

        /**
         * @test
         */
        public function resetDirectory_withoutDirectory () {
            self::$functions['file_exists']['result'] = false;

            $this->mockTest->expects($this->once())
                           ->method('getName')
                           ->will($this->returnValue('mockTestName'));
            $this->mockTest->expects($this->once())
                           ->method('getBrowser')
                           ->will($this->returnValue('mockTestBrowser'));

            $this->factory->resetDirectory();
            $this->assertSame(['file_exists' => ['result' => false,
                                                 'argument' => 'directoryget_class/mockTestName/mockTestBrowser/'],
                               'get_class' => ['argument' => $this->mockTest]],
                              self::$functions);
        }

        /**
         * @test
         */
        public function resetDirectory () {
            self::$functions['file_exists']['result'] = true;

            $this->mockTest->expects($this->any())
                           ->method('getName')
                           ->will($this->returnValue('mockTestName'));
            $this->mockTest->expects($this->any())
                           ->method('getBrowser')
                           ->will($this->returnValue('mockTestBrowser'));

            $this->factory->resetDirectory();
            $this->assertSame(['file_exists' => ['result' => true,
                                                 'argument' => 'directoryget_class/mockTestName/mockTestBrowser/'],
                               'get_class' => ['argument' => $this->mockTest],
                               'glob' => ['argument' => 'directoryget_class/mockTestName/mockTestBrowser/*.*'],
                               'array_map' => ['argument' => ['unlink', 'glob']]],
                              self::$functions);
        }

        /**
         * @test
         */
        public function createDirectory_directoryExists () {
            self::$functions['file_exists']['result'] = true;

            $this->mockTest->expects($this->any())
                           ->method('getName')
                           ->will($this->returnValue('mockTestName'));
            $this->mockTest->expects($this->any())
                           ->method('getBrowser')
                           ->will($this->returnValue('mockTestBrowser'));

            $this->factory->createDirectory();

            $this->assertSame(['file_exists' => ['result' => true,
                                                 'argument' => 'directoryget_class/mockTestName/mockTestBrowser/'],
                               'get_class' => ['argument' => $this->mockTest]],
                              self::$functions);
        }

        /**
         * @test
         */
        public function createDirectory () {
            self::$functions['file_exists']['result'] = false;

            $this->mockTest->expects($this->any())
                           ->method('getName')
                           ->will($this->returnValue('mockTestName'));
            $this->mockTest->expects($this->any())
                           ->method('getBrowser')
                           ->will($this->returnValue('mockTestBrowser'));

            $this->factory->createDirectory();

            $this->assertSame(['file_exists' => ['result' => false,
                                                 'argument' => 'directoryget_class/mockTestName/mockTestBrowser/'],
                               'get_class' => ['argument' => $this->mockTest],
                               'mkdir' => ['argument' => ['directoryget_class/mockTestName/mockTestBrowser/',
                                                          0755,
                                                          true]]],
                              self::$functions);
        }

        /**
         * @test
         */
        public function createImage () {
            $this->assertInstanceOf(Image::class, $this->factory->createImage());
        }

        /**
         * @test
         */
        public function createImageMessage () {
            /**
             * @var $mockImage Image|PHPUnit_Framework_MockObject_MockObject
             */
            $mockImage = $this->getMockBuilder(Image::class)
                              ->disableOriginalConstructor()
                              ->getMock();

            $reflection = new ReflectionClass(ImageMessage::class);
            $imageProperty = $reflection->getProperty('image');
            $imageProperty->setAccessible(true);

            $imageMessage = $this->factory->createImageMessage($mockImage);

            $this->assertInstanceOf(ImageMessage::class, $imageMessage);
            $this->assertSame($mockImage, $imageProperty->getValue($imageMessage));
        }
    }
}