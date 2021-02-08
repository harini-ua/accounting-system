<?php

namespace App\View\Components;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Avatar extends Component
{
    protected $avatar;
    public $online;
    public $profile;

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
        $this->avatar = new \Laravolt\Avatar\Avatar();

        $this->profile = $profile;
        $this->online = $online;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $image = $this->avatar->create($this->user->name)->toBase64();

        return view('components.avatar', compact('image'));
    }
}
