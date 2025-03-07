<?php

require_once 'Flag.php';
require_once 'Command.php';
require_once 'helpers.php';

class Contact extends Command {
    public function __construct()
    {
        parent::__construct("contact", "Reach out to me");

        $this->appendFlag(new Flag("email" , FlagType::Long));
        $this->appendFlag(new Flag("github", FlagType::Long));
        $this->appendFlag(new Flag("help", FlagType::Short));
        $this->appendFlag(new Flag("help", FlagType::Long));
    }

    private function defaultResponse($config): string 
    {
        $output = "Reach me at<br>";
        if($config['email']){
            $output .= "- Email: " . mailto($config['email']) . "<br>";
        }
        if($config['github']) {
            $output .= "- Github: " . anchor($config['github']) . "<br>";
        }

        return $output;
    }

    public function run(array $tokens): bool
    {
        if($tokens[0] != $this->name) return false;

        $config = parseJson("../config.json");
        if(!$config) {
            Cli::error("Could not parse config.json");
            return false;
        }

        
        if(sizeof($tokens) <= 1){
            echo $this->defaultResponse($config);
        } else {
            $flag = $this->getFlag($tokens[1]);
            $link = $config[$flag->name];

            if($flag == null) {
                Cli::error("Invalid flag `" . $tokens[1] . "`");
                return false;
            }

            switch($flag->name){
            case "email":
                echo mailto($link);
                break;
            case "help":
                echo $this->help();
                break;
            case "github":
                echo anchor($link);
                break;
            }
        }
        return true;
    }

}

?>
