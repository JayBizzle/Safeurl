Safeurl
=======
[![Latest Stable Version](https://poser.pugx.org/jaybizzle/safeurl/v/stable.svg)](https://packagist.org/packages/jaybizzle/safeurl) [![Total Downloads](https://poser.pugx.org/jaybizzle/safeurl/downloads.svg)](https://packagist.org/packages/jaybizzle/safeurl) [![Latest Unstable Version](https://poser.pugx.org/jaybizzle/safeurl/v/unstable.svg)](https://packagist.org/packages/jaybizzle/safeurl) [![License](https://poser.pugx.org/jaybizzle/safeurl/license.svg)](https://packagist.org/packages/jaybizzle/safeurl) [![Build Status](https://travis-ci.org/JayBizzle/Safeurl.svg?branch=master)](https://travis-ci.org/JayBizzle/Safeurl)

A Laravel package to create safe, SEO friendly urls

Installation
============

Run `composer require jaybizzle/safeurl 0.1.*` or add `"jaybizzle/safeurl": "0.1.*"` to your `composer.json` file

Add the following to the `providers` array in your `app/config/app.php` file..

```PHP
  'Jaybizzle\Safeurl\SafeurlServiceProvider',
```

...and the following to your `aliases` array...

```PHP
  'Safeurl'           => 'Jaybizzle\Safeurl\Facades\Safeurl',
```

Usage
==================

```PHP
echo Safeurl::make('The quick brown fox jumps over the lazy dog');

// Output: the-quick-brown-fox-jumps-over-the-lazy-dog
```

Options
==================

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
        '&'    => ' and ',  // Amperstand
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

