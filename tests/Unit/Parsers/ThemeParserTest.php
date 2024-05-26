<?php

namespace RenVentura\WPPackageParser\Tests;

use PHPUnit\Framework\TestCase;
use RenVentura\WPPackageParser\WPPackage;

class ThemeParserTest extends TestCase
{
    /**
     * Package not found.
     *
     * @return void
     */
    public function testNoInfoWhenPackageNotFound()
    {
        $package = new WPPackage('path/wrong/test.zip');
        $this->assertEquals(null, $package->getType());
        $this->assertEquals(array(), $package->getMetaData());
        $this->assertEquals(null, $package->getSlug());
    }

    /**
     * Correctly parses a valid package.
     *
     * @return void
     */
    public function testParsesValidTheme()
    {
        $package = new WPPackage(TESTS_DIR . '/packages/twentyseventeen.1.3.zip');
        $this->assertEquals('theme', $package->getType());
        $this->assertEquals('twentyseventeen', $package->getSlug());
    }

    /**
     * getMetaData() should return correct data about the package.
     *
     * @return void
     */
    public function testGetmetadataShouldReturnCorrectDataForTheme()
    {
        $package = new WPPackage(TESTS_DIR . '/packages/twentysixteen.1.3.zip');
        $this->assertEquals('theme', $package->getType());
        $this->assertEquals('twentysixteen', $package->getSlug());

        $metadata = $package->getMetaData();
        $this->assertEquals('1.3', $metadata['version']);
        $this->assertEquals('Twenty Sixteen', $metadata['name']);
        $this->assertEquals('twentysixteen', $metadata['text_domain']);
        $this->assertEquals('twentysixteen', $metadata['slug']);
    }
}
