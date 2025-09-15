<?php 

require_once 'Command.php';
require_once 'Metadata.php';


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
