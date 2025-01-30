<?php

require_once 'Flag.php';

class Command {
    public string $name; 
    public array $flags;
    public string $help;
    public bool $include = true;

    public function __construct(string $name, string $help)
    {
        $this->name = $name;
        $this->help = $help;
    }

    function appendFlag(Flag $flag): void
    {
        $this->flags[$flag->getFlag()] = $flag;
    }

    function getFlag(?string $n) : ?Flag
    {
        if($n == null) return null;

        return $this->flags[$n];
    }

    protected function help(): string {
        $output = bold("USAGE") . "<br>";
        $output .= "&nbsp;&nbsp;" . $this->name . " [OPTIONS]<br><br>";
        $output .= bold("OPTIONS") . "<br>";
        foreach($this->flags as $name => $f) {
            $output .= "&nbsp;&nbsp;" . $name . "<br>";
        }
        
        return $output;
    }

    /**
     * @param array<int,mixed> $tokens
     */
    function run(array $tokens): bool
    {
        return true;
    }
}

?>
