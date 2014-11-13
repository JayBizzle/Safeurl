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

    /**
     * the worker function
     *
     * @param string $text
     * @return string
     */
    public function make($text, $options = null) {

    	$this->setUserOptions($options); // set user defined options

        $text = $this->decode($text);   // decode UTF-8 chars

        $text = trim($text);  // trim

        $text = $this->lower($text); // convert to lowercase
        
        $text = $this->strip($text); // strip HTML

        $text = $this->filter($text); // filter the input

        //chop?
        if (strlen($text) > $this->maxlength) {
            $text = substr($text, 0, $this->maxlength);

            if ($this->whole_word) {
                /**
                 * If maxlength is small and leaves us with only part of one
                 * word ignore the "whole_word" filtering.
                 */
                $words = explode($this->separator, $text);
                $temp  = implode($this->separator, array_diff($words, array(array_pop($words))));
                if ($temp != '') {
                    $text = $temp;
                }
            }

            $text = rtrim($text, $this->separator); // remove any trailing separators
        }
        //return =]
        if ($text == '') {
            return $this->blank;
        }

        return $text;
    }

    private function setUserOptions($options) {
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

    private function decode($text) {
        return ($this->decode) ? $this->convertCharacters($text) : $text;
    }

    private function lower($text) {
        return ($this->lowercase) ? strtolower($text) : $text;
    }

    private function strip($text) {
        return ($this->strip) ? strip_tags($text) : $text;
    }

    private function filter($text) {
        $text = preg_replace("/[^&a-z0-9-_\s']/i", '', $text);
        $text = str_replace(' ', $this->separator, $text);
        $text = trim(preg_replace("/{$this->separator}{2,}/", $this->separator, $text), $this->separator);

        return $text;
    }

}

/*
 * Thanks to timemachine3030 for the idea/implementation for this class.
 * https://github.com/timemachine3030
 */
