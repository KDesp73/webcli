<?php
require_once 'helpers.php';
require_once 'Help.php';
require_once 'Contact.php';
require_once 'About.php';
require_once 'Skills.php';
require_once 'Ping.php';
require_once 'Amogus.php';
require_once 'Cli.php';

$cli= new Cli();
$cli->add(new Contact());
$cli->add(new About());
$cli->add(new Skills());
$cli->add(new Ping());
$cli->add(new Amogus());
$cli->add(new Command("clear", "Clear the terminal"));
$cli->finish();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = $_POST['command'] ?? '';

    $cli->execute($input);
}
?>
