<?php
class JieqiFormTextArea extends JieqiFormElement {
var $_cols;
var $_rows;
var $_value;
function JieqiFormTextArea($caption,$name,$value="",$rows=5,$cols=50){
$this->setCaption($caption);
$this->setName($name);
$this->_rows = intval($rows);
$this->_cols = intval($cols);
$this->_value = $value;
}
function getRows(){
return $this->_rows;
}
function getCols(){
return $this->_cols;
}
function getValue(){
return $this->_value;
}
function render(){
return "<textarea class=\"textarea\" name=\"".$this->getName()."\" id=\"".$this->getName()."\" rows=\"".$this->getRows()."\" cols=\"".$this->getCols()."\"".$this->getExtra().">".$this->getValue()."</textarea>";
}
}
