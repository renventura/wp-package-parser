WP Package Parser ![Develop branch](https://github.com/renventura/wp-package-parser/actions/workflows/ci.yml/badge.svg?branch=develop) [![GitHub issues](https://img.shields.io/github/issues/renventura/wp-package-parser.svg)](https://github.com/renventura/wp-package-parser/issues) [![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/renventura/wp-package-parser/master/LICENSE) 
========================

A PHP library for parsing WordPress plugin and theme metadata. Point it at a ZIP package and it will:

- Tell you whether it contains a plugin or a theme.
- Give you the metadata from the comment header (Version, Description, Author URI, etc).
- Parse readme.txt into a list of headers and sections.
- Convert readme.txt contents from Markdown to HTML.

Installation
-----------
It is recommended to [install the composer package](https://packagist.org/packages/renventura/wp-package-parser).

```sh
composer require renventura/wp-package-parser
```

Basic usage
-----------
### Extract plugin metadata:

```php
require 'vendor/autoload.php';
$package = new RenVentura\WPPackageParser\WPPackage('/var/path/plugin.zip');
print_r($package->getMetaData());
```

Sample output:

```
Array
(
    [name] => Hello Dolly
    [plugin_uri] => https://wordpress.org/plugins/hello-dolly/
    [version] => 1.6
    [description] => This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong: Hello, Dolly. When activated you will randomly see a lyric from Hello, Dolly in the upper right of your admin screen on every page.
    [author] => Matt Mullenweg
    [author_profile] => http://ma.tt/
    [text_domain] => hello-dolly
    [domain_path] => 
    [network] => 
    [plugin] => hello-dolly/hello.php
    [contributors] => Array
        (
            [0] => matt
        )

    [donate] => 
    [tags] => Array
        (
        )

    [requires] => 4.6
    [tested] => 4.7
    [stable] => 1.6
    [short_description] => This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong.
    [sections] => Array
        (
            [description] => 
This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong: Hello, Dolly. When activated you will randomly see a lyric from Hello, Dolly in the upper right of your admin screen on every page.


        )

    [readme] => 1
    [slug] => hello-dolly
)
```

### Extract theme metadata:

```php
require 'vendor/autoload.php';
$package = new RenVentura\WPPackageParser\WPPackage('/var/path/theme.zip');
print_r($package->getMetaData());
```

Sample output:

```
Array
(
    [name] => Twenty Sixteen
    [theme_uri] => https://wordpress.org/themes/twentysixteen/
    [description] => Twenty Sixteen is a modernized take on an ever-popular WordPress layout — the horizontal masthead with an optional right sidebar that works perfectly for blogs and websites. It has custom color options with beautiful default color schemes, a harmonious fluid grid using a mobile-first approach, and impeccable polish in every detail. Twenty Sixteen will make your WordPress look beautiful everywhere.
    [author] => the WordPress team
    [author_uri] => https://wordpress.org/
    [version] => 1.3
    [template] => 
    [status] => 
    [tags] => Array
        (
            [0] => one-column
            [1] => two-columns
            [2] => right-sidebar
            [3] => accessibility-ready
            [4] => custom-background
            [5] => custom-colors
            [6] => custom-header
            [7] => custom-menu
            [8] => editor-style
            [9] => featured-images
            [10] => flexible-header
            [11] => microformats
            [12] => post-formats
            [13] => rtl-language-support
            [14] => sticky-post
            [15] => threaded-comments
            [16] => translation-ready
            [17] => blog
        )

    [text_domain] => twentysixteen
    [domain_path] => 
    [slug] => twentysixteen
)
```

Requirements
------------
PHP >= 8.0. 

Credits
-------
This was forked from [tutv/wp-package-parser](https://github.com/tutv/wp-package-parser). The original project was not updated for many years. I forked it, and modernized it for compatibility with:
* PHP8+
* PHPUnit v9.6
* Improved coding standards
* Composer autoloading
* GitHub Actions for automated CI testing

All original licensing remains the same. Many thanks to @tutv for his contributions.
