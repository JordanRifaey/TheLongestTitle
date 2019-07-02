<?php
require_once("TLTDataModel.php");

class TLTController {

    private $titles = array();
    private $results = array();

    function __construct() {
        $dm = new TLTDataModel();
        $this->titles = $dm->getTitles();
        }

    public function getTheLongestTitles() {
        foreach ($this->titles as $titleA) {
            $currentCombo = $titleA;
            $foundCombo = true;
            $comboCount = 0;
            while ($foundCombo) {
                foreach ($this->titles as $titleB) {
                    $currentComboExploded = explode(" ", $currentCombo);
                    $lastWordCurrentCombo = end($currentComboExploded);
                    $titleBExploded = explode(" ", $titleB);
                    $firstWordB = $titleBExploded[0];
                    if (($lastWordCurrentCombo == $firstWordB) && ($currentComboExploded != $titleBExploded)) {
                        if (sizeof($titleBExploded) > 1) {
                            array_pop($currentComboExploded);
                        }
                        $currentComboImploded = implode(" ", $currentComboExploded);
                        $currentCombo = $currentComboImploded . " <-> " . $titleB;
                        $comboCount++;
                        unset($this->titles[array_search($titleB, $this->titles)]);
                    } else {
                        $foundCombo = false;
                    }
                }
            }
            if ($comboCount > 0) {
                $this->results[$currentCombo] = $comboCount;
            }
        }

        array_multisort($this->results, SORT_DESC);
        $this->results = array_slice($this->results, 0, 10);
        return $this->results;
    }

}
