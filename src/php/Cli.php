<?php 

require_once 'Command.php';

error_reporting(E_ALL & ~E_WARNING);
class Cli {
    private array $commands;
    public Command $help;

    public function __construct()
    {
        $this->commands = []; 
    }

    public function add(Command $command): void {
        if($command->name == "help") {
            $this->help = $command;
            $this->help->commands = $this->commands;
            return;
        }
        $this->commands[$command->name] = $command;
    }

    public function get(string $name): ?Command
    {
        $c = null;
        try {
            $c = $this->commands[$name];
        } catch(TypeError $e) {
            return null;
        } 

        return $c;
    }

    public function execute(string $input): bool
    {
        $tokens = explode(' ', $input);
        $command = $this->get($tokens[0]);
        
        if($command != null) {
            return $command->run($tokens);
        } else {
            if(empty($tokens[0])) return false;
            switch ($tokens[0]) {
            case 'help':
                return $this->help->run($tokens);
            default:
                echo "Command `" . $tokens[0] . "` not found. Type 'help' for a list of available commands.";
                return false;
            }
        }
    }
}
?>
