<?php 
namespace app\commands;

use app\core\Command;
use app\core\Metadata;

class Ping extends Command {
    public function __construct()
    {
        parent::__construct("ping", "Ping the server");
    }

    public function run(array $tokens): Metadata 
    {
        echo "pong";
        return Metadata::success();
    }

}

?>
