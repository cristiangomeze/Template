<?php

namespace Cristiangomeze\Template\Transforms;

use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationRuleParser;

class Transform implements Arrayable
{
    use Concerns\AppliesTransforms;

    protected $values;

    /**
     * Transforms available for formatting fields values
     *
     * @var array
     */
    protected $transformAvailable = [
        'DateWords',
        'DateFormat',
        'NumberWords',
        'NumberFormat',
        'Lowercase',
        'Uppercase',
        'Capitalize',
    ];

    public function __construct($values)
    {
        $this->values = Collection::wrap($values);
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
        return $this->getValues()
            ->collapse()
            ->toArray();
    }

    protected function getValues()
    {
        return $this->values
            ->each(fn ($value) => $this->hasKeys($value))
            ->map(fn ($item) => $this->getFormattedValues($item));
    }

    protected function getFormattedValues(array $item)
    {
        return [
            $item['key'] => $this->applyTransform(
                $item['value'],
                $item['transforms']
            ),
        ];
    }

    protected function applyTransform($value, array $filters)
    {
        foreach ($filters as $filter) {
            [$filter, $parameters] = ValidationRuleParser::parse($filter);

            if ($this->canNotApplyTransform($filter)) {
                break;
            }

            $method = "applies{$filter}";
            $value = $this->$method($value, $parameters);
        }

        return $value;
    }

    protected function canNotApplyTransform($filter)
    {
        return $filter == '' || $this->transformNotExists($filter);
    }

    protected function transformNotExists($filter)
    {
        return ! in_array($filter, $this->transformAvailable);
    }

    protected function hasKeys(array $value)
    {
        if (! array_key_exists('key',  $value)
            && ! array_key_exists('value',  $value)
            && ! array_key_exists('transforms',  $value)
        ) {
            throw new Exception("Some of the following indexes were not found: key, value, transform.");
        }
    }
}
