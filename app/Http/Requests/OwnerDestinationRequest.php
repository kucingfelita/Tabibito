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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
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
            'open_time' => ['required', 'date_format:H:i'],
            'close_time' => ['required', 'date_format:H:i', 'after:open_time'],
            'image' => ['nullable', 'image', 'max:5120'],
        ];
    }
}
