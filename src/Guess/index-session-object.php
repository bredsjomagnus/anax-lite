<?php
namespace Maaa16\guess;

require "config.php";
// require "autoload.php";

if (isset($_POST['guessing'])) {
    if (isset($_POST['guessfield'])) {
        $name = substr(preg_replace('/[^a-z\d]/i', '', __DIR__), -30);
        session_name($name);
        session_start();
        $guesserial = $_SESSION['guess'];
        $guess = unserialize($guesserial);
        // $guess->addNumberGuessesDone();

        $randomized = $guess->getRandomizedNumber();

        $guessednumber = $_POST['guessfield'];
        if ($guessednumber < 1 || $guessednumber > 100) {
            try {
                throw new GuessException("Out of bounds! Need to be a value between 1-100.");
            } catch (GuessException $e) {
                $message = "<p>".$e."</p>";
            }
        } else {
            $guess->addNumberGuessesDone();
            $number_guesses_done = $guess->getNumberOfGuesses();
            $left = $guess->getLeft($number_guesses_done);
            if ($_POST['guessfield'] == $guess->getRandomizedNumber()) {
                $message = "<p>" . $guess->getResult($_POST['guessfield']) . "</p>";
            } else if ($left > 0) {
                $message = "<p>You have " . $left . " guess/es left!</p>";
                $message .= "<p>" . $guess->getResult($_POST['guessfield']) . "</p>";
            } else {
                $message = "<p>You lose! You are out of guesses!</p>";
                $message .= "<p>The correct answer was " . $guess->getRandomizedNumber() ."</p>";
            }
        }
    }

    $guesserial = serialize($guess);
    $_SESSION['guess'] = $guesserial;

    // echo "Gissning nr " . $number_guesses_done . " på nummer " . $randomized;
} else if (isset($_POST['reset'])) {
    $upOneUrlLvl = dirname($_SERVER['PHP_SELF']);
    $url = $upOneUrlLvl."/index-session-object.php";
    header('Location: '.$url);
} else {
    $name = substr(preg_replace('/[^a-z\d]/i', '', __DIR__), -30);
    session_name($name);
    session_start();

    $number_guesses_done = 1;
    $guess = new Guess("random", $number_guesses_done);
    $randomized = $guess->getRandomizedNumber();
    $guess->setNumberOfGuesses(0);

    $guesserial = serialize($guess);
    $_SESSION['guess'] = $guesserial;

    $message = "";
}
$upOneUrlLvl = dirname($_SERVER['PHP_SELF']);
$url = $upOneUrlLvl."/index-session-object.php";
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>index-session-object</title>
</head>
<body>
    <h1>Index-Session-Object</h1>
    <p><a href=<?= $upOneUrlLvl . "/index.php"?>>Tillbaka</a></p>
    <form action="#" method="POST">
        <label for="guessfield">Guess on number between 1-100</label>
        <input type="number" name="guessfield" value="">
        <input type="submit" name="guessing" value="Guess">
        <input type="submit" name="reset" value="Reset">
    </form>
    <a href=<?= $url ?>>Reset</a>
    <?php
        echo $message;
    ?>
</body>
</html>
