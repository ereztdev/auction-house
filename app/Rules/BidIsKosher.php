<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BidIsKosher implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $maxBidForItem;
    private $item;

    public function __construct($item)
    {
        $this->item = $item;
        $this->maxBidForItem = $this->item->min_price;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        if ($this->item &&
            $this->maxBidForItem &&
            $value > 0 &&
            $value < 1000000
        )
            return $value > $this->maxBidForItem && $value > 0 && $value < 1000000; //smaller than a million is 100% arbitrary
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "bid should be a positive non-zero integer, higher than {$this->maxBidForItem} and lower than a million" ;
    }
}
