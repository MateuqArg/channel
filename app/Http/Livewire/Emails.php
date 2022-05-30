<?php

namespace App\Http\Livewire;

use Livewire\{Component, WithFileUploads};
use App\Models\Email;
use App\Jobs\SendEmail;
use Carbon\Carbon;
use Storage;

class Emails extends Component
{
    use WithFileUploads;
    public $event, $email, $file, $name, $subject, $content, $date;
    public $listeners = ['selected', 'destroy', 'refresh' => '$refresh'];

    protected $rules = [
        'email.name' => 'required',
        'email.subject' => 'required',
        'email.content' => 'required',
        'email.date' => 'required',
        'file' => '',
    ];

    public function mount(Email $email)
    {
        $this->email = $email;
    }

    public function render()
    {
        return view('livewire.email.email');
    }

    public function create()
    {
        $this->validate([
            'name' => 'required',
            'subject' => 'required',
            'date' => 'required',
            'content' => 'required',
        ]);

        $file = Storage::disk('public_uploads')->put('/', $this->content);

        $email = new Email([
            'name' => $this->name,
            'subject' => $this->subject,
            'content' => basename($file),
            'date' => $this->date,
            'event_id' => $this->event->id,
            'objective' => 'all',
        ]);
        $email->save();

        $date = Carbon::create($this->date);
        SendEmail::dispatch($email->id)->onConnection('database')->delay($date);

        $this->emit('alert', ['title' => '¡Uno más!', 'text' => 'El correo ha sido dado de alta', 'type' => 'success']);
        $this->emit('refresh');
    }

    public function update($id)
    {
        $email = Email::find($id);

        if (null !== $this->email->name) {
            $email->name = $this->email->name;
        }
        if (null !== $this->email->subject) {
            $email->subject = $this->email->subject;
        }
        if (null !== $this->email->content) {
            $file = Storage::disk('public_uploads')->put('/', $this->file);
            $email->content = basename($file);
            // $email->content = $this->email->content;
        }

        if (null !== $this->email->type) {
            $email->type = $this->email->type;
        }
        if (null !== $this->email->date) {
            $email->date = $this->email->date;
        }
        $email->update();

        $this->emit('alert', ['title' => '¡Arreglado!', 'text' => 'El correo ha sido modificado correctamente', 'type' => 'success']);
        $this->emit('refresh');
    }

    public function destroy($id)
    {
        Email::destroy($id);

        $this->emit('alert', ['title' => '¡Adiós!', 'text' => 'El correo ha sido eliminado', 'type' => 'success']);
        $this->emit('refresh');
    }

    public function selected($id)
    {
        $email = Email::find($id);

        $this->email->name = $email->name;
        $this->email->subject = $email->subject;
        $this->email->content = $email->content;
        $this->email->date = $email->date;
    }
}
