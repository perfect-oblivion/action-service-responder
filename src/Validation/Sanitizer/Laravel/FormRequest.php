<?php
/**
 * File copied from Waavi/Sanitizer https://github.com/waavi/sanitizer
 * Sanitization functionality to be customized within this project before a 1.0 release.
 */

namespace PerfectOblivion\Valid\Sanitizer\Laravel;

use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;
use PerfectOblivion\ActionServiceResponder\Validation\Sanitizer\Sanitizer;

class FormRequest extends LaravelFormRequest
{
    /**
     * Sanitize input before validating.
     */
    public function validate()
    {
        $this->sanitize();
        parent::validate();
    }

    /**
     * Sanitize this request's input.
     */
    public function sanitize()
    {
        $this->sanitizer = Sanitizer::make($this->input(), $this->filters());
        $this->replace($this->sanitizer->sanitize());
    }

    /**
     * Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        return [];
    }

    /**
     * Validation rules to be applied to the input.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
