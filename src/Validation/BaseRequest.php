<?php

namespace PerfectOblivion\ActionServiceResponder\Validation;

use Illuminate\Foundation\Http\FormRequest;
use PerfectOblivion\ActionServiceResponder\Validation\Traits\PreparesCustomRulesForFormRequest;
use PerfectOblivion\ActionServiceResponder\Validation\Traits\SanitizesInput;

class BaseRequest extends FormRequest
{
    use SanitizesInput, PreparesCustomRulesForFormRequest;

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->sanitizeData();

        $this->beforeValidation();

        return $this->validationData();
    }

    /**
     * Run any logic needed prior to validation running.
     */
    protected function beforeValidation()
    {
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    protected function validationData()
    {
        return $this->all();
    }

    /**
     * Transform the request data if necessary.
     *
     * @param  array  $data
     *
     * @return array
     */
    protected function transform($data)
    {
        return $data;
    }
}
