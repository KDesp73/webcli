<?php 

require_once 'Command.php';
require_once 'Metadata.php';

class Amogus extends Command {
    public function __construct() 
    {
        parent::__construct("amogus", "Surprise");
        $this->include = false;
    }

    public function run(array $tokens): Metadata
    {
        echo "ඞ";
        return Metadata::success();
    }
    
}

?>
