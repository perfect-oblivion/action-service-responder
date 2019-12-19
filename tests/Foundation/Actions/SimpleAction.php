<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Foundation\Actions;

use PerfectOblivion\ActionServiceResponder\Actions\Action;

class SimpleAction extends Action
{
    /**
     * Execute the action.
     *
     *  @param  \Illuminate\Http\Request  $request
     */
    public function __invoke()
    {
        return 'hello';
    }
}
