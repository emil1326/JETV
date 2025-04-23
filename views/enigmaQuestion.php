<?php
require 'partials/head.php';
require 'partials/header.php';

$didNotPassQuestion;
$noQuestionChoosed;

if (!isset($didNotPassQuestion)) {
    $didNotPassQuestion = false;
}
if (!isset($noQuestionChoosed)) {
    $noQuestionChoosed = false;
}

?>


<style>
    html,
    body {
        height: 100%;
    }

    main {
        width: 100%;
        min-height: 80vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;

    }

    .game-quiz-container {
        width: 100%;
        height: 40em;
        background-color: transparent;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-around;

    }

    .game-details-container {
        width: 80%;
        height: 4rem;
        display: flex;
        justify-content: space-around;
        align-items: center;
    }

    .game-details-container h1 {
        font-size: 1.2rem;
    }

    .game-question-container {
        width: 80%;
        height: 8rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid darkgray;

    }

    .game-question-container h1 {
        font-size: 1.5rem;
        text-align: center;
        padding: 3px;
    }

    .question-text {
        color: white;
    }

    .game-options-container {
        width: 80%;
        height: 12rem;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-around;
    }

    .game-options-container span {
        width: 45%;
        height: 3rem;
        border: 2px solid darkgray;

        overflow: hidden;

    }

    span label {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: transform 0.3s;
        font-weight: 600;
        color: white;
    }

    span label:hover {
        -ms-transform: scale(1.12);
        -webkit-transform: scale(1.12);
        transform: scale(1.12);
        color: white;
    }

    input[type="radio"] {
        position: relative;
        display: none;
        background-color: #303030;
    }


    input[type=radio]:checked~.option {
        background-color: white;
        color: black;

    }

    .next-button-container {
        width: 50%;
        height: 3rem;
        display: flex;
        justify-content: center;
    }

    .next-button-container button {
        width: 8rem;
        height: 2rem;
        color: white;
        font-weight: 600;
        cursor: pointer;
        outline: none;
        background-color: #303030;

    }


    .next-button-container button:hover {
        background-color: white;
        color: black;
    }

    .modal-container {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
        flex-direction: column;
        align-items: center;
        justify-content: center;
        -webkit-animation: fadeIn 1.2s ease-in-out;
        animation: fadeIn 1.2s ease-in-out;
    }

    .modal-content-container {
        height: 20rem;
        width: 25rem;
        background-color: rgb(43, 42, 42);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-around;

    }

    .modal-content-container h1 {
        font-size: 1.3rem;
        height: 3rem;
        color: white;
        text-align: center;
    }

    .grade-details {
        width: 15rem;
        height: 10rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-around;
    }

    .grade-details p {
        color: white;
        text-align: center;
    }


    .modal-button-container {
        height: 2rem;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-button-container button {
        width: 10rem;
        height: 2rem;
        background-color: #303030;
        outline: none;
        border: 1px solid rgb(252, 242, 241);
        color: white;
        font-size: 1.1rem;
        cursor: pointer;

    }

    .modal-button-container button:hover {
        background-color: #303030;
    }

    @media(min-width : 300px) and (max-width : 350px) {
        .game-quiz-container {
            width: 90%;
            height: 80vh;
        }

        .game-details-container h1 {
            font-size: 0.8rem;
        }

        .game-question-container {
            height: 6rem;
        }

        .game-question-container h1 {
            font-size: 0.9rem;
        }

        .game-options-container span {
            width: 90%;
            height: 2.5rem;
        }

        .game-options-container span label {
            font-size: 0.8rem;
        }

        .modal-content-container {
            width: 90%;
            height: 25rem;
        }

        .modal-content-container h1 {
            font-size: 1.5rem;
        }
    }

    @media(min-width : 350px) and (max-width : 700px) {
        .game-quiz-container {
            width: 90%;
            height: 80vh;
        }

        .game-details-container h1 {
            font-size: 1rem;
        }

        .game-question-container {
            height: 8rem;
        }

        .game-question-container h1 {
            font-size: 1.5rem;
        }

        .game-options-container span {
            width: 90%;
            margin-top: 8px;
        }

        .modal-content-container {
            width: 90%;
            height: 25rem;
        }

        .modal-content-container h1 {
            font-size: 1.2rem;
        }
    }



    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @-webkit-keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .questionM {

        text-align: center;
        font-size: 40px;
        position: absolute;
        margin: auto;
        top: -15px;
        right: 0;
        left: 0;
    }
</style>

<?php if ($didNotPassQuestion): ?>
    <main>

        <!-- todo ui for not passed question -->

        Mauvaise réponse <br>

        <a type="button" href="/enigma" class="btn btn-secondary" style="margin-top:20px;">retour</a>


    </main>
<?php elseif ($noQuestionChoosed): ?>
    <main>

        <!-- todo ui for not passed question -->

        :( <br>
        no answer choosed

        <a type="button" href="/enigma" class="btn btn-secondary" style="margin-top:20px;">retour</a>


    </main>
<?php else: ?>
    <main>
        <form method="POST" action="/enigmaQuestion" class="game-quiz-container">

            <div class="game-quiz-container">

                <div class="game-question-container" style="position: relative;">
                    <i class="fa fa-question-circle questionM"></i>
                    <h1 id="display-question" class="question-text"><?= $quest->getQuestion() ?></h1>
                </div>

                <div class="game-options-container">

                    <span>
                        <input type="radio" id="option-one" name="option" class="radio" value="<?= $answers[0]->getAwnserID() ?>" />
                        <label for="option-one" class="option" id="option-one-label"><?= $answers[0]->getAnswer() ?></label>
                    </span>

                    <span>
                        <input type="radio" id="option-two" name="option" class="radio" value="<?= $answers[1]->getAwnserID() ?>" />
                        <label for="option-two" class="option" id="option-two-label"><?= $answers[1]->getAnswer() ?></label>
                    </span>

                    <span>
                        <input type="radio" id="option-three" name="option" class="radio" value="<?= $answers[2]->getAwnserID() ?>" />
                        <label for="option-three" class="option" id="option-three-label"><?= $answers[2]->getAnswer() ?></label>
                    </span>

                    <span>
                        <input type="radio" id="option-four" name="option" class="radio" value="<?= $answers[3]->getAwnserID() ?>" />
                        <label for="option-four" class="option" id="option-four-label"><?= $answers[3]->getAnswer() ?></label>
                    </span>

                </div>

                <input type="hidden" name="answer" value="">
                <input type="hidden" name="questID" value="<?= $quest->getId() ?>">

                <div class="next-button-container">
                    <button type="submit">Envoyer</button>
                </div>

            </div>

        </form>


    </main>
<?php endif ?>


<?php
require 'partials/footer.php';
