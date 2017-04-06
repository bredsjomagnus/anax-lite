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

    public function generateDropdown($navhtml)
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
                        $navhtml .= "<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>". $link ." <span class='caret'></span></a>";
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
     * @return string as HTML with the navbar.
     */
    public function generateNavbar()
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
                        $navhtml .= "<li><a href='". $this->app->url->create($link['route']) ."'>".$link['text']."</a></li>";
                }
            } else if ($key == "dropdown") {
                $navhtml = $this->generateDropdown($navhtml);
                //
                // $navhtml .= "<li class='dropdown'>";
                //
                // /*
                // * Är det är en dropdown kollar man först efter $dropkey == namn för att sätta namn på dropdownmenyn
                // * därefter $dropkey == items för att sätta ut länkarna i menyn.
                // */
                // foreach ($value as $dropkey => $link) {
                //     if ($dropkey == "namn") {   //sätter ut namnet på dropdownmenyn
                //         // echo $link;
                //         $navhtml .= "<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>". $link ." <span class='caret'></span></a>";
                //         $navhtml .= "<ul class='dropdown-menu'>";
                //     } else if ($dropkey == "items") {    //sätter ut länkarna i dropdownmenyn
                //         foreach ($link as $droplink) {
                //             $navhtml .= "<li><a class='dropdownlink' href='". $this->app->url->create($droplink['route']) ."' style='color: white;'>".$droplink['text']."</a></li>";
                //         }
                //     }
                // }
                // $navhtml .= "</ul>";
                // $navhtml .= "</li>";
            }
        }

        return $navhtml;
    }
}
