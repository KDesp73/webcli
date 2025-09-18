<?php
namespace app\api;

require_once dirname(__DIR__, 3) . '/vendor/autoload.php';

use app\core\Cli;
use app\core\Command;
use app\commands\{About, Contact, Skills, Ping, ExitC, Open, Amogus, Tokens, Todo, Projects};

$cli = new Cli();

// Public, handled by the backend
$cli->add(new Projects());
$cli->add(new Contact());
$cli->add(new About());
$cli->add(new Skills());
$cli->add(new Ping());
$cli->add(new Todo()); // NOTE: disabled until new implementation
$cli->add(new ExitC());
$cli->add(new Open());

// Private, handled by the backend
$cli->add(new Amogus());
$cli->add(new Tokens());

// Public, handled by the frontend
$cli->add(new Command("clear", "Clear the terminal"));
$cli->add(new Command("welcome", "Print the welcome message"));

$cli->finish();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = $_POST['command'] ?? '';

    ob_start();
    $metadata = $cli->execute($input);
    $stdout = ob_get_clean();

    // Build the JSON object
    $data = [
        'stdout' => $stdout,
        'command' => $input,
        'timestamp' => time(),
        'metadata' => $metadata->toArray()
    ];

    header('Content-Type: application/json');
    echo json_encode($data);
}
?>
