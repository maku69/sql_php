<?php
class Auto {
var $varv;
var $tootja;
var $speed;
function __construct($varv, $tootja) {
$this->varv = $varv;
$this->tootja = $tootja;
$this->speed = 0;
}
function kaas_põhja() {
while ($this->speed < 100) {
$this->speed += 10;
echo "kiirus: " . $this->speed . "<br>";
}
}
}
$oppur1 = new Auto("punane", "audi");
echo "minu uus " . $oppur1->tootja . " on " . $oppur1->varv . ".<br>";
$oppur1->kaas_põhja();
?>