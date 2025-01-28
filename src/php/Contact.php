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
            echo $config[$flag->name];
        }
        return true;
    }

}

?>
