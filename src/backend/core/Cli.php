<?php 
namespace app\core;

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
            return;
        }
        $this->commands[$command->name] = $command;
    }

    public function finish(): void {
        $this->help = new \app\commands\Help();
        $this->help->setCommands($this->commands);
        $this->commands[$this->help->name] = $this->help;
        return;
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
    /**
     * @return array 
     */
    private function tokenize(string $input): array
    {
        $tokens = [];
        $length = strlen($input);
        $i = 0;

        while ($i < $length) {
            // Skip whitespace
            while ($i < $length && ctype_space($input[$i])) {
                $i++;
            }

            if ($i >= $length) break;

            $token = '';

            // Handle quoted strings
            if ($input[$i] === '"' || $input[$i] === "'") {
                $quote = $input[$i++];
                while ($i < $length && $input[$i] !== $quote) {
                    $token .= $input[$i++];
                }
                if ($i < $length) $i++; // Skip closing quote
                $tokens[] = $token;
                continue;
            }

            // Handle tokens and key=value format
            $assign = false;
            while ($i < $length && !ctype_space($input[$i])) {
                if ($input[$i] === '=') {
                    // Store key
                    if ($token !== '') {
                        $tokens[] = $token;
                    }
                    $token = ''; // Reset for value
                    $i++; // Skip '='

                    // Handle quoted value after `=`
                    if ($i < $length && ($input[$i] === '"' || $input[$i] === "'")) {
                        $quote = $input[$i++];
                        while ($i < $length && $input[$i] !== $quote) {
                            $token .= $input[$i++];
                        }
                        if ($i < $length) $i++; // Skip closing quote
                    } else {
                        // Handle unquoted values
                        while ($i < $length && !ctype_space($input[$i])) {
                            $token .= $input[$i++];
                        }
                    }
                    $tokens[] = $token;
                    $assign = true;
                    continue; // Prevent re-adding the value
                }
                $token .= $input[$i++];
            }

            if (!$assign && $token !== '') {
                $tokens[] = $token;
            }
        }

        return $tokens;
    }

    public function execute(string $input): Metadata
    {
        if($input == null || strlen($input) == 0) return Metadata::failure("No input provided");
        $tokens = $this->tokenize($input);
        if(sizeof($tokens) == 0) return Metadata::failure("Tokenizer failed");
        $command = $this->get($tokens[0]);

        if($command != null) {
            return $command->run($tokens);
        } else {
            if(empty($tokens[0])) return Metadata::failure(message: "No first token found");
            switch ($tokens[0]) {
            case 'help':
                return $this->help->run($tokens);
            default:
                return Cli::error("Command `" . $tokens[0] . "` not found. Type 'help' for a list of available commands.");
            }
        }
    }

    public static function error(string $msg): Metadata
    {
        echo "<p class=\"error\">" . $msg . "</p>";

        return Metadata::failure($msg);
    }

    public static function note(string $msg): void
    {
        echo "<p class=\"note\">" . $msg . "</p>";
    }
}
?>
