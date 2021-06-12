<?php


namespace Core;


use RedBeanPHP\OODBBean;
use \RedBeanPHP\R as R;
use RedBeanPHP\SimpleModel;

/**
 * Class Model
 * @package Core
 *
 * Base model class. Application models should extend from base model.
 * Can be used as a bean.
 * Contain methods that wrap necessary Redbean\R methods.
 * You can use Redbean directly if you don't have enough of the model's functionality.
 */
abstract class Model extends SimpleModel
{
    /**
     * Contains table name.
     * Must be filled.
     *
     * @var string
     */
    protected static $table;


    /**
     * @param array $attributes
     * @return static
     */
    public static function dispense(array $attributes = []): Model
    {
        if (count($attributes) > 0) {
            $attributes['_type'] = static::$table;
            $bean = R::dispense($attributes);
        } else {
            $bean = R::dispense(static::$table);
        }

        return static::createInstance($bean);
    }

    public static function create(array $attributes = []): Model
    {
        $model = static::dispense($attributes);
        $model->store();

        return $model;
    }

    /**
     * @param int $id
     * @return Model
     */
    public static function load($id): Model
    {
        $bean = R::load(static::$table, $id);

        return static::createInstance($bean);
    }

    /**
     * @param array $attributes
     * @param string|null $sql
     * @param array $bindings
     * @return Model|null
     */
    public static function findOne($attributes = [], $sql = null, $bindings = [])
    {
        if (!empty($attributes)) {
            if ($sql === null) {
                $sql = '';
            }

            foreach ($attributes as $field => $value) {
                if ($sql === '') {
                    $sql .= "$field = '$value' ";
                } else {
                    $sql .= "AND $field = '$value' ";
                }
            }
        }

        $bean = R::findOne(static::$table, $sql, $bindings);

        if ($bean === null) {
            return null;
        }

        return static::createInstance($bean);
    }

    /**
     * @param string $sql
     * @param array $bindings
     * @return array
     */
    public static function find($sql = '', $bindings = []): array
    {
        $beans = R::find(static::$table, $sql, $bindings);

        return static::createInstanceArray($beans);
    }

    /**
     * @param string|null $sql
     * @param array $bindings
     * @return array
     */
    public static function findAll($sql = null, $bindings = []): array
    {
        $beans = R::findAll(static::$table, $sql, $bindings);

        return static::createInstanceArray($beans);
    }

    /**
     * @param array $like
     * @param string $sql
     * @param array $bindings
     * @return array
     */
    public static function findLike($like = [], $sql = '', $bindings = []): array
    {
        $beans = R::findLike(static::$table, $like, $sql, $bindings);

        return static::createInstanceArray($beans);
    }

    /**
     * @param array $array
     * @param string $sql
     * @return Model
     */
    public static function findOrCreate($array = [], $sql = ''): Model
    {
        $bean = R::findOrCreate(static::$table, $array, $sql);

        return static::createInstance($bean);
    }

    /**
     * @throws \RedBeanPHP\RedException\SQL
     */
    public function store()
    {
        R::store($this->bean);
    }

    public function trash()
    {
        R::trash($this->bean);
    }

    /**
     * Create model object using bean
     *
     * @param OODBBean $bean
     * @return Model
     */
    protected static function createInstance($bean): Model
    {
        $model = new static();
        $model->loadBean($bean);

        return $model;
    }

    /**
     * Create array of model objects using beans
     *
     * @param array $beans
     * @return array
     */
    protected static function createInstanceArray($beans): array
    {
        $models = [];

        foreach ($beans as $bean) {
            $models[] = static::createInstance($bean);
        }

        return $models;
    }
}