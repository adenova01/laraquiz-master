<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class AttemptButton extends AbstractAction
{
    public function getTitle()
    {
        // Action title which display in button based on current status
        return 'Attempt';
    }

    public function getIcon()
    {
        // Action icon which display in left of button based on current status
        return 'voyager-edit';
    }

    public function getAttributes()
    {
        // Action button class
        return [
            'class' => 'btn btn-sm btn-success pull-right',
        ];
    }

    public function shouldActionDisplayOnDataType()
    {
        // show or hide the action button, in this case will show for posts model
        return $this->dataType->slug == '';
    }

    public function getDefaultRoute()
    {
        // URL for action button when click
        return route('voyager.qbanks.edit', array("id"=>$this->id));
    }
}