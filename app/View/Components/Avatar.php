<?php

namespace App\View\Components;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Avatar extends Component
{
    public $user;
    public $online;
    public $profile;

    private $avatar;

    /**
     * Create a new component instance.
     *
     * @param User|null $user
     * @param bool      $profile
     * @param bool      $online
     *
     */
    public function __construct(User $user = null, $profile = false, $online = true)
    {
        $this->user = $user ?? Auth::user();
        $this->profile = $profile;
        $this->online = $online;

        $this->avatar = new \Laravolt\Avatar\Avatar();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $image = null;
        if(isset($this->user->name)) {
            $image = $this->avatar->create($this->user->name)->toBase64();
        }
        return view('components.avatar', compact('image'));
    }
}
