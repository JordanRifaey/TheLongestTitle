<?php

/**
 * TLTController.php
 *
 * Calculates the longest combination of movie titles based off of the array of titles returned from getTitles() in TLTDataModel.php.
 *
 * Rules:
 *   1) The last word of the current movie title must be the first word of the next movie title used.
 *      Example: 'Dusk Till Dawn' + 'Dawn of the Planet of the Apes' = 'Dusk Till Dawn of the Planet of the Apes'
 *   2) The program should keep track and display the top 10 combination titles.
 *   3) The longest title is determined by the number of combinations and not the length of string.
 *   4) Each movie can only be counted once.
 *
 * @author     Jordan Rifaey <contact@jordanrifaey.com>
 * @license    https://www.php.net/license/3_01.txt  PHP License 3.1
 */

require_once("TLTDataModel.php");

class TLTController {

    private $titles = array();
    private $results = array();

    function __construct() {
        //Get list of titles from DB.
        $dm = new TLTDataModel();
        $this->titles = $dm->getTitles();
        }

    public function getMovieTitleCombos() {
        //Find longest movie title combination for every title in array.
        foreach ($this->titles as $titleA) {
            $currentCombo = $titleA;
            $foundCombo = true;
            //Initialize comboCount to 0. This keeps track of the number of combinations to be used for sorting later. Will also be displayed in table on front-end.
            $comboCount = 0;

            //Recursively search for combo until no more are found.
            while ($foundCombo) {
                //Search the entire list
                foreach ($this->titles as $titleB) {
                    //Break out title string of current title into an array of words.
                    $currentComboExploded = explode(" ", $currentCombo);
                    //Store last word of current title.
                    $lastWordCurrentCombo = end($currentComboExploded);
                    //Break out the title to be compared into an array of words.
                    $titleBExploded = explode(" ", $titleB);
                    //Store first word of title to be compared.
                    $firstWordB = $titleBExploded[0];
                    //Check if the last word of the current title equals the first word of the title to be compared. Also make sure they don't equal each other.
                    if (($lastWordCurrentCombo == $firstWordB) && ($currentComboExploded != $titleBExploded)) {
                        //If we are in this code block, that means a match has been found! :D
                        //Remove last word of current title to prevent duplicate words from appearing.
                        array_pop($currentComboExploded);
                        //Convert the array of words of the current title into a string.
                        $currentComboImploded = implode(" ", $currentComboExploded);
                        //The moment we've all been waiting for; Combine the current title and second title to make a new combination!
                        $currentCombo = $currentComboImploded . " " . $titleB;
                        //Add 1 to comboCount. This keeps track of the number of combinations to be used for sorting later. Will also be displayed in table on front-end.
                        $comboCount++;
                        //Remove the title we just compared from the master list of titles since it was used in a combo. This abides by rule 4 which states, "each movie can only be counted once".
                        unset($this->titles[array_search($titleB, $this->titles)]);
                    } else {
                        //Set $foundCombo to false to break out of while loop since we did not find a combo.
                        $foundCombo = false;
                    }
                }
            }
            //If we found a combo, store it in key/value array of results with the combo as the key and the number of combos as the key.
            if ($comboCount > 0) {
                $this->results[$currentCombo] = $comboCount;
            }
        }
        //Sort results by number of movie title combos.
        array_multisort($this->results, SORT_DESC);
        //Remove all titles from results except first 10.
        $this->results = array_slice($this->results, 0, 10);
        //Return the list of top 10 movie title combinations sorted by number of combinations.
        return $this->results;
    }

}
