<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "admin/ajoutSession");

        echo "<h1>Ajouter une session de tournoi</h1>";

        echo '<p>';
        echo form_label('Jeu :') . "<br>";

        echo '</p>' . '<p>';
        $options = array();
        if (!empty($tournoisList)) {
            foreach ($tournoisList as $tournoi) {
                $options[$tournoi->id_tournoi] = $tournoi->jeu_tournoi . " sur " . $tournoi->plateforme_tournoi;
            }
        }

        // création du dropdown
        echo form_dropdown('tournoi', $options, '', 'id="tournoi" class="settingsSelect"');
        echo "</p>";

        echo '<p>';
        echo form_label('Date de début :') . "<br>";
        $date_data = array(
            'type' => 'date',
            'name' => 'date',
            'id' => 'date',
            'class' => 'settingsSelect',
            'value' => set_value('date')
        );
        echo form_input($date_data);
        echo "</p>" . "<p>";
        if ($validation !== null) {
            echo $validation->getError('date');
        }
        echo '</p>' . '<p>';
        echo form_label('Heure de début :') . "<br>";
        $data = array(
            'type' => 'time',
            'name' => 'heure',
            'id' => 'heure',
            'class' => 'settingsSelect',
            'value' => set_value('heure')
        );
        echo form_input($data);
        echo "</p>" . "<p>";
        if ($validation !== null) {
            echo $validation->getError('heure');
        }
        echo '</p>' . '<p>';
        echo form_label('Nombre de places :') . "<br>";
        $data = array(
            'type' => 'number',
            'name' => 'places',
            'id' => 'places',
            'class' => 'settingsSelect',
            'value' => set_value('places')
        );
        echo form_input($data);
        echo "</p>" . "<p>";
        if ($validation !== null) {
            echo $validation->getError('places');
        }
        echo "</p>";

        $data = array(
            'name' => 'submit_form',
            'content' => "Ajouter la session de tournoi",
            'type' => 'submit'
        );

        echo form_button($data);
        echo "</p>";

        echo form_close();
    } else {
        header("Location: " . base_url() . 'utilisateur');
        exit();
    }
    ?>
</div>