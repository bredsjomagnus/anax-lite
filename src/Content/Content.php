<?php
namespace Maaa16\Content;

class Content
{
    /**
     * Create a slug of a string, to be used as url.
     *
     * @param string $str the string to format as slug.
     *
     * @return str the formatted slug.
     */
    public function slugify($str)
    {
        $str = mb_strtolower(trim($str));
        $str = str_replace(array('å','ä','ö'), array('a','a','o'), $str);
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = trim(preg_replace('/-+/', '-', $str), '-');
        return $str;
    }

    public function makeSlugUnique($app, $sluglength, $slug, $id)
    {
        $counter = 2;

        $app->database->connect();
        $sql = "SELECT id, slug FROM content WHERE slug = ? AND NOT id = ?";
        while ($app->database->executeFetchAll($sql, [$slug, $id])) {
            if (strlen($slug) == $sluglength) {
                $slug = $slug ."-".$counter."";
            } else {
                $slug = substr($slug, 0, $sluglength);
                $slug = $slug ."-".$counter."";
            }
            $counter += 1;
        }

        return $slug;
    }

    public function checkPath($app, $path, $id)
    {
        $sql = "SELECT path FROM content WHERE path = ? AND NOT id = ?";
        if ($app->database->executeFetchAll($sql, [$path, $id])) {
            $path = null;
        }

        return $path;
    }

    public function getFilters($markdown, $bbcode, $link, $nl2br)
    {
        $bloggarray = [];
        if ($markdown) {
            $bloggarray[] = 'markdown';
        }
        if ($bbcode) {
            $bloggarray[] = 'bbcode';
        }
        if ($link) {
            $bloggarray[] = 'link';
        }
        if ($nl2br) {
            $bloggarray[] = 'nl2br';
        }

        $blogfilter = implode(",", $bloggarray);

        return $blogfilter;
    }
}
