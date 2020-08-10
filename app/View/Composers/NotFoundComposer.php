<?php

namespace App\View\Composers;

use Illuminate\View\View;

class NotFoundComposer
{
    public function compose(View $view)
    {
        return $view
            ->with('breadcrumbs', [
                ['link' => route('home'), 'name' => __('Home')],
                ['link' => route('contracts.index'), 'name' => __('Error')],
            ])
            ->with('pageConfigs', ['pageHeader' => true]);
    }
}