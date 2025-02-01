<?php 

require_once 'Command.php';

class Task {
    private string $desc;
    private bool $done;

    public function __construct(string $desc, bool $done = false)
    {
        $this->desc = $desc;
        $this->done = $done;
    }

    public function completed(): bool
    {
        return $this->done;
    }

    public function complete(): void
    {
        $this->done = true;
    }

    public function __toString(): string
    {
        $prefix = ($this->completed()) ? "- [x] " : "- [ ] ";
        return $prefix . $this->desc;
    }
}

class Todo extends Command {
    private array $todos = [];

    public function __construct()
    {
        parent::__construct("todo", "Future improvements");

        $this->todos[] = new Task("Better about command");
        $this->todos[] = new Task("Better links command");
        $this->todos[] = new Task("Connnection to a database");
        $this->todos[] = new Task("More commands and terminal features");
        $this->todos[] = new Task("Sudo implementation");
        $this->todos[] = new Task("Add/Edit/Remove todos using the command");
        $this->todos[] = new Task("settings command");
    }

    public function run(array $tokens): bool
    {
        foreach($this->todos as $todo) {
            echo $todo . "<br>";
        }
        return true; 
    }
}

?>
