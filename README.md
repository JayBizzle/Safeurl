Safeurl
=======
[![Latest Stable Version](https://img.shields.io/packagist/v/JayBizzle/Safeurl.svg?style=flat-square)](https://packagist.org/packages/jaybizzle/safeurl) [![Total Downloads](https://img.shields.io/packagist/dt/JayBizzle/Safeurl.svg?style=flat-square)](https://packagist.org/packages/jaybizzle/safeurl) [![License](https://img.shields.io/packagist/l/JayBizzle/Safeurl.svg?style=flat-square)](https://packagist.org/packages/jaybizzle/safeurl) [![Build Status](https://img.shields.io/travis/JayBizzle/Safeurl.svg?style=flat-square)](https://travis-ci.org/JayBizzle/Safeurl) [![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/JayBizzle/Safeurl.svg?style=flat-square)](https://scrutinizer-ci.com/g/JayBizzle/Safeurl/?branch=master) [![Laravel](https://img.shields.io/badge/laravel-5.0.*-ff69b4.svg?style=flat-square)](https://laravel.com)

A Laravel 5 package to create safe, SEO friendly urls

For the Laravel 4 version, see the [v0.1 branch](https://github.com/JayBizzle/Safeurl/tree/v0.1)

Installation
============

Run `composer require jaybizzle/safeurl 0.2.*` or add `"jaybizzle/safeurl": "0.2.*"` to your `composer.json` file
For Laravel 5 or higher `composer require jaybizzle/safeurl 0.3.*`

Add the following to the `providers` array in your `config/app.php` file..

```PHP
  'Jaybizzle\Safeurl\SafeurlServiceProvider',
```

...and the following to your `aliases` array...

```PHP
  'Safeurl'           => 'Jaybizzle\Safeurl\Facades\Safeurl',
```

For Laravel 5 or higher

Add the following to the `providers` array in your `config/app.php` file..

```PHP
  Jaybizzle\Safeurl\SafeurlServiceProvider::class,
```

...and the following to your `aliases` array...

```PHP
  'Safeurl' => Jaybizzle\Safeurl\Facades\Safeurl::class,

Usage
==================

```PHP
echo Safeurl::make('The quick brown fox jumps over the lazy dog');

// Output: the-quick-brown-fox-jumps-over-the-lazy-dog
```

Options
==================

These are the default global options. If you want to define your own global options, publish the config with `php artisan vendor:publish --provider="Jaybizzle\Safeurl\SafeurlServiceProvider"` and change the settings in `config/safeurl.php`.

Options can be individually overridden on each call to `Safeurl::make(string, options)`

```PHP
array(

    'decode'            => true,        // Decode html entities in string?
    'decode_charset'    => 'UTF-8',     // Charset to use if $decode is set to true
    'lowercase'         => true,        // Turns string into all lowercase letters
    'strip'             => true,        // Strip out html tags from string?
    'maxlength'         => 50,          // Maximum length of resulting title
    'whole_word'        => true,        // If maxlength is reached, chop at nearest whole word? or hard chop?
    'blank'             => 'no-title',  // What title to use if no alphanumeric characters can be found
    'separator'         => '-',         // Allow a differnt character to be used as the separator.
    
    // A table of UTF-8 characters and what to make them.
    'translation_table' => array(
        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj','Ð'=>'Dj','đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', 'ē'=>'e',
        /**
         * Special characters:
         */
        "'"    => '',       // Single quote
        '&'    => ' and ',  // Ampersand
        "\r\n" => ' ',      // Newline
        "\n"   => ' '       // Newline
    )
    
);
```

Examples
==================

```PHP
echo Safeurl::make('The quick brown fox jumps over the lazy dog', array('maxlength' => 18));

// Output: the-quick-brown
// ** Notice output is only 15 characters event though we specified 18 because we don't want to truncate mid word **
```

```PHP
echo Safeurl::make('The quick brown fox jumps over the lazy dog', array('maxlength' => 18, 'whole_word' => false));

// Output: the-quick-brown-fo
// ** Notice output is now exactly 18 characters **
```

