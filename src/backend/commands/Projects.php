<?php


namespace app\commands;

use app\core\Command;
use app\core\Flag;
use app\core\FlagType;
use app\core\Metadata;
use app\core\Cli;
use app\core\Helpers;
use Error;

class Project {
    public string $name;
    public string $language;
    public string $license;
    public string $url;
    public string $description;
    /**
     * @param mixed $name
     * @param mixed $language
     * @param mixed $license
     * @param mixed $url
     * @param mixed $description
     */
    public function __construct($name, $language, $license, $url, $description)
    {
        $this->name = $name;
        $this->language = $language;
        $this->license = $license;
        $this->url = $url;
        $this->description = $description;
    }

    private function printInBox(string $str, int $width): string
    {
        return "│ " . Helpers::strpad($str, $width-2) . " │<br>";
    }
    public function view(): string
    {
        $width = 50;
        $output = "&nbsp;&nbsp;" . Helpers::anchor($this->url, $this->name) . "<br>";
        $output .= "╭" . str_repeat("─", $width) . "╮<br>";
        $output .= $this->printInBox("- Language: " . $this->language, $width); 
        $output .= $this->printInBox("- License: " . $this->license, $width); 
        $output .= $this->printInBox("", $width); 

        $descLines = Helpers::wrapLines($this->description, $width-2);
        foreach($descLines as $line) {
            $output .= $this->printInBox($line, $width);
        }

        $output .= "╰" . str_repeat("─", $width) . "╯<br>";

        return $output;
    }
}

class Projects extends Command {
    private array $projects;

    public function __construct()
    {
        parent::__construct("projects", "Showcases my projects");

        $this->appendFlag(new Flag("help", FlagType::Short));
        $this->appendFlag(new Flag("help", FlagType::Long));
        $this->appendFlag(new Flag("lang", FlagType::Long, true));
        $this->appendFlag(new Flag("name", FlagType::Long, true));

        $this->projects = [];
        $this->loadProjects();
    }

    private function loadProjects(): void
    {
        $filePath = dirname(__DIR__, 2) . '/data/projects.json';

        if (!file_exists($filePath)) {
            throw new \RuntimeException("Projects data file not found at: {$filePath}");
        }

        $jsonData = file_get_contents($filePath);
        $data = json_decode($jsonData, true);
        
        if ($data && isset($data['projects'])) {
            foreach ($data['projects'] as $projectData) {
                $project = new Project(
                    $projectData['name'],
                    $projectData['language'],
                    $projectData['license'],
                    $projectData['link'],
                    $projectData['description']
                );
                $this->projects[] = $project;
            }
            sort($this->projects);
        } else {
            throw new Error("Error loading projects data.");
        }
    }

    /**
     * @param array<int,mixed> $projects
     */
    private function view(array $projects): void
    {
        foreach ($projects as $project) {
            echo $project->view() . "<br>";
        }
    }

    private function filterName(string $name): array
    {
        return array_filter($this->projects, function($p) use ($name) {
            return strtolower($p->name) == strtolower($name);
        });
    }
    private function filterLang(string $lang): array
    {
        return array_filter($this->projects, function($p) use ($lang) {
            return strtolower($p->language) == strtolower($lang);
        });
    }

    public function run(array $tokens): Metadata
    {
        if(sizeof($tokens) <= 1) {
            $this->view($this->projects);
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
        case "name":
            if(sizeof($tokens) < 3) {
                return Cli::error("--name requires a value");
            }
            $this->view($this->filterName($tokens[2]));
            break;
        case "lang":
            if(sizeof($tokens) < 3) {
                return Cli::error("--lang requires a value");
            }
            $this->view($this->filterLang($tokens[2]));
            break;
        default:
            return Cli::error("Invalid flag `" . $tokens[1] . "`");
        }

        return Metadata::success();
    }
}

?>
