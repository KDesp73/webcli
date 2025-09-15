<?php 

require_once 'Command.php';
require_once 'Metadata.php';

class Task {
    private int $id;
    private string $desc;
    private bool $done;

    public function __construct(int $id, string $desc, bool $done = false)
    {
        $this->id = $id;
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
    private static string $DB = "./data/todo.db";

    public function __construct()
    {
        parent::__construct("todo", "Future improvements");

        $this->appendFlag(new Flag("help", FlagType::Short));
        $this->appendFlag(new Flag("help", FlagType::Long));
        $this->appendFlag(new Flag("add", FlagType::Long, true));
        $this->appendFlag(new Flag("edit", FlagType::Long, true));
        $this->appendFlag(new Flag("remove", FlagType::Long, true));
        $this->appendFlag(new Flag("complete", FlagType::Long, true));

        // $this->todos[] = new Task("Better about command");
        // $this->todos[] = new Task("Better links command");
        // $this->todos[] = new Task("Connnection to a database");
        // $this->todos[] = new Task("More commands and terminal features");
        // $this->todos[] = new Task("Sudo implementation");
        // $this->todos[] = new Task("Add/Edit/Remove todos using the command");
        // $this->todos[] = new Task("settings command");

        $this->loadTasks();
    }

    private function loadTasks(): void
    {
        $db = new SQLite3('./data/todo.db');
        $result = $db->query("SELECT * FROM tasks");
        while ($row = $result->fetchArray()) {
            $this->todos[] = new Task($row['id'], $row['description'], $row['completed']);
        } 
        $db->close();
    }

    private function defaultResponse(): void
    {
        foreach($this->todos as $todo) {
            echo $todo . "<br>";
        }
    
    }
    
    public function run(array $tokens): Metadata
    {
        $tokensLen = sizeof($tokens);
        if($tokensLen <= 1) {
            $this->defaultResponse();
            return true;
        }

        $flag = $this->getFlag($tokens[1]);
        if($flag == null){
            return Cli::error("Invalid flag `" . $tokens[1] . "`");
        }

        $db = new SQLite3('./data/todo.db');
        $db->enableExceptions(true);

        switch($flag->name) {
        case "help":
            echo $this->help();
            break;

        case "add":
            if ($tokensLen <= 2) {
                $db->close();
                return Cli::error("--add requires an argument");
            }

            $index = $tokens[2];

            $stmt = $db->prepare("INSERT INTO tasks (description) VALUES (:description);");
            $stmt->bindValue(':description', $index, SQLITE3_TEXT);

            if ($stmt->execute()) {
                print_r("Task successfully added.\n");
                $this->loadTasks();
            } else {
                $db->close();
                return Cli::error("Failed to add task.");
            }

            $db->close();
            break;

        case "complete":
            if ($tokensLen <= 2) {
                $db->close();
                return Cli::error("--complete requires an argument");
            }

            $index = $tokens[2];
            $desc = "";
            foreach($this->todos as $i => $todo){
                if($index == $i) $desc = $todo->description;
            }

            $stmt = $db->prepare("UPDATE tasks SET completed = :completed WHERE description = :description;");
            $stmt->bindValue(':description', $desc);
            $stmt->bindValue(':completed', 1, SQLITE3_INTEGER);

            if ($stmt->execute()) {
                print_r("Task completed.\n");
            } else {
                $db->close();
                return Cli::error("Failed to update task.");
            }

            $db->close();
            break;

        default:
            // Handle invalid flags
            return Cli::error("Invalid flag `" . $tokens[1] . "`");
        }

        return Metadata::success();
    }
}

?>
