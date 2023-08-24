<?php
include_once 'Model.php';
class Images extends Model
{
    protected $table = 'images';
    public function getRoomImages($roomId)
    {
        return $this->findWhere(['room_id' => $roomId])->getResults();
    }
}
