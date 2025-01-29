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
        $output = "Skills:<br>";
        $output .= "- PHP<br>";
        $output .= "- JavaScript<br>";
        $output .= "- C<br>";
        $output .= "- HTML/CSS<br>";
        $output .= "- Java";
        echo $output;
        return true;
    }

}
?>

