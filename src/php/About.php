<?php 
require_once 'Command.php';

class About extends Command {
    public function __construct()
    {
        $this->name = "about";
        $this->help = "Learn things about me";
    }

    public function run(array $tokens): bool
    {
        $output = "I am a web developer passionate about creating interactive and user-friendly websites.";
        echo $output;
    }

}
?>
