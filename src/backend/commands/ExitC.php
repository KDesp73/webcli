<?php
namespace app\commands;

use app\core\Command;
use app\core\Flag;
use app\core\FlagType;
use app\core\Metadata;

class ExitC extends Command {
    public function __construct()
    {
        parent::__construct("exit", "Exit the site");

        $this->appendFlag(new Flag("help", FlagType::Short));
        $this->appendFlag(new Flag("help", FlagType::Long));
    }


    public function run(array $tokens): Metadata
    {
        echo "Are you sure? Press Ctrl+W to confirm.";

        return Metadata::success();
    }
}

?>


