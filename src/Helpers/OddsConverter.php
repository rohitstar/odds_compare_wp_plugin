<?php
namespace OddsCompare\Helpers;

class OddsConverter {
    public static function decimalToFractional(float $decimal): string {
        $epsilon = 1e-9;
        $value = $decimal - 1.0;
        $den = 1000;
        $num = round($value * $den);
        $g = self::gcd($num, $den);
        $num /= $g;
        $den /= $g;
        return sprintf('%d/%d', $num, $den);
    }

    public static function fractionalToDecimal(string $fraction): float {
        list($n, $d) = explode('/', $fraction);
        return 1 + (floatval($n) / floatval($d));
    }

    public static function decimalToAmerican(float $decimal): int {
        if ($decimal >= 2.0) {
            return (int) round(($decimal - 1.0) * 100);
        }
        return (int) round(-100 / ($decimal - 1.0));
    }

    public static function americanToDecimal(int $american): float {
        if ($american > 0) {
            return 1 + ($american / 100.0);
        }
        return 1 + (100.0 / abs($american));
    }

    private static function gcd(int $a, int $b): int {
        while ($b != 0) {
            $t = $b;
            $b = $a % $b;
            $a = $t;
        }
        return $a;
    }
}