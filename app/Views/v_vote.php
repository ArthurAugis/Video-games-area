<div class="corps">
    <?php
        var_dump($vote);
    ?>
    <div class="gauche">
        <div class="tournoi">
            <h2>Smash Bros Ultimate <span class="pourcentage">35%</span></h2>
            <div class="progress-bar">
                <div class="progression" style="width: 35%"></div>
            </div>
        </div>
        <div class="tournoi">
            <h2>Elden Ring <span class="pourcentage">15%</span></h2>
            <div class="progress-bar">
                <div class="progression" style="width: 15%"></div>
            </div>
        </div>
        <div class="tournoi">
            <h2>Metroid Prime 4 <span class="pourcentage">13%</span></h2>
            <div class="progress-bar">
                <div class="progression" style="width: 13%"></div>
            </div>
        </div>
        <div class="tournoi">
            <h2>Pokemon Scarlet <span class="pourcentage">17%</span></h2>
            <div class="progress-bar">
                <div class="progression" style="width: 17%"></div>
            </div>
        </div>
        <div class="tournoi">
            <h2>Rocket League <span class="pourcentage">20%</span></h2>
            <div class="progress-bar">
                <div class="progression" style="width: 20%"></div>
            </div>
        </div>
        <?php

        echo form_open(base_url() . "public/vote", 'class="formvote"');
        echo '<h2>Votez pour votre jeu préféré</h2>';
        $options = array(
            '1' => 'Smash Bros Ultimate',
            '2' => 'Elden Ring',
            '3' => 'Metroid Prime 4',
            '4' => 'Pokemon Scarlet',
            '5' => 'Rocket League'
        );

        echo form_dropdown('voteDuJeu', $options);

        $submit = array(
            'name' => 'voter',
            'value' => 'Voter',
            'class' => 'submitbtn'
        );

        echo form_submit($submit);

        echo form_close();
        ?>
        <div class="timer">
            <div>
                <h2 class="days">0</h2>
                <h2>Jours</h2>
            </div>
            <div>
                <h2 class="hours">00</h2>
                <h2>Heures</h2>
            </div>
            <div>
                <h2 class="minutes">00</h2>
                <h2>Minutes</h2>
            </div>
            <div>
                <h2 class="seconds">00</h2>
                <h2>Secondes</h2>
            </div>
        </div>
        <div class="plateformes">
            <?php
            $options = array(
                '1' => 'Playstation',
                '2' => 'Xbox',
                '3' => 'Nintendo'
            );

            echo form_dropdown('plateforme', $options);
            ?>
        </div>
    </div>
    <div class="droite">
        <?php
        $proprieteImage =
            [
                'src' => '/public/img/MarioQuiVote.webp',
                'alt' => 'Mario qui vote',
                'class' => 'image'
            ];

        echo img($proprieteImage);
        ?>
    </div>
</div>