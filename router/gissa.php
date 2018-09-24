<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
* Guess my number with GET.
 */
$app->router->get("gissa/get", function () use ($app) {

    $number = $_GET["number"] ?? -1;
    $tries = $_GET["tries"] ?? 6;
    $guess = $_GET["guess"] ?? null;

    $game = new \Yogan\Guess\Guess($number, $tries);

    if (isset($_GET["reset"])) {
        $game->random();
    }

    // Do a guess
    $res = null;
    if (isset($_GET["doGuess"])) {
        $res = $game->makeGuess($guess);
    }

    $data = [
        "title" => "Gissa mitt nummer GET",
        "game" => $game,
        "res" => $res,
        "guess" => $guess
    ];

    $app->view->add("anax/v2/guess/get", $data);
    return $app->page->render($data);
});


/**
* Guess my number with POST.
 */
$app->router->any(["GET", "POST"], "gissa/post", function () use ($app) {

    $number = $_POST["number"] ?? -1;
    $tries = $_POST["tries"] ?? 6;
    $guess = $_POST["guess"] ?? null;

    $game = new \Yogan\Guess\Guess($number, $tries);

    if (isset($_POST["doReset"])) {
        $game->random();
    }

    // Do a guess
    $res = null;
    if (isset($_POST["doGuess"])) {
        $res = $game->makeGuess($guess);
    }

    $data = [
        "title" => "Gissa mitt nummer POST",
        "game" => $game,
        "res" => $res,
        "guess" => $guess
    ];

    $app->view->add("anax/v2/guess/post", $data);
    return $app->page->render($data);
});

/**
* Guess my number with SESSION.
 */
$app->router->any(["GET", "POST"], "gissa/session", function () use ($app) {

    // session_name("jolu17");
    // session_start();

    // Set the important variables for the game
    $number = $game->number ?? -1;
    $tries = $game->tries ?? 6;
    $guess = $_POST["guess"] ?? null;

    if (!isset($_SESSION["game"])) {
        $_SESSION["game"] = new \Yogan\Guess\Guess($number, $tries);
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
    // if (isset($_POST["cheat"])) {
    //     $res = "The correct number is {$game->number}";
    // }

    $data = [
        "title" => "Gissa mitt nummer SESSION",
        "game" => $game,
        "res" => $res,
        "guess" => $guess
    ];

    $app->view->add("anax/v2/guess/session", $data);
    return $app->page->render($data);
});
