<?php 

require_once 'Command.php';

class Tokens extends Command {
    public function __construct()
    {
        parent::__construct("tokens", "Run the tokenizer");
        $this->include = false;
    }

    public function run(array $tokens): bool
    {
        if(sizeof($tokens) <= 1) return false;

        foreach($tokens as $i => $token){
            if($i == 0) continue;
            echo $token . "<br>";
        }

        return true;
    }
}

