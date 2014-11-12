Safeurl
=======
[![Latest Stable Version](https://poser.pugx.org/jaybizzle/safeurl/version.svg)](https://packagist.org/packages/jaybizzle/safeurl) [![Latest Unstable Version](https://poser.pugx.org/jaybizzle/safeurl/v/unstable.svg)](//packagist.org/packages/jaybizzle/safeurl) [![Total Downloads](https://poser.pugx.org/jaybizzle/safeurl/downloads.svg)](https://packagist.org/packages/jaybizzle/safeurl) [![Build Status](https://travis-ci.org/JayBizzle/Safeurl.svg?branch=master)](https://travis-ci.org/JayBizzle/Safeurl)

A Laravel package to create safe, SEO friendly urls

Installation
============

Run `composer require jaybizzle/safeurk 0.1.*` or add `"jaybizzle/safeurl": "0.1.*"` to your `composer.json` file

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

