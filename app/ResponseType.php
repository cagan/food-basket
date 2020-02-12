<?php


namespace App;

/**
 * Class ResponseType
 * Custom response types when no need data attribute.
 * @package App
 */
class ResponseType
{
    /** @var array
     *  ERROR RESPONSES
     */
    public const PIZZA_NOT_FOUND = [
        'status' => 'error',
        'message' => 'Pizza not found',
    ];

    public const NO_PERMISSION = [
        'status' => 'error',
        'message' => 'No permission',
    ];

    public const ORDER_CAN_NOT_VIEW = [
        'status' => 'error',
        'message' => 'Order can not be viewed by that user',
    ];

    public const ROUTE_NOT_FOUND = [
        'status' => 'error',
        'message' => 'Route not found',
    ];

    public const MODEL_NOT_FOUND = [
        'status' => 'error',
        'message' => 'Model not found',
    ];

    public const METHOD_NOT_ALLOWED = [
        'status' => 'error',
        'message' => 'You need to be owner to perform this action',
    ];
    public const BAD_REQUEST = [
        'status' => 'error',
        'message' => 'Bad request',
    ];

    /** @var array
     * SUCCESS RESPONSES
     */
    public const PIZZA_DELETED_SUCCESSFULLY = [
        'status' => 'success',
        'message' => 'Pizza deleted successfully',
    ];
}
