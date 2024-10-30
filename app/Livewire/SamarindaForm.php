<?php

namespace App\Livewire;

use App\Models\Pendaftar;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class SamarindaForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama')
                    ->required(),
                Forms\Components\TextInput::make('no_handphone')
                    ->label('No. Whatsapp')
                    ->required()
                    ->tel()
                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->email(),
                Forms\Components\TextInput::make('daerah')
                    ->label('Asal Daerah')
                    ->required(),
                Forms\Components\Textarea::make('pesan')
                    ->label('Harapan untuk Kaltim ke depan')
                    ->required(),
            ])
            ->statePath('data')
            ->model(Pendaftar::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = Pendaftar::create($data);

        $this->form->model($record)->saveRelationships();

        Notification::make()
            ->success()
            ->title('Selamat! Anda telah terdaftar!')
            ->seconds(5)
            ->send();

        $this->form->fill();
    }

    public function render(): View
    {
        return view('livewire.samarinda-form');
    }
}
