<?php

/*
 * Create an array primes from 2 to $max.
 */
function sieve($max)
{
    $numbers = [];
    for ($i = 2; $i <= sqrt($max); $i++){
        if (!isset($numbers[$i])) {
            for ($j = pow($i,2); $j <= $max; $j = $j+$i) {
                $numbers[$j] = true;
            }
        }
    }

    $primes = [];
    for ($i = 2; $i <= $max; $i++) {
        if (!isset($numbers[$i])) {
            $primes[] = $i;
        }
    }

    return $primes;
}
