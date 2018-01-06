<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EventsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return  $this->collection->transform(function($page){
           return [
               'title' => $page->title,
               'allday' => (boolean) $page->allday ,
               'description'=>$page->description,
               'color' => $page->color,
               'textColor' =>	$page->textColor,
               'start' => $page->start,
               'end' => $page->end,
               'created_by' => $page->user_id,
           ];
       });
    }

    
}
