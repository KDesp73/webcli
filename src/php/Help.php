<?php


require_once 'Command.php';
// ini_set('display_errors', 'Off');
// ini_set('log_errors', 'On');

class Help extends Command {
    public array $commands;

    /**
     * @param array<int,mixed> $commands
     */
    public function __construct()
    {
        $this->name = "help";
        $this->help = "Prints this message";
    }

    public function run(array $tokens): bool
    {
        $output = "Available commands:<br>";
        $output .= "&nbsp;&nbsp;" . $this->name . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $this->help . "<br>";
        foreach ($this->commands as $name => $command){
            $output .= "&nbsp;&nbsp;" . $name . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $command->help . "<br>";
        }
        echo $output;

        return true;
    }
}

?>
