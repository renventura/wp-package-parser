<?php

namespace RenVentura\WPPackageParser\Tests;

use PHPUnit\Framework\TestCase;
use RenVentura\WPPackageParser\WPPackage;

class PluginParserTest extends TestCase
{
    /**
     * Package not found.
     *
     * @return void
     */
    public function testNoInfoWhenPackageNotFound()
    {
        $package = new WPPackage('/path/wrong/abc.zip');
        $this->assertEquals(null, $package->getType());
        $this->assertEquals(null, $package->getSlug());
        $this->assertEquals(array(), $package->getMetaData());
    }

    /**
     * Correctly parses a valid plugin.
     *
     * @return void
     */
    public function testParsesValidPlugin()
    {
        $package = new WPPackage(TESTS_DIR . '/packages/hello-dolly.1.6.zip');
        $this->assertEquals('plugin', $package->getType());
        $this->assertEquals('hello-dolly', $package->getSlug());
    }

    /**
     * getMetaData() should return correct data about the package.
     *
     * @return void
     */
    public function testGetmetadataShouldReturnCorrectDataForPlugin()
    {
        $package = new WPPackage(TESTS_DIR . '/packages/hello-dolly.1.6.zip');

        $metadata = $package->getMetaData();
        $this->assertEquals('Hello Dolly', $metadata['name']);
        $this->assertEquals('hello-dolly/hello.php', $metadata['plugin']);
        $this->assertEquals('4.6', $metadata['requires']);
        $this->assertEquals('4.7', $metadata['tested']);
        $this->assertEquals('1.6', $metadata['version']);
        $this->assertEquals('hello-dolly', $metadata['slug']);
    }
}
