<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class Paillier
{
    private $n, $nSq, $g, $lambda, $mu;

    public function __construct()
    {
        // Store keys in cache so they are generated only once
        $keys = Cache::rememberForever('paillier_keys', function () {
            return $this->generateKeys();
        });
        $this->n    = \gmp_init($keys['n']);
        $this->nSq  = \gmp_init($keys['n_sq']);
        $this->g    = \gmp_init($keys['g']);
        $this->lambda = \gmp_init($keys['lambda']);
        $this->mu   = \gmp_init($keys['mu']);
    }

    /**
     * Generate 2048-bit Paillier key pair.
     */
    public function generateKeys($bits = 2048)
    {
        $p = $this->randomPrime($bits / 2);
        $q = $this->randomPrime($bits / 2);
        while (\gmp_cmp($p, $q) === 0) {
            $q = $this->randomPrime($bits / 2);
        }

        $n = \gmp_mul($p, $q);
        $nSq = \gmp_mul($n, $n);
        $lambda = $this->lcm(\gmp_sub($p, 1), \gmp_sub($q, 1));
        $g = \gmp_add($n, 1); // g = n+1

        $x = \gmp_powm($g, $lambda, $nSq);
        $l = \gmp_div_q(\gmp_sub($x, 1), $n);
        $mu = \gmp_invert($l, $n);

        return [
            'n'      => \gmp_strval($n),
            'n_sq'   => \gmp_strval($nSq),
            'g'      => \gmp_strval($g),
            'lambda' => \gmp_strval($lambda),
            'mu'     => \gmp_strval($mu),
        ];
    }

    /**
     * Encrypt an integer (plaintext).
     */
    public function encrypt($plaintext)
    {
        $m = \gmp_init($plaintext);
        do {
            $r = \gmp_random_range(2, \gmp_sub($this->n, 1));
        } while (\gmp_cmp(\gmp_gcd($r, $this->n), 1) !== 0);

        $gm = \gmp_powm($this->g, $m, $this->nSq);
        $rn = \gmp_powm($r, $this->n, $this->nSq);
        $c = \gmp_mod(\gmp_mul($gm, $rn), $this->nSq);
        return \gmp_strval($c);
    }

    /**
     * Decrypt a ciphertext (returns plain integer as string).
     */
    public function decrypt($ciphertext)
    {
        $c = \gmp_init($ciphertext);
        $x = \gmp_powm($c, $this->lambda, $this->nSq);
        $l = \gmp_div_q(\gmp_sub($x, 1), $this->n);
        $m =    \gmp_mod(\gmp_mul($l, $this->mu), $this->n);
        return   \gmp_strval($m);
    }

    /**
     * Homomorphic addition: E(a) + E(b) = E(a+b)
     */
    public function add($c1, $c2)
    {
        $c1g = \gmp_init($c1);
        $c2g = \gmp_init($c2);
        $result = \gmp_mod(\gmp_mul($c1g, $c2g), $this->nSq);
        return \gmp_strval($result);
    }

    // ------------------- Helpers -------------------
    private function randomPrime($bits)
    {
        $min = \gmp_pow(2, $bits - 1);
        $max = \gmp_pow(2, $bits);
        do {
            $candidate = \gmp_random_range($min, $max);
            $candidate = \gmp_or($candidate, 1); // make odd
        } while (\gmp_prob_prime($candidate) < 1);
        return $candidate;
    }

    private function lcm($a, $b)
    {
        return \gmp_div_q(\gmp_mul($a, $b), \gmp_gcd($a, $b));
    }

}
