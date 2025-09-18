<?php 
namespace app\commands;

use app\core\Command;
use app\core\Flag;
use app\core\FlagType;
use app\core\Metadata;
use app\core\Cli;
use app\core\Helpers;

class Skills extends Command {
    private array $skills;
    public function __construct()
    {
        parent::__construct("skills", "Check what I can do");

        $this->appendFlag(new Flag("help", FlagType::Short));
        $this->appendFlag(new Flag("help", FlagType::Long));
        $this->appendFlag(new Flag("json", FlagType::Long));

        $filePath = dirname(__DIR__, 2) . '/data/skills.json';
        if (!file_exists($filePath)) {
            throw new \RuntimeException("Projects data file not found at: {$filePath}");
        }
        $jsonData = file_get_contents($filePath);
        $this->skills = json_decode($jsonData, true);
    }

    private function defaultResponse(): void {
        $maxLength = max(array_map('strlen', array_keys($this->skills)));
        $gap = 2;

        $output = "";
        foreach($this->skills as $name => $percentage) {
            $output .= "- " . str_replace(" ", "&nbsp;", str_pad($name, $maxLength + $gap)) . Helpers::progressBar($percentage, 100) . "<br>";
        }
        echo $output;
    }
    private function toJson(): string {
        return json_encode($this->skills, JSON_PRETTY_PRINT);
    }

    public function run(array $tokens): Metadata 
    {
        if(sizeof($tokens) <= 1) {
            $this->defaultResponse();
            return Metadata::success();
        }

        $flag = $this->getFlag($tokens[1]);
        if($flag == null){
            return Cli::error("Invalid flag `" . $tokens[1] . "`");
        }

        switch($flag->name) {
        case "help":
            echo $this->help();
            break;
        case "json":
            echo $this->toJson();
            break;
        default:
            return Cli::error("Invalid flag `" . $tokens[1] . "`");
        }

        return Metadata::success();
    }

}
?>

