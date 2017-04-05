<?php
// $exception = new GuessException("Out of bounds! Need to be a value between 1-100.");
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
                throw new \Anax\Route\GuessException("Out of bounds! Need to be a value between 1-100.");
            } catch (\Anax\Route\GuessException $e) {
                $message = "<p>".$e."</p>";
                $leftmessage = "";
            }
        } else {
            $guess->addNumberGuessesDone();
            $number_guesses_done = $guess->getNumberOfGuesses();
            $left = $guess->getLeft($number_guesses_done);
            if ($_POST['guessfield'] == $guess->getRandomizedNumber()) {
                $leftmessage = "<p class='leftmessage'>We have a winner!</p>";
                $message = "<p>" . $guess->getResult($_POST['guessfield']) . "</p>";
            } else if ($left > 0) {
                $leftmessage = "<p class='leftmessage'>You have <strong>" . $left . "</strong> guess/es left!</p>";
                $message = "<p>" . $guess->getResult($_POST['guessfield']) . "</p>";
            } else {
                $leftmessage = "<p class='leftmessage'>You lose! You are out of guesses!<br />The correct answer was " . $guess->getRandomizedNumber() ."</p>";
                // $message = "<p>The correct answer was " . $guess->getRandomizedNumber() ."</p>";
                $message = "<p>Try again?</p>";
            }
        }
    }

    $guesserial = serialize($guess);
    $_SESSION['guess'] = $guesserial;

    // echo "Gissning nr " . $number_guesses_done . " på nummer " . $randomized;
} else if (isset($_POST['reset'])) {
    // $upOneUrlLvl = dirname($_SERVER['PHP_SELF']);
    // $url = $upOneUrlLvl."/guessing";
    header('Location: guessing');
} else {
    $name = substr(preg_replace('/[^a-z\d]/i', '', __DIR__), -30);
    session_name($name);
    session_start();

    $number_guesses_done = 1;
    $guess = new \Maaa16\Guess\Guess("random", $number_guesses_done);
    $randomized = $guess->getRandomizedNumber();
    $guess->setNumberOfGuesses(0);

    $guesserial = serialize($guess);
    $_SESSION['guess'] = $guesserial;

    $message = "A number between 1-100 has been randomized for you to guess on.";
    $leftmessage = "<p class='leftmessage'>You have <strong>6</strong> guesses left!</p>";
}
$upOneUrlLvl = dirname($_SERVER['PHP_SELF']);
$url = $upOneUrlLvl."/guessing";
?>

<div class="page">
    <div class="container">
        <h1>GUESS THE NUMBER</h1>
        <p><a href=<?= $app->url->create('guessing') ?>>Reset</a></p>
        <div class="row">
            <div class="col-md-3">
                <form action="#" method="POST">
                    <div class="input-group">
                        <!-- <label for="guessfield">Gissa på nummer mellan 1-100</label> -->
                        <input class="form-control" type="number" name="guessfield" value="">
                        <span class="input-group-btn">
                            <!-- <button class="btn btn-default" type="button">Go!</button> -->
                            <button class="btn btn-primary" type="submit" name="guessing">Guess</button>
                            <button class="btn btn-danger" type="submit" name="reset">Reset</button>

                            <!-- <input class="btn btn-danger" type="submit" name="reset" value="Reset"> -->
                        </span>
                    </div>
                    <div class="form-group">


                    </div>

                </form>
            </div>
            <div class="col-md-offset-2 col-md-7">
                <?php
                    echo $message;
                    echo $leftmessage;
                ?>
            </div>
        </div>
    </div>
</div>
