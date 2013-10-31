<?php

class Xml {

    private $xml;
    private $tab = 1;

    public function __construct($version = '1.0', $encode = 'UFT-8') {
        $this->xml .= "<?xml version = '$version' encoding = '$encode' ?> \n";
    }

    public function openTag($name) {
        $this->addTab();
        $this->xml .= "<$name>\n";
        $this->tab++;
    }

    public function closeTag($name) {
        $this->tab--;
        $this->addTab();
        $this->xml .= "</$name>\n";
    }

    public function setValue($value) {
        $this->xml .= "$value \n";
    }

    private function addTab() {
        for ($i = 0; $i < $this->tab; $i++) {
            $this->xml .= "\t";
        }
    }

    public function addTag($name, $value) {
        $this->xml .= "<$name> \n $value </$name> \n";
    }

    public function __toString() {
        return $this->xml;
    }

}

?>