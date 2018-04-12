<?php

namespace Jaybizzle\Safeurl;

class Safeurl
{
    public $decode;             // Decode html entities in string?
    public $decode_charset;     // Charset to use if $decode is set to true
    public $lowercase;          // Turns string into all lowercase letters
    public $strip;              // Strip out html tags from string?
    public $maxlength;          // Maximum length of resulting title
    public $whole_word;         // If maxlength is reached, chop at nearest whole word? or hard chop?
    public $blank;              // What title to use if no alphanumeric characters can be found
    public $separator;          // Allow a differnt character to be used as the separator.
    public $translation_table;  // A table of UTF-8 characters and what to make them.

    /**
     * Class constructor.
     */
    public function __construct()
    {

        // setup the default options
        $default = config('safeurl');

        foreach ($default as $property => $value) {
            $this->$property = $value;
        }
    }

    /**
     * the worker method.
     *
     * @param string $text
     *
     * @return string
     */
    public function make($text, $options = null)
    {
        $this->setUserOptions($options);  // set user defined options

        $text = $this->decode($text);  // decode UTF-8 chars

        $text = trim($text);  // trim

        $text = $this->lower($text);  // convert to lowercase

        $text = $this->strip($text);  // strip HTML

        $text = $this->filter($text);  // filter the input

        //chop?
        if (strlen($text) > $this->maxlength) {
            $text = substr($text, 0, $this->maxlength);

            if ($this->whole_word) {
                /*
                 * If maxlength is small and leaves us with only part of one
                 * word ignore the "whole_word" filtering.
                 */
                $words = explode($this->separator, $text);
                $temp = implode($this->separator, array_diff($words, array(array_pop($words))));
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

    /**
     * Set user defined options.
     *
     * @param array $options
     */
    private function setUserOptions($options)
    {
        if (is_array($options)) {
            foreach ($options as $property => $value) {
                $this->$property = $value;
            }
        }
    }

    /**
     * Helper method that uses the translation table to convert
     * non-ascii characters to a resonalbe alternative.
     *
     * @param string $text
     *
     * @return string
     */
    public function convertCharacters($text)
    {
        $text = html_entity_decode($text, ENT_QUOTES, $this->decode_charset);
        $text = strtr($text, $this->translation_table);

        return $text;
    }

    /**
     * Decode HTML entities and UTF-8 characters.
     *
     * @param string $text
     *
     * @return string
     */
    private function decode($text)
    {
        return ($this->decode) ? $this->convertCharacters($text) : $text;
    }

    /**
     * Convert string to lowercase.
     *
     * @param string $text
     *
     * @return string
     */
    private function lower($text)
    {
        return ($this->lowercase) ? strtolower($text) : $text;
    }

    /**
     * Strip HTML tages.
     *
     * @param string $text
     *
     * @return string
     */
    private function strip($text)
    {
        return ($this->strip) ? strip_tags($text) : $text;
    }

    /**
     * Strip anything that isn't alphanumeric or an underscore.
     *
     * @param string $text
     *
     * @return string
     */
    private function filter($text)
    {
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
