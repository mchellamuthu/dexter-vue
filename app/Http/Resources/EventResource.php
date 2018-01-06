<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class EventResource extends Resource
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
          'title' => $this->title,
          'allday' => (boolean) $this->allday ,
          'color' => $this->color,
          'textColor' =>	$this->textcolor,
          'start' => $this->start,
          'end' => $this->end,
          'url' =>$this->url,
          'created_by'=>$this->user_id,
      ];
    }
}
