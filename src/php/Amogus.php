<?php 

require_once 'Command.php';

class Amogus extends Command {
    public function __construct() 
    {
        $this->name = "amogus";
        $this->help = "Surprise";
        $this->include = false;
    }

    public function run(array $tokens): bool
    {
        echo "ඞ";
        return true;
    }
    
}

?>
