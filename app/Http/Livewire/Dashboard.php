<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Dashboard extends Component
{  
	 public $count;

	 public function mount(){
	 	$this->count = 0;
	 }
 

    public function increment()

    {

        $this->count++;

    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
