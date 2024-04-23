<?php
// met tout le quiz en format json
$quiz_json = json_encode($quiz);
?>
<div class="corps quiz">
    <h2 class="question">Commencer le quiz ?</h2>
    <div class="propositions">
    </div>
    <?php
    $valider_btn = array("class" => "valider_btn", "content" => "Valider");
    echo form_button($valider_btn);
    ?>
</div>
<div class="resultat">
    <h1>Tu as fini le quiz !</h1>
    <h3>Tu as eu X bonnes réponses</h3>
    <?php
    $session = \Config\Services::session();
    if (session()->get('login')) {
        echo form_open(base_url() . "scoreboardQuiz");

        $data = array(
            'name' => 'score-input',
            'id' => 'score-input',
            'type' => 'hidden',
        );

        echo form_input($data);

        $data = array(
            'name' => 'submit',
            'id' => 'submit',
            'content' => 'Enregistrer mon score',
            'type' => 'submit',
            'class' => 'enregistrer_btn'
        );

        echo form_button($data);
        echo "</p>";

        echo form_close();
    }

    echo anchor(base_url(), "<button class='return_accueil_btn'>Retourner à l'accueil</button>")
    ?>
</div>
<script>

    // recupere tout le quiz
    var quiz = <?php echo $quiz_json; ?>;
    var questionsObj = {};

    // met toutes les questions/réponses dans un tableau
    quiz.forEach(function (question) {
        if (questionsObj.hasOwnProperty(question.Questions)) {
            questionsObj[question.Questions][1].push([question.Reponses, question.BonneReponse]);
        } else {
            questionsObj[question.Questions] = [question.Questions, [[question.Reponses, question.BonneReponse]]];
        }
    });

    var tableau_questions = Object.values(questionsObj);

    var score = 0;

    function afficherQuestion() {

        // vérifie si il y a encore des questions
        if (tableau_questions.length > 0) {
            //récupére une question aléatoire
            var random = Math.floor(Math.random() * tableau_questions.length);
            var question = tableau_questions.splice(random, 1)[0];
            $(".question").text(question[0]);
            $(".propositions").empty();

            // récupére les réponses et les bonnes réponses
            question[1].forEach(function (reponse) {
                var propositionBtn = $("<button></button>")
                    .addClass("proposition")
                    .text(reponse[0])
                    .data("bonneReponse", reponse[1])
                    .click(function () {
                        $(this).toggleClass("selected");
                    })
                    .appendTo(".propositions");
            });

            // affiche le score si il n'y a plus de questions
        } else {
            document.querySelector('.quiz').style.display = "none";
            document.querySelector('.resultat').style.display = "block";
            document.querySelector('.resultat').querySelector('h3').innerText = "Tu as eu " + score +
                " bonnes réponses";
            document.querySelector('#score-input').value = score;
        }
    }

    $(".valider_btn").click(function (event) {
        var reponseButtons = $(".propositions .proposition");
        var scoretempo = -1;
        reponseButtons.each(function () {
            // vérifie si la réponse selectionné est bonne
            var isCorrect = parseInt($(this).data("bonneReponse"));
            if ($(this).hasClass("selected")) {
                if (isCorrect === 1 && scoretempo === -1) {
                    scoretempo = 1;
                }

                if(isCorrect !== 1)
                {
                    scoretempo = 0;
                }
            }
        });

        if(scoretempo === 1){ score++; }

        afficherQuestion();
    });

    afficherQuestion();
</script>
