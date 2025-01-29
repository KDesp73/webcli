<?php 
require_once 'Command.php';

class About extends Command {
    public function __construct()
    {
        $this->name = "about";
        $this->help = "Learn things about me";

        $this->appendFlag(new Flag("help", FlagType::Long));
        $this->appendFlag(new Flag("help", FlagType::Short));
    }

    public function run(array $tokens): bool
    {
        if(sizeof($tokens) <= 1){
            $output = "I am a software engineer passionate about creating interactive and user-friendly applications.";
            echo $output;
        } else {
            $flag = $this->getFlag($tokens[1]);
            if($flag == null) {
                Cli::error("Invalid flag `" . $tokens[1] . "`");
                return false;
            }

            if($flag->name == "help"){
                echo $this->help();
            }
        }


        return true;
    }

}
?>
