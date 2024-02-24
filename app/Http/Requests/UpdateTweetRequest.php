<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
// 2行追加
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateTweetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;
        // 変更
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // 追加
        return [
            'tweet' => 'required|string|max:255',
        ];
    }

    // 追加（エラーメッセージを定義する）
    public function messages()
    {
        return [
            'tweet.required' => 'Tweet を入力してくださいね．',
            'tweet.string' => 'Tweet は文字列で入力してくださいね．',
            'tweet.max' => 'Tweet は255文字以下で入力してくださいね．',
        ];
    }
    
    // 追加（Api経由でのエラー時のレスポンスをJSON形式に変更する）
    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            $response = response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
            throw new HttpResponseException($response);
        }
        parent::failedValidation($validator);
    }
}
