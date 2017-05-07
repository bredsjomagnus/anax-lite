<?php
namespace Maaa16\Textfilter;

/**
 * Test cases for class Textfilter.
 */
class TextfilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * 
     */
    public function testBbcode()
    {
        $textfilter = new \Maaa16\Textfilter\Textfilter();
        $text = "[b]hej[/b]";
        $this->assertEquals("<b>hej</b>", $textfilter->doFilter($text, 'bbcode'));
    }
}
