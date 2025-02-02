<?php 
require_once 'Command.php';
require_once 'Flag.php';
require_once 'helpers.php';
require_once 'ansi.php';

class Skills extends Command {
    private array $skills;
    public function __construct()
    {
        parent::__construct("skills", "Check what I can do");

        $this->appendFlag(new Flag("help", FlagType::Short));
        $this->appendFlag(new Flag("help", FlagType::Long));
        $this->appendFlag(new Flag("json", FlagType::Long));

        $this->skills["C"] = 90;
        $this->skills["Java"] = 80;
        $this->skills["Go"] = 60;
        $this->skills["HTML/CSS"] = 70;
        $this->skills["JavaScript"] = 60;
        $this->skills["PHP"] = 60;
    }

    private function defaultResponse(): void {
        $maxLength = max(array_map('strlen', array_keys($this->skills)));
        $gap = 2;

        $output = "";
        foreach($this->skills as $name => $percentage) {
            $output .= "- " . str_replace(" ", "&nbsp;", str_pad($name, $maxLength + $gap)) . progressBar($percentage, 100) . "<br>";
        }
        echo $output;
    }
    private function toJson(): string {
        return json_encode($this->skills, JSON_PRETTY_PRINT);
    }
    public function run(array $tokens): bool
    {
        if($tokens[0] != $this->name) return false;
        if(sizeof($tokens) <= 1) {
            $this->defaultResponse();
            return true;
        }

        $flag = $this->getFlag($tokens[1]);
        if($flag == null){
            Cli::error("Invalid flag `" . $tokens[1] . "`");
            return false;
        }

        switch($flag->name) {
        case "help":
            echo $this->help();
            break;
        case "json":
            echo $this->toJson();
            break;
        default:
            Cli::error("Invalid flag `" . $tokens[1] . "`");
            return false;
        }

        return true;
    }

}
?>

