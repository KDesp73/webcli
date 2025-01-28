<?php 

require_once 'Command.php';


class Ping extends Command {
    public function __construct()
    {
        $this->name = "ping";
        $this->help = "Ping the server";
    }

    public function run(array $tokens): bool
    {
        echo "pong";
        return true;
    }

}

?>
