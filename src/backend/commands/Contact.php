<?php



namespace app\commands;

use app\core\Command;
use app\core\Flag;
use app\core\FlagType;
use app\core\Helpers;
use app\core\Metadata;
use app\core\Cli;

class Contact extends Command {
    public function __construct()
    {
        parent::__construct("contact", "Reach out to me");

        $this->appendFlag(new Flag("email" , FlagType::Long));
        $this->appendFlag(new Flag("github", FlagType::Long));
        $this->appendFlag(new Flag("help", FlagType::Short));
        $this->appendFlag(new Flag("help", FlagType::Long));
    }

    /**
     * @param mixed $config
     */
    private function defaultResponse($config): string 
    {
        $output = "Reach me at<br>";
        if($config['email']){
            $output .= "- Email: " . Helpers::mailto($config['email']) . "<br>";
        }
        if($config['github']) {
            $output .= "- Github: " . Helpers::anchor($config['github']) . "<br>";
        }

        return $output;
    }

    public function run(array $tokens): Metadata
    {
        $filePath = dirname(__DIR__, 2) . '/config.json';
        $config = Helpers::parseJson($filePath);
        if(!$config) {
            return Cli::error("Could not parse config.json");
        }

        
        if(sizeof($tokens) <= 1){
            echo $this->defaultResponse($config);
        } else {
            $flag = $this->getFlag($tokens[1]);
            $link = $config[$flag->name];

            if($flag == null) {
                return Cli::error("Invalid flag `" . $tokens[1] . "`");
            }

            switch($flag->name){
            case "email":
                echo Helpers::mailto($link);
                break;
            case "help":
                echo $this->help();
                break;
            case "github":
                echo Helpers::anchor($link);
                break;
            }
        }
        return Metadata::success();
    }

}

?>
