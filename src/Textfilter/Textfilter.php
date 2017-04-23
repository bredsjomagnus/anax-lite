<?php
namespace Maaa16\Textfilter;

class Textfilter
{
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

    private function nl2br($text)
    {
        return preg_replace(['/[\n]{1}/','/\n+\n/'], ['<br />','<br /><br />'], $text);
    }

    private function bbcode($text)
    {
        return preg_replace(['/\[url=(.*)]{1}(.*)(\[\/url])/', '/[\[]+/', '/[\]]+/'], ["<a href='$1'>$2</a>",'<','>'], $text);
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
