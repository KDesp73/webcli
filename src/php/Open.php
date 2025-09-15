<?php

require_once 'Flag.php';
require_once 'Command.php';
require_once 'Metadata.php';
require_once 'helpers.php';

enum ResourceType
{
    case File;
    case Link;
    case Image;
}

class Resource {
    public string $name;
    public ResourceType $type;
    public string $content;
    
    public function __construct(string $name, ResourceType $type, string $content) {
        $this->name = $name;
        $this->type = $type;
        $this->content = $content;
    }
}

class Open extends Command {
    private array $resources = [];

    public function __construct()
    {
        parent::__construct("open", "Open a resource");

        $this->appendFlag(new Flag("help", FlagType::Short));
        $this->appendFlag(new Flag("help", FlagType::Long));
        $this->appendFlag(new Flag("name", FlagType::Long, true));

        $jsonFile = __DIR__ . '/resources.json';
        if (file_exists($jsonFile)) {
            $resources = json_decode(file_get_contents($jsonFile), true);
            if (is_array($resources)) {
                foreach ($resources as $res) {
                    switch (strtolower($res['type'])) {
                    case 'link':
                        $type = ResourceType::Link;
                        break;
                    case 'image':
                        $type = ResourceType::Image;
                        break;
                    case 'file':
                        $type = ResourceType::File;
                        break;
                    default:
                        continue 2;
                    }
                    $this->appendResource($res['name'], $type, $res['content']);
                }
            }
        }
    }

    private function appendResource(string $name, ResourceType $type, string $content) 
    {
        $this->resources[$name] = new Resource($name, $type, $content);
    }

    public function run(array $tokens): Metadata
    {
        if($tokens[0] != $this->name) return Metadata::failure("Invalid command");;

        if(count($tokens) <= 1){
            return Cli::error("open requires an argument");
        } else {
            $flag = $this->getFlag($tokens[1]);

            if($flag == null) {
                return Cli::error("Invalid flag `" . $tokens[1] . "`");
            }

            switch($flag->name){
            case "help":
                echo $this->help();

                println("");
                println(bold("NAMES"));
                foreach($this->resources as $name => $resource) {
                    println(strpad("  " . $name, 2));
                }
                break;

            case "name":
                if(count($tokens) < 3){
                    return Cli::error("Provide a name for the resource");
                }

                $value = $tokens[2];
                $resource = $this->resources[$value] ?? null;
                if($resource == null) {
                    return Cli::error("No resource found for `" . $value . "`");
                }
                switch($resource->type) {
                case ResourceType::Image:
                    println(img($resource->content, $resource->name));
                    return Metadata::success();
                case ResourceType::Link:
                case ResourceType::File:
                    return Metadata::success($resource->content);
                default:
                    return Cli::error("Unhandled resource type");
                }
                break;
            }
        }

        return Metadata::failure("UNREACHABLE");
    }
}

?>
