<?php 
require_once 'Command.php';

class Skills extends Command {
    public function __construct()
    {
        $this->name = "skills";
        $this->help = "Check what I can do";
    }

    public function run(array $tokens): bool
    {
        $output = "Skills:<br>- PHP<br>- JavaScript<br>- React<br>- HTML/CSS<br>- SQL";
        echo $output;
    }

}
?>

