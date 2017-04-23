<?php
namespace Maaa16\Block;

class Block
{
    public function getBlock($blockslug)
    {
        $blockdata = "";
        $filteredblockdata = "";
        $textfilter = new \Maaa16\Textfilter\Textfilter();
        if ($blockslug != '') {
            $this->app->database->connect();
            $sql = "SELECT data, filter FROM content WHERE status = ? AND type = ? AND slug = ?";
            if ($res = $this->app->database->executeFetchAll($sql, ['Published', 'block', $blockslug])) {
                foreach ($res as $row) {
                    $blockdata = $row->data;
                    $blockfilter = $row->filter;
                }
                $filteredblockdata =  $textfilter->doFilter($blockdata, $blockfilter);
            }
        }

        return $filteredblockdata;
    }

    public function setApp($app)
    {
        $this->app = $app;
        return $this;
    }
}
