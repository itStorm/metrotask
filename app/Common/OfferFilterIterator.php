<?php

namespace Metrotask\Common;

use Iterator;

class OfferFilterIterator extends \FilterIterator
{
    public const OPERATION_RANGE = 'range';

    /**
     * @var array
     */
    private $filter;

    /**
     * @param Iterator $iterator
     * @param array $filter
     */
    public function __construct(Iterator $iterator, array $filter)
    {
        parent::__construct($iterator);

        $this->filter = $filter + [
                'field' => null,
                'values' => [],
                'operator' => null,
            ];
    }

    /**
     * @return bool
     */
    public function accept(): bool
    {
        if (!$this->filter['field']) {
            return true;
        }
        /** @var AbstractOffer $element */
        $element = $this->getInnerIterator()->current();
        $value = $element->getField($this->filter['field']);

        if (
            (!$this->filter['operator'] && in_array($value, $this->filter['values'], false))
            || ($this->filter['operator'] === self::OPERATION_RANGE && $value >= $this->filter['values'][0] && $value <= $this->filter['values'][1])
        ) {
            return true;
        }
        return false;
    }
}