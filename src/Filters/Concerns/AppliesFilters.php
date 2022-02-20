<?php

namespace Cristiangomeze\Template\Filters\Concerns;

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
    public function appliesDateWords($value, $parameters)
    {
        $date = null == $value
            ? now()
            : now()->parse($value);

        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer(config('template.to_words.currency_locale'));

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

    public function appliesNumberWords($value, $parameters)
    {
        $numberToWords = new NumberToWords();
        $currencyTransformer = $numberToWords->getCurrencyTransformer(config('template.to_words.currency_locale'));

        return config('template.to_words.currency_symbol').' ' .number_format($value, 2).', ('.ucfirst($currencyTransformer->toWords($value * 100, config('template.to_words.currency'))).')';
    }

    public function appliesNumberFormat($value, $parameters)
    {
        $decimal = count($parameters) == 1 ? $parameters[0] : 0;

        return number_format($value, $decimal);
    }

    public function appliesDateFormat($value, $parameters)
    {
        return now()->parse($value)->isoFormat($parameters[0]);
    }

    public function appliesLowercase($value, $parameters)
    {
        return mb_strtolower($value);
    }

    public function appliesUppercase($value, $parameters)
    {
        return mb_strtoupper($value);
    }

    public function appliesCapitalize($value, $parameters)
    {
        return ucwords($value);
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
