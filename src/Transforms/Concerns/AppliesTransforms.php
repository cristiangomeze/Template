<?php

namespace Cristiangomeze\Template\Transforms\Concerns;

use InvalidArgumentException;
use NumberToWords\NumberToWords;

trait AppliesTransforms
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

        $numberTransformer = (new NumberToWords())->getNumberTransformer(config('template.to_words.currency_locale'));

        return __(':day_in_word (:day) :day_or_days del mes de :month_in_word del año :year_in_word (:year)', [
            'day_in_word' => ucwords($numberTransformer->toWords($date->day)),
            'day' => $date->day,
            'day_or_days' => $date->day > 1 ? 'Días' : 'Día',
            'month_in_word' => ucfirst($date->isoformat('MMMM')),
            'year_in_word' => ucwords($numberTransformer->toWords($date->year)),
            'year' => $date->year,
        ]);
    }

    public function appliesNumberWords($value, $parameters)
    {
        $currencyTransformer = (new NumberToWords())->getCurrencyTransformer(config('template.to_words.currency_locale'));

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
