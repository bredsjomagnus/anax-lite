<?php
namespace Maaa16\Textfilter;

class Textfilter
{
    /**
    * Works like a router. Redirecting depending on filter/s
    *
    * @param string $text that is to be filtered
    * @param string $filterstring in form filter1,filter2,filter3,...
    * @return string $text filtered text.
    */
    public function doFilter($text, $filterstring)
    {
        $text = strip_tags($text);
        $filterarray = explode(",", $filterstring);
        foreach ($filterarray as $filter) {
            if ($filter == 'nl2br') {
                $text = $this->nl2br($text);
            }
            if ($filter == 'bbcode') {
                $text = $this->bbcode($text);
            }
            if ($filter == 'link') {
                $text = $this->makeClickable($text);
            }
            if ($filter == 'markdown') {
                $text = self::markdown($text);
            }
        }

        return $text;

    }
    /**
    * nl2br filter - making linebreaks in $text
    *
    * @param string $text that is to be filterad
    * @return string filterad text
    */
    private function nl2br($text)
    {
        return preg_replace(['/[\n]{1}/','/\n+\n/'], ['<br />','<br /><br />'], $text);
    }

    /**
    * bbcode filter - filter text according to bbcode standard
    *
    * @param string $text that is to be filtered
    * @return string filtered text.
    */
    private function bbcode($text)
    {
        $regex = ['/\[url]{1}(.*)(\[\/url])/', '/\[url=(.*)]{1}(.*)(\[\/url])/', '/\[img]{1}(.*)(\[\/img])/', '/\[img=(\d*)x(\d*)](.*)(\[\/img])/', '/[\[]+/', '/[\]]+/'];
        $replaceTo = ["<a href='$1'>$1</a>", "<a href='$1'>$2</a>", "<img src='$1' />", "<img src='$3' width='$1' height='$2' />", '<','>'];
        return preg_replace($regex, $replaceTo, $text);
    }

    /**
     * Make clickable links from URLs in text.
     *
     * @param string $text the text that should be formatted.
     * @return string with formatted anchors.
     */
    private function makeClickable($text)
    {
        return preg_replace_callback(
            '#\b(?<![href|src]=[\'"])https?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#',
            create_function(
                '$matches',
                'return "<a href=\'{$matches[0]}\'>{$matches[0]}</a>";'
            ),
            $text
        );
    }

    /**
     * Helper, Markdown formatting converting to HTML.
     *
     * @param string text The text to be converted.
     *
     * @return string the formatted text.
     */
    public static function markdown($text)
    {
        return \Michelf\Markdown::defaultTransform($text);
    }
}
