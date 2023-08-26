<?php
include_once 'Model.php';
class Rooms extends Model
{
    protected $table = 'rooms';
    public function book(): bool
    {
    }
    public function isBooked($id): bool
    {
        return empty($this->findWhere(['id' => $id, 'is_booked' => '1'])->getRow());
    }
    public function free(): bool
    {
    }
    public function isFree($id): bool
    {
        return !empty($this->findWhere(['id' => $id, 'is_booked' => '1'])->getRow());
    }
    public function getFreeRooms(): array
    {
        return $this->findWhere(['is_booked' => '0'])->getResults();
    }
    public function getBookedRooms(): array
    {
        return $this->findWhere(['is_booked' => '1'])->getResults();
    }
    public function deleteRoom($id)
    {
        $this->db->prepare(sprintf('DELETE FROM %s WHERE id = :id', $this->table), ['id' => $id]);
        return $this->db->exec();
    }
    public function countAllRooms()
    {
        $this->db->query(sprintf('SELECT COUNT(id) AS total FROM %s', $this->table));
        return $this->db->getRow();
    }
}
