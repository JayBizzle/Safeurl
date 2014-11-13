<?php

use Jaybizzle\Safeurl\Safeurl;
use Orchestra\Testbench\TestCase;

class QuickTest extends TestCase
{
	protected $safeurl;

	protected function getPackageProviders()
	{
		return array('Jaybizzle\Safeurl\SafeurlServiceProvider');
	}

	public function setUp()
	{
		parent::setUp();
		$this->safeurl = new Safeurl;
	}

	protected function getEnvironmentSetUp($app)
	{
		// reset base path to point to our package's src directory
		$app['path.base'] = __DIR__ . '/../src';
	}



	public function testBasicDefaultSetup()
	{
		$this->assertEquals('the-quick-brown-fox-jumps-over-the-lazy-dog', $this->safeurl->make('The quick brown fox jumps over the lazy dog'));
	}

	public function testCase()
	{
		$this->assertEquals('The-quick-brown-fox-jumps-over-the-lazy-dog', $this->safeurl->make('The quick brown fox jumps over the lazy dog', array('lowercase' => false)));
	}

	public function testSpecialChars()
	{
		$this->assertEquals('th-quck-brown-fox-jumps-over-the-lzy-dog', $this->safeurl->make('Th£ qu|ck brown fox jumps over the l@zy dog!!!*!@£$%^*()+'));
	}

	public function testHTML()
	{
		$this->assertEquals('the-quick-brown-fox-jumps-over-the-lazy-dog', $this->safeurl->make('The <strong>quick</strong> brown fox jumps over the <em>lazy</em> dog'));
	}

	public function testTruncateAtWholeWord()
	{
		$this->assertEquals('the-quick-brown', $this->safeurl->make('The quick brown fox jumps over the lazy dog', array('maxlength' => 18)));
	}

	public function testTruncateAtHardLimit()
	{
		$this->assertEquals('the-quick-brown-fo', $this->safeurl->make('The quick brown fox jumps over the lazy dog', array('maxlength' => 18, 'whole_word' => false)));
	}

	public function testTranslation()
	{
		// We are only testing UTF8 chars here, not the new lines and ampersands etc
		$default = \Config::get('safeurl::config');

		$test = implode(" ", array_keys(array_slice($default['translation_table'], 0, -4)));
		$result = implode("-", array_slice($default['translation_table'], 0, -4));

		$this->assertEquals(strtolower($result), $this->safeurl->make($test, array('maxlength' => 1000)));

	}

	public function testBigMess()
	{
		$big_mess = '
			</span></li><li style=\"\" class=\"li2\"><span style=\"color:
			#ff0000;\">\$safeurl = new safeurl(); </span></li><li style=\"\"
			class=\"li1\"><span style=\"color: #ff0000;\">\$safeurl->lowercase
			= false;</span></li><li style=\"\" class=\"li2\"><span
			style=\"color: #ff0000;\">\$safeurl->whole_word = false;</span></li>
			<li style=\"\" class=\"li1\">&nbsp;</li><li style=\"\"
			class=\"li2\"><span style=\"color: #ff0000;\">\$tests = array(
			</span></li><li style=\"\" class=\"li1\"><span style=\"color:
			#ff0000;\"> &nbsp; &nbsp; &nbsp; &nbsp;\'</span>i\span
			style=\"color: #ff0000;\">\'m a test string!! do u like me. or
			not......., billy bob!!@#\'</span>, </li><li style=\"\"
			class=\"li2\">&nbsp; &nbsp; &nbsp; &nbsp; <span
			style=\"color: #ff0000;\">\'<b>some HTML</b> in <i>here</i>!!~\'
			</span>, </li><li style=\"\" class=\"li1\">&nbsp; &nbsp; &nbsp;
			&nbsp; <span style=\"color: #ff0000;\">\'i!@#*#@ l#*(*(#**$*o**(*^v
			^*(e d//////e<span style=\"color: #000099; font-weight: bold;\">\\
			</span><span style=\"color: #000099; font-weight: bold;\">\\</span>
			<span style=\"color: #000099; font-weight: bold;\">\\</span><span
			style=\"color: #000099; font-weight: bold;\">\\</span>v,,,,,,,,,,n%
			$#@!~e*(+=t\'</span>,</li>';

		$this->assertEquals('safeurl-new-safeurl', $this->safeurl->make($big_mess, array('maxlength' => 20)));

	}

	public function testWholeWordWithOnlyOneWord() 
	{
		$this->assertEquals('super', $this->safeurl->make('supercalafragalisticexpialadoshus', array('maxlength' => 5, 'whole_word' => true)));
	}

	public function testHtmlEntityDecode()
	{
		$safeString = $this->safeurl->make('The quick brown fox jumps over the lazy dog & cat', array('decode' => true, 'maxlength' => 500));
		$this->assertEquals('the-quick-brown-fox-jumps-over-the-lazy-dog-and-cat', $safeString);
	}

	public function testStringWithNoAlphanumChars()
	{
		$safeString = $this->safeurl->make('!@£$%^*()+');
		$this->assertEquals('no-title', $safeString);

		$safeString = $this->safeurl->make('!@£$%^*()+', array('blank' => null));
		$this->assertEquals(null, $safeString);
	}

}