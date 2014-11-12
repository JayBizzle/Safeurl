<?php namespace Jaybizzle\Safeurl;

use Illuminate\Support\Facades\Config;

class Safeurl {
	
    public $decode;
    public $decode_charset;
    public $lowercase;
    public $strip;
    public $maxlength;
    public $whole_word;
    public $blank;
    public $separator;
    public $translation_table;

	/**
     * Class constructor
     *
     * @param array $options
     */
    public function __construct() {

    	// setup the default options
    	$default = Config::get('safeurl::config');

    	foreach($default as $property => $value) {
    		$this->$property = $value;
    	}

    }

    public function setUserOptions($options) {
		// setup any custom options
        if (is_array($options)) {
            foreach($options as $property => $value) {
                $this->$property = $value;
            }
        }
    }

    /**
     * Helper method that uses the translation table to convert 
     * non-ascii characters to a resonalbe alternative.
     *
     * @param string $text
     * @return string
     */
    public function convertCharacters($text) {
        $text = html_entity_decode($text, ENT_QUOTES, $this->decode_charset);
        $text = strtr($text, $this->translation_table);
        return $text;
    }

    /**
     * the worker function
     *
     * @param string $text
     * @return string
     */
    public function make($text, $options = null) {

    	if(!is_null($options)) {
    		$this->setUserOptions($options);
    	}

        //Shortcut
        $s = $this->separator;

        //prepare the string according to our options
        if ($this->decode) {
            $text = $this->convertCharacters($text);
        }

        $text = trim($text);

        if ($this->lowercase) {
            $text = strtolower($text);
        }
        if ($this->strip) {
            $text = strip_tags($text);
        }

        //filter
        $text = preg_replace("/[^&a-z0-9-_\s']/i", '', $text);
        $text = str_replace(' ', $s, $text);
        $text = trim(preg_replace("/{$s}{2,}/", $s, $text), $s);

        //chop?
        if (strlen($text) > $this->maxlength) {
            $text = substr($text, 0, $this->maxlength);

            if ($this->whole_word) {
                /**
                 * If maxlength is small and leaves us with only part of one
                 * word ignore the "whole_word" filtering.
                 */
                $words = explode($s, $text);
                $temp  = implode($s, array_diff($words, array(array_pop($words))));
                if ($temp != '') {
                    $text = $temp;
                }
            }

            $text = rtrim($text, $s); // remove any trailing separators
        }
        //return =]
        if ($text == '') {
            return null;
        }

        return $text;
    }

}

/*
 * Thanks to timemachine3030 for the idea/implementation for this class.
 * https://github.com/timemachine3030
 */
