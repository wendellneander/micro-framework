<?php

namespace Core;


class Validator
{
    const RULE_INTEGER = 'integer';
    const RULE_NUMERIC = 'numeric';
    const RULE_STRING = 'string';
    const RULE_BOOLEAN = 'boolean';
    const RULE_REQUIRED = 'required';

    /**
     * @var self $instance
     */
    private static $instance;

    private $rules = [
        self::RULE_INTEGER,
        self::RULE_NUMERIC,
        self::RULE_STRING,
        self::RULE_BOOLEAN,
        self::RULE_REQUIRED
    ];

    /**
     * @return Validator
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * @param $data
     * @param $rules
     * @throws \Exception
     */
    public function validate(array $data, array $rules)
    {
        $this->checkRules($rules);

        foreach ($data as $attribute => $value) {
            if (!array_key_exists($attribute, $rules)) {
                exit($attribute);
                continue;
            }

            $rules = explode('|', $rules[$attribute]);

            foreach ($rules as $rule) {
                $this->applyRule($rule, $attribute, $value);
            }
        }
    }

    /**
     * @param array $rules
     * @throws \Exception
     */
    private function checkRules(array $rules)
    {
        foreach ($rules as $field => $rule) {

            $rulesArray = explode('|', $rule);

            foreach ($rulesArray as $r) {
                if (!in_array($r, $this->rules)) {
                    throw new \Exception('Rule ' . $r . ' does not exists');
                }
            }
        }
    }

    /**
     * @param $rule
     * @param $attribute
     * @param $value
     * @throws \Exception
     */
    private function applyRule($rule, $attribute, $value)
    {
        switch ($rule) {
            case self::RULE_BOOLEAN :
                if($value && !is_bool($value)){
                    throw new \Exception($attribute . ' must be a boolean');
                }
            case self::RULE_INTEGER :
                if($value && !is_integer($value)){
                    throw new \Exception($attribute . ' must be a integer');
                }
            case self::RULE_NUMERIC :
                if($value && !is_numeric($value)){
                    throw new \Exception($attribute . ' must be a numeric');
                }
            case self::RULE_STRING :
                if($value && !is_string($value)){
                    throw new \Exception($attribute . ' must be a string');
                }
            case self::RULE_REQUIRED :
                if(!$value){
                    throw new \Exception($attribute . ' is required');
                }
        }
    }
}
