<?php 

require_once 'Command.php';
require_once 'Metadata.php';

class Tokens extends Command {
    public function __construct()
    {
        parent::__construct("tokens", "Run the tokenizer");
        $this->include = false;
    }

    public function run(array $tokens): Metadata
    {
        if(sizeof($tokens) <= 1) return Metadata::failure("Provide tokens");

        foreach($tokens as $i => $token){
            if($i == 0) continue;
            echo $token . "<br>";
        }

        return Metadata::success();
    }
}

