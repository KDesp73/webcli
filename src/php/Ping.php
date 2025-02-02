<?php 

require_once 'Command.php';


class Ping extends Command {
    public function __construct()
    {
        parent::__construct("ping", "Ping the server");
    }

    public function run(array $tokens): bool
    {
        echo "pong";
        return true;
    }

}

?>
