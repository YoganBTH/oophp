<?php

namespace Yogan\Guess;

require __DIR__ . "/config.php";
require __DIR__ . "/../../vendor/autoload.php";

$title = "Guess my number (SESSION)";

// session_name("jolu17");
// session_start();

// Set the important variables for the game
$number = $game->number ?? -1;
$tries = $game->tries ?? 6;
$guess = $_POST["guess"] ?? null;

if (!isset($_SESSION["game"])) {
    $_SESSION["game"] = new Guess($number, $tries);
}

$game = $_SESSION["game"];

// Reset the game
if (isset($_POST["doReset"])) {
    $game->random();
    $game->setTries(6);
}

$res = "";
if (isset($_POST["doGuess"])) {
    $res = $game->makeGuess($guess);
}

// Cheat
if (isset($_POST["cheat"])) {
    $res = "The correct number is {$game->number}";
}

// echo "Current number: {$game->number()}";

?><!DOCTYPE html>
<meta charset="utf-8">
<title><?= $title ?></title>
<h1><?= $title ?></h1>

<p>Guess a number between 1 and 100, you have <?= $game->tries() ?> tries left.</p>

<form method="POST">
    <input type="hidden" name="number" value="<?= $game->number() ?>">
    <input type="hidden" name="tries" value="<?= $game->tries() ?>">
    <input type="text" name="guess" value="<?= $guess ?>" autofocus>
    <input type="submit" name="doGuess" value="Make a guess">
    <input type="submit" name="doReset" value="Reset">
    <input type="submit" name="doCheat" value="Cheat">
</form>

<!-- <p>
    <a href="?reset">Reset the game</a>
</p> -->

<?php if (isset($res)) : ?>
<p>Your guess <?= $guess ?> is <b><?= $res ?></b></p>
<?php endif; ?>

<?php if (isset($_POST["doCheat"])) : ?>
<p>Cheat: <?= $game->number() ?></p>
<?php endif; ?>
