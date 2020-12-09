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
    $factorization = [];
    for ($i = 2; $i <= $max; $i++) {
        if (!isset($numbers[$i])) {
            $primes[] = $i;
            echo $i . PHP_EOL;
        } else { //$i is not prime
            $value = $i;
            echo $i;
            $factorization[$i] = [];
            foreach ($primes as $prime) {
                while($value % $prime === 0) {
                    if (!isset($factorization[$i][$prime])) {
                        $factorization[$i][$prime] = 0;
                    }
                    $factorization[$i][$prime]++;
                    $value = intdiv($value, $prime); 
                }
            }

            foreach ($factorization[$i] as $factor => $exp) {
                echo ' ' . $factor . '^' . $exp;
            }

            echo PHP_EOL;
        }
    }

    return $primes;
}

sieve(1000);