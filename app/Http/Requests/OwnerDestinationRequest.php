<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OwnerDestinationRequest extends FormRequest
{
    public static function jawaTengahCities(): array
    {
        return [
            'Semarang',
            'Surakarta',
            'Kota Salatiga',
            'Kota Magelang',
            'Kota Pekalongan',
            'Kota Tegal',
            'Kabupaten Banjarnegara',
            'Kabupaten Banyumas',
            'Kabupaten Batang',
            'Kabupaten Blora',
            'Kabupaten Boyolali',
            'Kabupaten Brebes',
            'Kabupaten Cilacap',
            'Kabupaten Demak',
            'Kabupaten Grobogan',
            'Kabupaten Jepara',
            'Kabupaten Karanganyar',
            'Kabupaten Kebumen',
            'Kabupaten Kendal',
            'Kabupaten Klaten',
            'Kabupaten Kudus',
            'Kabupaten Pati',
            'Kabupaten Pekalongan',
            'Kabupaten Pemalang',
            'Kabupaten Purbalingga',
            'Kabupaten Purworejo',
            'Kabupaten Rembang',
            'Kabupaten Semarang',
            'Kabupaten Sragen',
            'Kabupaten Sukoharjo',
            'Kabupaten Tegal',
            'Kabupaten Temanggung',
            'Kabupaten Wonogiri',
            'Kabupaten Wonosobo',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', Rule::in(self::jawaTengahCities())],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['exists:tags,id'],
            'custom_tags' => ['nullable', 'string', 'max:255'],
            'map_link' => ['nullable', 'url', 'max:255'],
            'open_time' => ['required'],
            'close_time' => ['required', 'after:open_time'],
            'images' => ['nullable', 'array', 'max:8'],
            'images.*' => ['image', 'max:5120'],
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->hasFile('images')) {
                $destination = $this->route('destination');
                $existingCount = $destination ? $destination->images()->count() : 0;
                $newCount = count($this->file('images', []));

                if ($existingCount + $newCount > 8) {
                    $validator->errors()->add('images', "Total foto destinasi tidak boleh melebihi 8 foto. Saat ini destinasi memiliki {$existingCount} foto, dan Anda mencoba mengunggah {$newCount} foto baru.");
                }
            }
        });
    }
}
