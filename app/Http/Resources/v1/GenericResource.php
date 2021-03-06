<?php

namespace App\Http\Resources\v1;


use App\Http\Resources\v1\GenericResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GenericResource extends JsonResource
{
    private $fields;

    public function __construct($query, $fields = [])
    {
        $this->fields = $fields;
        parent::__construct($query);
    }

    public function setFields(array $fields){
        $this->fields = $fields;
        return $this;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $return = [];
        
        foreach ($this->fields as $key => $value) {

            if(\is_array($value)){
                foreach ($value as $key2 => $value2) {
                 if(\gettype($this->{$key2}) == 'string')
                    $return[$key2] = $this->{$value2};
                 else
                    $return[$key2] = new GenericResource($this->{$key2}, $value2);
                }
            }
            else{
                $data = $this->{$value};
    
                if(\is_numeric($key))
                 $return[$value] = $data;
                else 
                 $return[$key] = $data; 
            }                        
        }
        return $return ?? null;
    }
}
