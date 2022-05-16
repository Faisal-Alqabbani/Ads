<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'title' => 'required|max:50',
            'text' => 'required',
            'price' => 'required|numeric|digits_between:2,11',
            'images' => 'mimes:jpeg,bmp,png',
        ];
    }

    public function messages(){
        return [
            'title.required' => 'حقل العنوان فارغ',
            'title.max' => 'max',
            'text.required' => 'حقل الوصف فارغ',
            'price.required' => 'حقل السعر فارغ',
            'images.mimes' => 'صيغة الملف يجب ان تكون jpg png',
        ];
    }
}
