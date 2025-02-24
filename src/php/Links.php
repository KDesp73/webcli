<?php 

require_once 'Command.php';
require_once 'Flag.php';
require_once 'helpers.php';

class Links extends Command {
    private array $links;

    public function __construct()
    {
        parent::__construct("links", "Print useful links");
        $this->include = false;

        $this->links["Docs"] = "https://kdesp73.github.io/Docs/";
        $this->links["DataBridge Docs"] = "https://kdesp73.github.io/DataBridge";
        $this->links["iee-api"] = "https://iee-api-nine.vercel.app/";
    }

    public function run(array $tokens): bool
    {
        $output = "";
        foreach($this->links as $title => $link) {
            $output .= "- " . anchor($link, $title) . "<br>";
        }
        echo $output;
        
        return true;
    }
}

?>
