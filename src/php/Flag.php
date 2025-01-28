<?php

enum FlagType
{
    case Long;
    case Short;
    case None;
}

class Flag {
    private string $name;
    public FlagType $type;

    public function __construct(string $name, FlagType $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function __get(string $name): mixed
    {
        return $this->name;
    }

    public function getFlag(string $name): mixed
    {
        switch($this->type){
            case FlagType::Long:
                return "--" . $this->name;
            case FlagType::Short:
                return "-" . $this->name[0];
            case FlagType::None:
            default: 
                return $this->name;
        }
    }
}

?>
