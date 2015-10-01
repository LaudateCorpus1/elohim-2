<?php

$user = new User();
if (!$user->userIsLoggedIn()) {
    echo "<h1>You must be logged in first.</h1>";
} else {
    $ability['talent'][] = 'Alertness';
    $ability['talent'][] = 'Athletics';
    $ability['talent'][] = 'Awareness';
    $ability['talent'][] = 'Brawl';
    $ability['talent'][] = 'Empathy';
    $ability['talent'][] = 'Expression';
    $ability['talent'][] = 'Intimidation';
    $ability['talent'][] = 'Intuition';
    $ability['talent'][] = 'Leadership';
    $ability['talent'][] = 'Streetwise';
    $ability['talent'][] = 'Subterfuge';
    $ability['skill'][] = 'Animal Ken';
    $ability['skill'][] = 'Crafts';
    $ability['skill'][] = 'Demolitions';
    $ability['skill'][] = 'Drive';
    $ability['skill'][] = 'Etiquette';
    $ability['skill'][] = 'Firearms';
    $ability['skill'][] = 'Larceny';
    $ability['skill'][] = 'Meditation';
    $ability['skill'][] = 'Melee';
    $ability['skill'][] = 'Performance';
    $ability['skill'][] = 'Stealth';
    $ability['skill'][] = 'Survival';
    $ability['skill'][] = 'Technology';
    $ability['knowledge'][] = 'Academics';
    $ability['knowledge'][] = 'Computer';
    $ability['knowledge'][] = 'Cosmology';
    $ability['knowledge'][] = 'Enigmas';
    $ability['knowledge'][] = 'Finance';
    $ability['knowledge'][] = 'Investigation';
    $ability['knowledge'][] = 'Law';
    $ability['knowledge'][] = 'Medicine';
    $ability['knowledge'][] = 'Occult';
    $ability['knowledge'][] = 'Politics';
    $ability['knowledge'][] = 'Religion';
    $ability['knowledge'][] = 'Science';


    ?>

    <script type="text/javascript">
        $(document).ready(function () {
            character.init();
        });
    </script>
<div id="characterSheetWrapper">
    <div id="venues">
        <h2>Select Venues</h2>
        <div id="venueSelected"></div>
        <div id="venueOptions"></div>
        <h3>Do you wish to proceed with this character?</h3>
        <button class="venue-button venue-reset">Reset</button>
        <button class="venue-button venue-continue">Continue</button>
        <span class="clear"></span>
    </div>

    <div id="characterSheet">
        <div class="section columns-two">
            <h3>Character Details</h3>

            <div class="column column-first">
            <span class="row">
                <label for="name">Character Name</label>
                <input type="text" id="name" name="name"/>
            </span>
            <span class="row">
                <label for="sex">Sex</label>
                <select name="sex" id="sex">
                    <option value="female">Female</option>
                    <option value="male">Male</option>
                    <option value="unknown">Unknown</option>
                </select>
            </span>
            <span class="row">
                <label for="dateofbirth">Date of Birth</label>
                <input type="text" id="dateofbirth" name="dateofbirth" class="datepicker"/>
            </span>
            <span class="row">
                <label for="age">Apparent Age</label>
                <input type="text" id="age" name="age" class="short"/>
            </span>
            <span class="row">
                <label for="nature">Nature</label>
                <input type="text" id="nature" name="nature"/>
            </span>
            <span class="row">
                <label for="demeanor">Demeanor</label>
                <input type="text" id="demeanor" name="demeanor"/>
            </span>
            </div>
            <div class="column column-last">
            <span class="row">
                <label for="">Essence</label>
                <input type="text" id="" name=""/>
            </span>
            <span class="row">
                <label for="">Eidolon</label>
                <input type="text" id="" name=""/>
            </span>
            <span class="row">
                <label for="faction">Faction</label>
                <input type="text" id="faction" name="faction"/>
            </span>
            <span class="row">
                <label for="">Methodology</label>
                <input type="text" id="" name=""/>
            </span>
            <span class="row">
                <label for="visage">Visage</label>
                <select id="visage"></select>
            </span>
            <span class="row">
                <label for="concept">Concept</label>
                <input type="text" id="concept" name="concept" />
            </span>
            <span class="row">
                <label for="paradigm">Paradigm Summary</label>
                <input type="text" id="paradigm" name="paradigm" />
            </span>
            <span class="row">
                <label for="description">Description</label>
                <textarea id="description" name="description"></textarea>
            </span>
            <span class="row">
                <label for=""></label>
                <input type="text" id="" name=""/>
            </span>
            <span class="row">
                <label for=""></label>
                <input type="text" id="" name=""/>
            </span>
            </div>
        </div>
        <div class="section columns-three" id="attributes">
            <h3>Attributes</h3>

            <div class="column column-first" id="physical">
            <span class="row dot-row" id="strength">
                <label>Strength</label>
                <input type="text" class="specialisation"/>
                <span class="dot-block" data-min="1" data-max="5" data-initial="1" data-type="dot"></span>
            </span>
            <span class="row dot-row" id="dexterity">
                <label>Dexterity</label>
                <input type="text" class="specialisation"/>
                <span class="dot-block" data-min="1" data-max="5" data-initial="1" data-type="dot"></span>
            </span>
            <span class="row dot-row" id="stamina">
                <label>Stamina</label>
                <input type="text" class="specialisation"/>
                <span class="dot-block" data-min="1" data-max="5" data-initial="1" data-type="dot"></span>
            </span>
            </div>
            <div class="column column" id="social">
            <span class="row dot-row" id="charisma">
                <label>Charisma</label>
                <input type="text" class="specialisation"/>
                <span class="dot-block" data-min="1" data-max="5" data-initial="1" data-type="dot"></span>
            </span>
            <span class="row dot-row" id="manipulation">
                <label>Manipulation</label>
                <input type="text" class="specialisation"/>
                <span class="dot-block" data-min="1" data-max="5" data-initial="1" data-type="dot"></span>
            </span>
            <span class="row dot-row" id="appearance">
                <label>Appearance</label>
                <input type="text" class="specialisation"/>
                <span class="dot-block" data-min="0" data-max="5" data-initial="1" data-type="dot"></span>
            </span>
            </div>
            <div class="column column-last" id="mental">
            <span class="row dot-row" id="perception">
                <label>Perception</label>
                <input type="text" class="specialisation"/>
                <span class="dot-block" data-min="1" data-max="5" data-initial="1" data-type="dot"></span>
            </span>
            <span class="row dot-row" id="intelligence">
                <label>Intelligence</label>
                <input type="text" class="specialisation"/>
                <span class="dot-block" data-min="1" data-max="5" data-initial="1" data-type="dot"></span>
            </span>
            <span class="row dot-row" id="wits">
                <label>Wits</label>
                <input type="text" class="specialisation"/>
                <span class="dot-block" data-min="1" data-max="5" data-initial="1" data-type="dot"></span>
            </span>
            </div>
        </div>
        <div class="section columns-three" id="abilities">
            <h3>Abilities</h3>
            <?php

            foreach ($ability as $k => $v) {
                echo '<div class="column '.($k == "talent"?'column-first':($k == "knowledge"?'column-last':'')).'" id="'.$k.'">'."\n";
                foreach ($v as $x => $a) {
                    echo '<span class="row dot-row" id="'.strtolower(str_replace(' ', '-', $a)).'">'."\n";
                    echo '<label>'.$a.'</label>'."\n";
                    echo '<input type="text" class="specialisation" />'."\n";
                    echo '<span class="dot-block" data-min="0" data-max="5" data-initial="0" data-type="dot"></span>'."\n";
                    echo '</span>'."\n";
                }
                echo '</div>'."\n";
            }

            ?>
        </div>
        <span class="clear"></span>
    </div>


</div>













<?php
}
?>