<?php
namespace Maaa16\Textfilter;

/**
 * Test cases for class Textfilter.
 */
class TextfilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test case nl2br - <br />
     */
    public function testNl2br()
    {
        $textfilter = new \Maaa16\Textfilter\Textfilter();
        $text = "\n";
        $this->assertEquals("<br />", $textfilter->doFilter($text, 'nl2br'));
        $text = "\n\n";
        $this->assertEquals("<br /><br />", $textfilter->doFilter($text, 'nl2br'));
    }

    /**
     * Test case bbcode - < > url img
     */
    public function testBbcode()
    {
        $textfilter = new \Maaa16\Textfilter\Textfilter();
        $text = "[";
        $this->assertEquals("<", $textfilter->doFilter($text, 'bbcode'));
        $text = "]";
        $this->assertEquals(">", $textfilter->doFilter($text, 'bbcode'));
        $text = "[b]fet[/b]";
        $this->assertEquals("<b>fet</b>", $textfilter->doFilter($text, 'bbcode'));
        $text = "[i]kursiv[/i]";
        $this->assertEquals("<i>kursiv</i>", $textfilter->doFilter($text, 'bbcode'));
        $text = "[url=http://www.dn.se]dn[/url]";
        $this->assertEquals("<a href='http://www.dn.se'>dn</a>", $textfilter->doFilter($text, 'bbcode'));
        $text = "[url]http://www.dn.se[/url]";
        $this->assertEquals("<a href='http://www.dn.se'>http://www.dn.se</a>", $textfilter->doFilter($text, 'bbcode'));
        $text = "[img]https://www.bbcode.org/images/lubeck_small.jpg[/img]";
        $this->assertEquals("<img src='https://www.bbcode.org/images/lubeck_small.jpg' />", $textfilter->doFilter($text, 'bbcode'));
        $text = "[img=100x50]https://www.bbcode.org/images/lubeck_small.jpg[/img]";
        $this->assertEquals("<img src='https://www.bbcode.org/images/lubeck_small.jpg' width='100' height='50' />", $textfilter->doFilter($text, 'bbcode'));
    }

    /**
     * Test case link - <a href='link'>link</a>
     */
    public function testLink()
    {
        $textfilter = new \Maaa16\Textfilter\Textfilter();
        $text = "http://www.dn.se";
        $this->assertEquals("<a href='http://www.dn.se'>http://www.dn.se</a>", $textfilter->doFilter($text, 'link'));
    }


    /**
     * Test case markdown - * # -- \n
     */
    public function testMarkdown()
    {
        $textfilter = new \Maaa16\Textfilter\Textfilter();
        $text = "* item1\n* item2";
        $this->assertEquals("<ul>\n<li>item1</li>\n<li>item2</li>\n</ul>\n", $textfilter->doFilter($text, 'markdown'));
        $text = "#rubrik-h1";
        $this->assertEquals("<h1>rubrik-h1</h1>\n", $textfilter->doFilter($text, 'markdown'));
        $text = "rubrik-h1\n=========";
        $this->assertEquals("<h1>rubrik-h1</h1>\n", $textfilter->doFilter($text, 'markdown'));
        $text = "##rubrik-h2";
        $this->assertEquals("<h2>rubrik-h2</h2>\n", $textfilter->doFilter($text, 'markdown'));
    }
}
