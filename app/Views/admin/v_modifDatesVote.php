<div class="corps settings">
    <h1><?= $titre; ?></h1>
    <?php
    if (session()->get('admin')) {
        echo form_open(base_url() . "public/admin/modifDatesVote");

        echo "<h1>Modification des dates de vote</h1>";

        echo '<p>';
        echo form_label('Date de début :') . "<br>";

        echo '</p>' . '<p>';

        $data = array(
            'name' => 'date_debut',
            'type' => 'datetime-local',
            'id' => 'date_debut',
            'class' => 'settingsSelect',
            'value' => set_value('date_debut')
        );

        echo form_input($data);

        echo '</p>' . '<p>';

        echo form_label('Date de fin :') . "<br>";

        echo '</p>' . '<p>';

        $data = array(
            'name' => 'date_fin',
            'type' => 'datetime-local',
            'id' => 'date_fin',
            'class' => 'settingsSelect',
            'value' => set_value('date_fin')
        );

        echo form_input($data);

        echo "</p>";

        $data = array(
            'name' => 'submit_form',
            'content' => "Modifier les dates de vote",
            'type' => 'submit'
        );

        echo form_button($data);
        echo "</p>";

        echo form_close();
    } else {
        header("Location: " . base_url() . 'public/utilisateur');
        exit();
    }
    ?>
</div>