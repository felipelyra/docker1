<?php

namespace App\Http\Resources\Api\V2;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id2' => $this->id
        ];    }


/**
 * @param string $resourceName
 * @param array ...$args
 *
 * @return object
 */
public function resource($resourceName, ...$args)
{
    // Get's the request's api version, or the latest if undefined
    $v = config('app.api_version', config('app.api_latest'));

    $className = $this->getResourceClassname($resourceName, $v);
    $class = new \ReflectionClass($className);
    return $class->newInstanceArgs($args);
}

/**
 * Parse Api\BusinessResource for
 * App\Http\Resources\Api\v{$v}\BusinessResource
 *
 * @param string $className
 * @param string $v
 *
 * @return string
 */
protected function getResourceClassname($className, $v)
{
    $re = '/.*\\\\(.*)/';
    return 'App\Http\Resources\\' .
        preg_replace($re, 'Api\\v' . $v . '\\\$1', $className);
}

}
