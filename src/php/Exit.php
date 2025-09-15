<?php

require_once 'Flag.php';
require_once 'Command.php';
require_once 'Metadata.php';
require_once 'helpers.php';

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


