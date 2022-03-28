<?php //góra strony z szablonu
include _ROOT_PATH . '/templates/top.php';
?>


<form action="<?php print(_APP_ROOT); ?>/app/calc.php" method="post" class="pure-form pure-form-stacked">


    <fieldset>
        <div style="position: relative;left: 5%;">
            <label for="id_N">Kwota kredytu: </label>
            <input id="id_N" type="text" name="N" value="<?php out($N); ?>"/><br/><br/>
        </div>
        <div style="position: relative;left: 40%; top:-99px;">
            <label for="id_o">Okres spłaty: </label>
            <input id="id_o" type="text" name="o" placeholder="Ile lat" value="<?php out($o); ?>"/><br/><br/>
        </div>
        <div style="position: relative;left: 75%; top:-200px;">
            <label for="id_r">Oprocentowanie: </label>
            <input id="id_r" type="text" name="r" placeholder="6.5" pattern="[0-9]+(\.[0-9]{1,2})?%?"
                   title="Używaj tylko kropki. Maksymalnie dwie liczby po kropce.  " value="<?php out($r); ?>"/><br/>
        </div>
        <input style="position: relative;left: 40%; top:-99px;" type="image" src="/php_02/img/button.png" value="Oblicz"
        <!--class="pure-button pure-button-primary-->"/>
    </fieldset>

</form>
<div class="messages">
    <?php
    //wyświeltenie listy błędów, jeśli istnieją
    if (isset($messages)) {
        if (count($messages) > 0) {
            echo '<ol style="margin-top: 1em; padding: 1em 1em 1em 2em; border-radius: 0.5em; background-color: #f22; width:25em;">';
            foreach ($messages as $key => $msg) {
                echo '<li>' . $msg . '</li>';
            }
            echo '</ol>';
        }
    }
    ?>

    <?php if (isset($result)) { ?>

        <p class="res">
            <?php echo 'Rata miesięczna: ' . $result . 'zł'; ?>
        </p>


    <?php } ?>

</div>
<?php //dół strony z szablonu
include _ROOT_PATH . '/templates/bottom.php';
?>
