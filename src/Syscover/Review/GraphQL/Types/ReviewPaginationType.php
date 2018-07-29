<?php namespace Syscover\Review\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\DB;
use Syscover\Core\Services\SQLService;
use Folklore\GraphQL\Support\Type as GraphQLType;

class ReviewPaginationType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'ReviewPaginationType',
        'description'   => 'Pagination for database reviews'
    ];

    public function fields()
    {
        return [
            'total' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The total records'
            ],
            'filtered' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'N records filtered'
            ],
            'objects' => [
                'type' => Type::listOf(GraphQL::type('ReviewReview')),
                'description' => 'List of reviews',
                'args' => [
                    'sql' => [
                        'type' => Type::listOf(GraphQL::type('CoreSQLQueryInput')),
                        'description' => 'Field to add SQL operations'
                    ]
                ]
            ]
        ];
    }

    public function resolveTotalField($object)
    {
        $total = SQLService::countPaginateTotalRecords($object->query);

        // to count elements, if sql has a groupBy statement, count function always return 1
        // check if total is equal to 1, execute FOUND_ROWS() to guarantee the real result
        // https://github.com/laravel/framework/issues/22883
        // https://github.com/laravel/framework/issues/4306
        return $total === 1 ? DB::select(DB::raw("SELECT FOUND_ROWS() AS 'total'"))[0]->total : $total;
    }

    public function resolveObjectsField($object, $args)
    {
        // get query filtered by sql statement and filterd by filters statement
        $query = SQLService::getQueryFiltered($object->query, $args['sql'] ?? null, $args['filters'] ?? null);

        // get query ordered and limited
        $query = SQLService::getQueryOrderedAndLimited($query, $args['sql'] ?? null);

        // get objects filtered
        $objects = $query->get();

        return $objects;
    }

    public function resolveFilteredField()
    {
        return DB::select(DB::raw("SELECT FOUND_ROWS() AS 'filtered'"))[0]->filtered;
    }
}