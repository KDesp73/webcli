<?php



namespace app\commands;

use app\core\Command;
use app\core\Metadata;

class Help extends Command {
    public array $commands;

    /**
     * @param array<int,mixed> $commands
     */
    public function __construct()
    {
        parent::__construct("help", "Prints this message");
    }

    /**
     * @param array<int,mixed> $commands
     */
    public function setCommands(array $commands): void
    {
        $this->commands = $commands;
    }

    public function run(array $tokens): Metadata
    {
        $commandFlags = array($this->name);
        foreach ($this->commands as $name => $command) {
            $commandFlags[] = $name;
        }

        $maxLength = max(array_map('strlen', $commandFlags));
        $gap = 4;

        $output = "Available commands:<br>";

        $output .= "&nbsp;&nbsp;" . str_replace(" ", "&nbsp;", str_pad($this->name, $maxLength + $gap)) . $this->help . "<br>";

        foreach ($this->commands as $name => $command) {
            if ($command->include) {
                $output .= "&nbsp;&nbsp;" . str_replace(" ", "&nbsp;", str_pad($name, $maxLength + $gap)) . $command->help . "<br>";
            }
        }

        echo $output;
        return Metadata::success();
    }
}

?>
