<?php

function num($n)
{
    if ($n <= 9) {
        return "P-00$n";
    }

    if ($n > 9 and $n < 99) {
        return "P-0$n";
    }

    if ($n > 99 and $n < 999) {
        return "P-$n";
    }

    return "P-$n";
}
