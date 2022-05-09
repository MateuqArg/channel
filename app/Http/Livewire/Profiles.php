<?php

namespace App\Http\Livewire;

use Livewire\{Component, WithFileUploads};
use Storage;
use Auth;

class Profiles extends Component
{
    use WithFileUploads;
    public $name, $email, $phone, $avatar;
    public $listeners = ['autoload'];
    
    public function render()
    {
        $this->user = Auth::user();

        return view('livewire.profile');
    }

    public function update()
    {
        $user = $this->user;
        if($this->name) {
         $user->name = $this->name;   
        }
        if($this->email) {
         $user->email = $this->email;   
        }
        if($this->phone) {
         $user->phone = $this->phone;   
        }
        if($this->avatar) {
         $avatar = Storage::disk('public_uploads')->put('avatars', $this->avatar);
         $user->avatar = basename($avatar);
        }
        $user->save();
    }
    
    public function autoload()
    {
    //    $name = $this->user->name;
    //    $email = $this->user->email;
    //    $phone = $this->user->phone;
    }
}
