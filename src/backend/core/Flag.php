<?php
namespace app\core;

class Flag {
    private string $name;
    public FlagType $type;
    public bool $acceptsValue;

    public function __construct(string $name, FlagType $type, bool $acceptsValue = false)
    {
        $this->name = $name;
        $this->type = $type;
        $this->acceptsValue = $acceptsValue;
    }

    public function __get(string $name): mixed
    {
        return $this->name;
    }

    public function getFlag(): mixed
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
