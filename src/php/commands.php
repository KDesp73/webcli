<?php
require_once 'helpers.php';
require_once 'Help.php';
require_once 'Contact.php';
require_once 'About.php';
require_once 'Skills.php';
require_once 'Ping.php';
require_once 'Amogus.php';
require_once 'Projects.php';
require_once 'Tokens.php';
require_once 'Cli.php';
require_once 'Todo.php';
require_once 'Exit.php';
require_once 'Open.php';

$cli = new Cli();

// Public, handled by the backend
$cli->add(new Projects());
$cli->add(new Contact());
$cli->add(new About());
$cli->add(new Skills());
$cli->add(new Ping());
// $cli->add(new Todo()); // NOTE: disabled until new implementation
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
