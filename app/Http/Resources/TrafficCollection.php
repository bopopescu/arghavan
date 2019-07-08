<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TrafficCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [];
        // dd($this->collection);
        foreach ($this->collection as $record)
        {
            $data[] = [
                'user' => [
                    'code' => $record->user_code,
                    'people' => [
                        'name' => $record->user_people_name,
                        'lastname' => $record->user_people_lastname,
                        'pictureUrl' =>  \App\People::getPictureUrl($record->user_people_picture),
                    ],
                ],
                'gatedirect' => [
                    'name' => $record->gatedirect_name
                ],
                'gatemessage' => [
                    'message' => $record->gatemessage_message,
                    'id' => $record->gatemessage_id
                ],
                'gatedevice' => [
                    'name' => $record->gatedevice_name
                ],
                'gatedate' => $record->gatedate
            ];
        }

        return [
            'data' => $data
        ];

        //return parent::toArray($request);
    }
}
