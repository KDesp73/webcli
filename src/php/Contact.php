<?php

require_once 'Flag.php';
require_once 'Command.php';
require_once 'helpers.php';

class Contact extends Command {
    public function __construct()
    {
        $this->name = "contact";
        $this->help = "Reach out to me";

        $this->appendFlag(new Flag("email" , FlagType::Long));
        $this->appendFlag(new Flag("github", FlagType::Long));
        $this->appendFlag(new Flag("help", FlagType::Short));
        $this->appendFlag(new Flag("help", FlagType::Long));
    }

    public function run(array $tokens): bool
    {
        if($tokens[0] != $this->name) return false;

        $config = parseJson("../config.json");
        if(!$config) return false;

        
        if(sizeof($tokens) <= 1){
            $output = "Reach me at<br>";
            if($config['email']){
                $output .= "- Email: " . mailto($config['email']) . "<br>";
            }
            if($config['github']) {
                $output .= "- Github: " . anchor($config['github']) . "<br>";
            }
            echo $output;
        } else {
            $flag = $this->getFlag($tokens[1]);
            $link = $config[$flag->name];

            if($flag == null) {
                echo "Invalid flag `" . $tokens[1] . "`";
                return false;
            }

            if($flag->name == "email")
                echo mailto($link);
            else if($flag->name == "help"){
                echo bold("USAGE") . "<br>";
                echo "&nbsp;&nbsp;" . $this->name . " [OPTIONS]<br><br>";
                echo bold("OPTIONS") . "<br>";
                foreach($this->flags as $name => $f) {
                    echo "&nbsp;&nbsp;" . $f->getFlag() . "<br>";
                }
            } else if($flag->name == "github")
                echo anchor($link);
        }
        return true;
    }

}

?>
