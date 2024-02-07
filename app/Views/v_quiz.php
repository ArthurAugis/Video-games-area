<?php
$quiz_json = json_encode($quiz);
?>
<div class="quiz">
    <h2 class="question">Commencer le quiz ?</h2>
    <div class="propositions">
    </div>
    <?php
    $valider_btn = array("class" => "valider_btn", "content" => "Valider");
    echo form_button($valider_btn);
    ?>
</div>
<script>
    var quiz = <?php echo $quiz_json; ?>;
    var questionsObj = {};

    quiz.forEach(function(question) {
        if (questionsObj.hasOwnProperty(question.Questions)) {
            questionsObj[question.Questions][1].push([question.Reponses, question.BonneReponse]);
        } else {
            questionsObj[question.Questions] = [question.Questions, [[question.Reponses, question.BonneReponse]]];
        }
    });

    var tableau_questions = Object.values(questionsObj);

    var score = 0;

    function afficherQuestion() {
        if (tableau_questions.length > 0) {
            var random = Math.floor(Math.random() * tableau_questions.length);
            var question = tableau_questions.splice(random, 1)[0];
            $(".question").text(question[0]);
            $(".propositions").empty();

            question[1].forEach(function(reponse) {
                var propositionBtn = $("<button></button>")
                    .addClass("proposition")
                    .text(reponse[0])
                    .data("bonneReponse", reponse[1])
                    .click(function() {
                        $(this).toggleClass("selected");
                    })
                    .appendTo(".propositions");
            });

        } else {
            alert("Fin du quiz !");
        }
    }

    $(".valider_btn").click(function(event) {
        var reponseButtons = $(".propositions .proposition");
        reponseButtons.each(function() {
            var isCorrect = parseInt($(this).data("bonneReponse"));
            if ($(this).hasClass("selected")) {
                if (isCorrect === 1) {
                    score++;
                }
            }
        });
        afficherQuestion();
    });

    afficherQuestion();
</script>
