<?php

namespace Yogan\Guess;

require __DIR__ . "/config.php";
require __DIR__ . "/../../vendor/autoload.php";

$title = "Guess my number (POST)";

$number = $_POST["number"] ?? -1;
$tries = $_POST["tries"] ?? 6;
$guess = $_POST["guess"] ?? null;

$game = new Guess($number, $tries);

if (isset($_POST["doReset"])) {
    $game->random();
}

// Do a guess
$res = null;
if (isset($_POST["doGuess"])) {
    $res = $game->makeGuess($guess);
}

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
    <a href="?doReset">Reset the game</a>
</p> -->

<?php if (isset($res)) : ?>
<p>Your guess <?= $guess ?> is <b><?= $res ?></b></p>
<?php endif; ?>

<?php if (isset($_POST["doCheat"])) : ?>
<p>Cheat: <?= $game->number() ?></p>
<?php endif; ?>
