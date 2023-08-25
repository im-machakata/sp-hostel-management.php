<?php
include_once 'Model.php';
class Payments extends Model
{
    protected $table = 'payments';

    public function recordPayment($status, $student, $room)
    {
        // todo: check if user has any booked rooms
        // ceheck if the user has any previous pending payments
        $pendingPayment = $this->findWhere([
            'status' => 'Pending',
            'student_id' => $student,
            'room_id' => $room
        ])->getRow();

        // if user has a pending pending, use that
        if ($pendingPayment) {

            // update the payment date
            $this->save([
                'id' => $pendingPayment['id'],
                'updated_on' => date('Y-m-d')
            ]);

            // return the payment id
            return $pendingPayment['id'];
        }

        // if this is their first room payment
        // create a new payment entry
        try {
            $data = [
                'status' => $status,
                'student_id' => $student,
                'room_id' => $room,
                'created_on' => date('Y-m-d'),
                'updated_on' => date('Y-m-d')
            ];
            if ($this->save($data)) {
                return $this->db->lastInsertId();
            }
        } catch (PDOException $e) {
            $this->errors[] = $e->getMessage();
        }
        return false;
    }
}
