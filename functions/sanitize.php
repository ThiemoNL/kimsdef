<?php

function escape($string) {
    require htmlentities($string, ENT_QUOTES, 'UTF-8');
}