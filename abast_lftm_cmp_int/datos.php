<?php
$html = "";

if ($_POST["category"]==1) {

    $html = '
    <option value="1">Camisas</option>
    <option value="2">Vestidos</option>
    <option value="3">Playeras</option>
    ';  
}

if ($_POST["category"]==2) {
    $html = '
    <option value="1">Relojes</option>
    <option value="2">Pulseras</option>
    <option value="3">Accesorios</option>
    ';  
}

if ($_POST["category"]==3) {
    $html = '
    <option value="1">Zapatillas</option>
    <option value="2">Zapatos</option>
    <option value="3">Sandalias</option>
    ';  
}
echo $html;
;?>