<?php


namespace Core\ValidationRules;


use Illuminate\Database\Eloquent\Model;
use Rakit\Validation\Rule;

class UniqueRule extends Rule
{
    protected $message = ":attribute :value has been used";

    protected $fillableParams = ['model', 'field'];

    /**
     * @throws \Rakit\Validation\MissingRequiredParameterException
     */
    public function check($value): bool
    {
        // make sure required parameters exists
        $this->requireParameters(['model', 'field']);

        // getting parameters
        $modelName = $this->parameter('model');
        $field = $this->parameter('field');

        $modelClass = MODELS_NAMESPACE . $modelName;
        /** @var Model $model */
        $model = new $modelClass;

        $modelWithSameValue = $model::where($field, $value)->get();

        return count($modelWithSameValue) === 0;
    }
}