<?php
/**
 * File copied from Waavi/Sanitizer https://github.com/waavi/sanitizer
 * Sanitization functionality to be customized within this project before a 1.0 release.
 */

namespace PerfectOblivion\ActionServiceResponder\Validation\Sanitizer\Laravel;

trait SanitizesInput
{
    /**
     *  Sanitize input before validating.
     *
     *  Kept for backwards compatibility with Laravel <= 5.5
     */
    public function validate()
    {
        $this->sanitize();
        parent::validate();
    }

    /**
     *  Sanitize input before validating.
     *
     *  Compatible with Laravel 5.6+
     */
    public function validateResolved()
    {
        $this->sanitize();
        parent::validateResolved();
    }

    /**
     *  Sanitize this request's input.
     */
    public function sanitize()
    {
        $this->addCustomFilters();
        $this->sanitizer = app('sanitizer')->make($this->input(), $this->filters());
        $this->replace($this->sanitizer->sanitize());
    }

    /**
     *  Add custom fields to the Sanitizer.
     */
    public function addCustomFilters()
    {
        foreach ($this->customFilters() as $name => $filter) {
            app('sanitizer')->extend($name, $filter);
        }
    }

    /**
     *  Filters to be applied to the input.
     *
     *  @return array
     */
    public function filters()
    {
        return [];
    }

    /**
     *  Custom Filters to be applied to the input.
     *
     *  @return array
     */
    public function customFilters()
    {
        return [];
    }
}
