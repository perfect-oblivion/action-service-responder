<?php

namespace PerfectOblivion\ActionServiceResponder\Validation\Traits;

use Illuminate\Support\Arr;
use PerfectOblivion\ActionServiceResponder\Validation\CustomRule;

trait PreparesCustomRulesForFormRequest
{
    /**
     * Set the validator and request properties on Custom Rules.
     */
    public function prepareCustomRules()
    {
        collect($this->rules())->each(function ($rules, $attribute) {
            collect(Arr::wrap($rules))->whereInstanceOf(CustomRule::class)->each(function ($rule) {
                $rule::validator($this->getValidatorInstance());
                $rule::request($this);
            });
        });
    }
}
