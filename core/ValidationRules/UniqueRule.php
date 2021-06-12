<?php


namespace Core\ValidationRules;


use Core\Model;
use Rakit\Validation\Rule;

class UniqueRule extends Rule
{
    protected $message = ":attribute :value has been used";

    protected $fillableParams = ['model', 'field'];

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

        $modelWithSameValue = $model::findLike([$field => $value]);

        return count($modelWithSameValue) === 0;
    }
}