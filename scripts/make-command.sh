#!/usr/bin/env bash

if [ -z "$1" ]; then
  echo "Usage: ./bin/make-command.sh <CommandName>"
  exit 1
fi

COMMAND_NAME="$1"
CLASS_NAME="$(tr '[:lower:]' '[:upper:]' <<< ${COMMAND_NAME:0:1})${COMMAND_NAME:1}"
FILE_PATH="src/backend/commands/${CLASS_NAME}.php"

if [ -f "$FILE_PATH" ]; then
  echo "Error: Command '${CLASS_NAME}' already exists at $FILE_PATH"
  exit 1
fi

cat > "$FILE_PATH" <<PHP
<?php
namespace app\\commands;

use app\\core\\Command;
use app\\core\\Flag;
use app\\core\\FlagType;
use app\\core\\Metadata;
use app\\core\\Cli;

class ${CLASS_NAME} extends Command {
    public function __construct()
    {
        parent::__construct(strtolower("${CLASS_NAME}"), "Description for ${CLASS_NAME} command");

        // Example flags
        \$this->appendFlag(new Flag("help", FlagType::Long));
        \$this->appendFlag(new Flag("help", FlagType::Short));
    }

    public function run(array \$tokens): Metadata
    {
        if (count(\$tokens) <= 1) {
            echo "This is the ${CLASS_NAME} command.\\n";
        } else {
            \$flag = \$this->getFlag(\$tokens[1]);
            if (\$flag === null) {
                return Cli::error("Invalid flag `{\$tokens[1]}`");
            }

            if (\$flag->name === "help") {
                echo \$this->help();
            }
        }

        return Metadata::success();
    }
}
PHP

echo "Created command: $FILE_PATH"
