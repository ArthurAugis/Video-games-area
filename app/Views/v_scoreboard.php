<?php
echo '<div class="corps scoreboard">';
echo '<h1 class="titre">Tableau des scores</h1>';

$place = 1;
if (!empty($top10)) {
    foreach ($top10 as $score) {
        echo $place . '.' . $score->pseudo . " - " . $score->nbBonnesReponses . "<br>";
        $place++;
    }
}
echo '</div>';
?>
