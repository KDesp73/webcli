<?php

require_once 'Flag.php';

abstract class Command {
    public string $name; 
    public array $flags;
    public string $help;

    function appendFlag(Flag $flag): void
    {
        $this->flags[$flag->name] = $flag;
    }

    function getFlag(?string $n) : ?Flag
    {
        if($n == null) return null;

        foreach($this->flags as $name => $flag) {
            if($flag->getFlag() == $n) return $flag;
        }

        return null;
    }

    /**
     * @param array<int,mixed> $tokens
     */
    abstract function run(array $tokens): bool;
}

?>
