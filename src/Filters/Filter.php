<?php

namespace Thepany\Template\Filters;

use Illuminate\Validation\ValidationRuleParser;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class Filter implements Arrayable
{
    use Concerns\AppliesFilters;

    protected $values;

    /**
     * Filters available for formatting fields values
     *
     * @var array
     */
    protected $filterAvailable = [
        'DateLetter', 'DateFormat', 'NumberLetter', 'NumericFormat',
    ];

    public function __construct($values)
    {
        $this->values = $values instanceof Collection
            ? $this->values = $values
            : new Collection($values);
    }

    public static function make($values)
    {
        return new self($values);
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return $this->getValues();
    }

    protected function getValues()
    {
        return $this->values->each(function ($value) {
            $this->hasKeys($value);
        })->map(function ($item) {
            return $this->getFilterValue($item);
        });
    }

    protected function getFilterValue(Array $item)
    {
        return [
            $item['key'] => $this->applyFilter(
                $item['value'],
                $item['filters']
            )
        ];
    }

    protected function applyFilter($value, array $filters)
    {
        foreach ($filters as $filter) {
            [$filter, $parameters] = ValidationRuleParser::parse($filter);

            if ($this->canNotApplyFilter($filter)) {
                break;
            }

            $method = "applies{$filter}";
            $value = $this->$method($value, $parameters);
        }

        return $value;
    }

    protected function canNotApplyFilter($filter)
    {
        return $filter == '' || $this->filterNotExists($filter);
    }

    protected function filterNotExists($filter)
    {
        return ! in_array($filter, $this->filterAvailable);
    }

    protected function hasKeys(array $value)
    {
        if (! array_key_exists('key',  $value)
            && ! array_key_exists('value',  $value)
            && ! array_key_exists('filters',  $value)
        ) {
            throw new \Exception("Some of the following indexes were not found: key, value, filter.");
        }
    }
}
