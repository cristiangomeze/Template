<?php

namespace Thepany\Template\Filters\Concerns;

use InvalidArgumentException;
use NumberToWords\NumberToWords;

trait AppliesFilters
{
    /**
     * Convert a date in its letter representation.
     *
     * @param  mixed  $value
     * @param  mixed  $parameters
     * @return bool
     */
    public function appliesDateLetter($value, $parameters)
    {
        $date = null == $value
            ? now()
            : now()->parse($value);

        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('es');

        $dateLetter = ucwords($numberTransformer->toWords($date->day));
        $dateLetter .= " ({$date->day}) ";
        $dateLetter .= $date->day > 1 ? 'Días ' : 'Día ';
        $dateLetter .= 'del mes de ';
        $dateLetter .= ucfirst($date->isoformat('MMMM'));
        $dateLetter .= ' del año ';
        $dateLetter .= ucwords($numberTransformer->toWords($date->year));
        $dateLetter .= " ({$date->year})";

        return $dateLetter;

    }

    public function appliesNumberLetter($value, $parameters)
    {
        $numberToWords = new NumberToWords();
        $currencyTransformer = $numberToWords->getCurrencyTransformer('es');

        return 'RD$ ' .number_format($value, 2) .', ('. ucfirst($currencyTransformer->toWords($value * 100, 'DOP')) .')';
    }

    public function appliesNumberFormat($value, $parameters)
    {
        $decimal = count($parameters) == 1 ? $parameters[0] : 0;

        return number_format($value, $decimal);
    }

    private function appliesDateFormat($value, $parameters)
    {
        return now()->parse($value)->isoFormat($parameters[0]);
    }

    /**
     * Require a certain number of parameters to be present.
     *
     * @param  int    $count
     * @param  array  $parameters
     * @param  string  $rule
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    protected function requireParameterCount($count, $parameters, $rule)
    {
        if (count($parameters) < $count) {
            throw new InvalidArgumentException("Validation rule $rule requires at least $count parameters.");
        }
    }

}
