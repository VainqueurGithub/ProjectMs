<?php

namespace App\Http\Livewire;
use App\Http\Livewire\FileUpload;
use Livewire\Component;
use App\Models\Repportage;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RepportageImport;
class FileUpload extends Component
{   
	use WithFileUploads;
    public $fichier;

    public $description;

    public $sample = [];
 
 
    public function updated($propertyName)

    {

        $this->validateOnly($propertyName, [

            'fichier' => 'required|max:1024',
        ]);

    }

 

    public function saveFile()

    {

        $validatedData = $this->validate([
           'fichier' => 'required|max:1024',

        ]);
        // $data = Excel::load(Input::file('fichier'), function($reader) {})->get();
        // Excel::import(new RepportageImport, $this->file('file'));
        
       $path = request()->file('fichier');
       $path1 = Excel::make($path->getRealPath());
       
        set_time_limit(0); 
        Excel::import(new RepportageImport,$path1);
   }
}
