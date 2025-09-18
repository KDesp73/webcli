<?php
namespace app\commands;

use app\core\Command;
use app\core\Flag;
use app\core\FlagType;
use app\core\Metadata;
use app\core\Cli;

class Todo extends Command {
    public function __construct()
    {
        parent::__construct(strtolower("Todo"), "View future plans");

        // Example flags
        $this->appendFlag(new Flag("help", FlagType::Long));
        $this->appendFlag(new Flag("help", FlagType::Short));
    }

    public function run(array $tokens): Metadata
    {
        if (count($tokens) <= 1) {
            echo "This is the Todo command.\n";
        } else {
            $flag = $this->getFlag($tokens[1]);
            if ($flag === null) {
                return Cli::error("Invalid flag ");
            }

            if ($flag->name === "help") {
                echo $this->help();
            }
        }

        return Metadata::success();
    }
}
