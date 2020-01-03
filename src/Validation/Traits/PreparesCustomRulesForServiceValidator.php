<?php

namespace PerfectOblivion\ActionServiceResponder\Validation\Traits;

use Illuminate\Support\Arr;
use PerfectOblivion\ActionServiceResponder\Validation\CustomRule;

trait PreparesCustomRulesForServiceValidator
{
    /**
     * Set the validator and service validator properties on Custom Rules.
     */
    public function prepareCustomRules()
    {
        collect($this->resolveAndCall($this, 'rules', $this->service->getSupplementals()))->each(function ($rules, $attribute) {
            collect(Arr::wrap($rules))->whereInstanceOf(CustomRule::class)->each(function ($rule) {
                $rule::validator($this->getValidator());
                $rule::service($this);
            });
        });
    }
}
