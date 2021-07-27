<?php

namespace Nrz\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Nrz\Product\Models\AttributeValue;

class OrderRequest extends FormRequest
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
        if (request()->method == 'PATCH'){
            return [
                "product"=>['nullable','exists:products,name'],
                "options"=>['required_with:product',"array"],
                "options.*.attribute"=>["required_with:product","string","exists:attributes,name"],
                "options.*.value"=>["required_with:product","string",
                    Rule::exists("attribute_values","value")
                ],
                "consume_location"=>['nullable',"string"],
                "quantity"=>"required"

            ];
        }else{
            return [

                "product"=>['required','exists:products,name'],
                "options"=>['required',"array"],
                "options.*.attribute"=>["required","string","exists:attributes,name"],
                "options.*.value"=>["required","string",
                    Rule::exists("attribute_values","value")
                ],
                "consume_location"=>['required',"string"],
                "quantity"=>"required"
            ];
        }

    }
}
