<?php 
namespace app\commands;

use app\core\Command;
use app\core\Metadata;

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
