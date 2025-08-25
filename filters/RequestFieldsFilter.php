<?php

namespace app\filters;

class RequestFieldsFilter
{
    public static function filter($query, $requestParams, $modelClass)
    {
        foreach ($modelClass::fields() as $field) {
            if (!empty($requestParams[$field])) {
                if (is_numeric($requestParams[$field])) {
                    $query->andFilterWhere([
                        $field => $requestParams[$field]
                    ]);
                } else {
                    $query->andFilterWhere(['like', $field, $requestParams[$field]]);
                }
            }
        }

        return $query;
    }
}