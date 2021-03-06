<?php
namespace Maaa16\Navbar;

class Navbar implements \Anax\Common\ConfigureInterface
{
    use \Anax\Common\ConfigureTrait;

    /**
     * Set the app object to inject into view rendering phase.
     *
     * @param object $app with framework resources.
     *
     * @return $this
     */
    public function setApp($app)
    {
        $this->app = $app;
        return $this;
    }

    /**
     * Set default values from configuration.
     *
     * @return this.
     */
    public function setDefaultsFromConfiguration()
    {
        $this->navbar = $this->config['navbar'];
        return $this;
    }

    /**
     * Genereate links in navbar
     *
     * @param string $itemkey from item in configfile
     * @param string $navhtml the generated navbar, so far.
     * @param array $link with route and text for the links
     * @param string $class info about the class for the links
     * @return string $navhtml generated now with items (links).
     */
    public function generateLinks($itemkey, $navhtml, $link, $class)
    {
        if ($itemkey != 'login' && $itemkey != 'logout') {
            // Med undantag för login och logout visa de länkarna utan förbehåll.
            $navhtml .= "<li><a class='{$class}' href='". $this->app->url->create($link['route']) ."'>".$link['text']."</a></li>";
        } else {
            if ($itemkey == 'login' && !$this->app->session->has('user')) {
                // Om man kommer till login och man inte är inloggad redan så visa den länken
                $navhtml .= "<li style='float: right'><a class='{$class}' href='". $this->app->url->create($link['route']) ."'>".$link['text']."</a></li>";
            } else if ($itemkey == 'logout' && $this->app->session->has('user')) {
                // Om man kommer till logout och man är inloggad så visa den knappen
                $navhtml .= "<li style='float: right'><a class='{$class}' href='". $this->app->url->create($link['route']) ."'>".$link['text']."</a></li>";

                // För att se om accountinfo är aktiv eller inte kontrolleras route via PATH_INFO¨.
                $accountclass = ((isset($_SERVER['PATH_INFO'])) && $_SERVER['PATH_INFO'] == "/accountinfo") ? "navactive" : "notnavacitve";
                $navhtml .= "<li style='float: right'><a class='{$accountclass}' href='". $this->app->url->create('accountinfo') ."'>". $this->app->cookie->get('forname', "") ."</a></li>";
            }
        }
        return $navhtml;
    }

    /**
     * Genereate dropdown in navbar
     *
     * @param string $navhtml the generated navbar, so far.
     * @param string $active what link is active.
     * @return string $navhtml generated now with dropdownmenu.
     */
    public function generateDropdown($navhtml, $active)
    {
        foreach ($this->navbar as $key => $value) {
            if ($key == "dropdown") {
                $navhtml .= "<li class='dropdown'>";
                /*
                * Är det är en dropdown kollar man först efter $dropkey == namn för att sätta namn på dropdownmenyn
                * därefter $dropkey == items för att sätta ut länkarna i menyn.
                */
                foreach ($value as $dropkey => $link) {
                    if ($dropkey == "namn") {   //sätter ut namnet på dropdownmenyn
                        // echo $link;
                        $class = ($active == "dropdown") ? "dropdown-toggle navactive" : "dropdown-toggle notnavacitve";
                        $navhtml .= "<a href='#' class='{$class}' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>". $link ." <span class='caret'></span></a>";
                        $navhtml .= "<ul class='dropdown-menu'>";
                    } else if ($dropkey == "items") {    //sätter ut länkarna i dropdownmenyn
                        foreach ($link as $droplink) {
                            $navhtml .= "<li><a class='dropdownlink' href='". $this->app->url->create($droplink['route']) ."' style='color: white;'>".$droplink['text']."</a></li>";
                        }
                    }
                }
            }
        }
        $navhtml .= "</ul>";
        $navhtml .= "</li>";

        return $navhtml;
    }

    /**
     * Get HTML for the navbar.
     *
     * @param string $active what link is active
     * @return string as HTML with the navbar.
     */
    public function generateNavbar($active)
    {
        foreach ($this->navbar as $key => $value) {
            // echo $key;
            if ($key == "config") {
                foreach ($value as $class) {
                    $navhtml = "<ul class='". $class ."'>";
                }
            } else if ($key == "items") {
                foreach ($value as $itemkey => $link) {
                    // echo "[" . $itemkey . " => " . $link . "]";
                    $itemkey;
                    $class = ($active == $link['route']) ? "navactive" : "notnavacitve";
                    $class = $class . " " . $link['class'];
                    $navhtml = $this->generateLinks($itemkey, $navhtml, $link, $class);
                }
            } else if ($key == "dropdown") {
                $navhtml = $this->generateDropdown($navhtml, $active);
            }
        }

        return $navhtml;
    }
}
