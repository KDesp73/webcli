<?php 

require_once 'Command.php';

class Amogus extends Command {
    public function __construct() 
    {
        parent::__construct("amogus", "Surprise");
        $this->include = false;
    }

    public function run(array $tokens): bool
    {
        echo "ඞ";
        return true;
    }
    
}

?>
