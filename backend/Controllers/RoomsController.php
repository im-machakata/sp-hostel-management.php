<?php
include 'Controller.php';
include __DIR__ . '/../Models/Payments.php';

class RoomsController extends Controller
{
    protected function initialize()
    {
        // prevent access to admin pages
        if (!$this->isAdmin() && (Request::isUrl('/booked-rooms.php') || Request::isUrl('/manage-rooms.php'))) {
            $this->response->redirect('/');
        }

        // If user is on the book room page
        // but without a valid id, redirect home
        if (Request::isFile('/book-room.php') && !$this->request->get('id') && !$this->request->isPost()) {
            $this->response->redirect('/');
        }

        // If user is on the book room page
        // but without a valid id, redirect home
        if (Request::isFile('/book-room.php') && $this->request->isPost()) {
            $this->bookRoom();
        }

        if (Request::isFile('/manage-rooms.php') && $this->request->isPost()) {
            if (in_array($this->request->getVar('action'), ['new', 'edit'])) {
                $this->createRoom();
            }
            if (in_array($this->request->getVar('action'), ['delete'])) {
                $this->deleteRoom();
            }
        }
    }
    public function bookRoom()
    {
        $room = new Rooms();
        $payment = new Payments();

        $room = $room->find($this->request->post('room-id'))->getRow();
        $payment_id = $payment->recordPayment('Pending', session('UserID'), $room['id']);

        // if an error occured while saving payment details
        // bring it to attention asap
        if ($payment->hasErrors()) {
            $this->errors[] = $payment->getFirstError();
            return null;
        }

        // todo notify user
        // send email or sms if that's what you want
        $success = mail($this->request->getVar('email'), 'Room Booking Instructions', sprintf('You requested to book <strong class="fw-bold">%s</strong> on the school hostels system. If you\'d like to proceed with the booking, kindly pay a sum of USD $%s to the schools account and email us back with the proof. Remember, if you delay with the payment, the room may be snatched from right under your nose by other users.<hr class="my-4">You can use the following link to fake a <a href="http://%3$s/fake-payment.php?id=<?= %4$s ?>">successful</a> or <a href="http://%3$s/fake-payment.php?id=%4$s&status=paid">failed</a> payment to proceed with the testing.', $room['name'], $room['cost'], Request::getServer('server_name'), $this->hashId($payment_id)));
        if (!$success) {
            $this->errors[] = '<strong>Failed: </strong>Please make sure your server is connected and setup to send emails.';
            return;
        }
    }

    private function createRoom()
    {
        $name = $this->request->getVar('roomName');
        $price = $this->request->getVar('roomPrice');
        $details = $this->request->getVar('roomDescription');
        $booked = $this->request->getVar('roomBooked');
        $file = $_FILES['roomImage'];
        $newFileName = false;

        if ($file['error'] != UPLOAD_ERR_NO_FILE) {

            // check if file is a valid image
            if (!getimagesize($file['tmp_name'])) {
                $this->errors[] = 'Please upload a valid image file.';
                return;
            }

            // move file to assets
            $targetDir = __DIR__ . '/../../frontend/assets/images/';
            $newFileName = 'ROOM-' . uniqid(time()) . '-' . $file['name'];
            $targetFile = $targetDir . $newFileName;

            if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
                $this->errors[] = 'There was an error uploading your image.';
                return;
            }
        }

        if ($name && $price && $details) {
            $rooms = new Rooms();
            $data = [
                'name' => $name,
                'cost' => $price,
                'description' => $details,
                'is_booked' => $booked == '1' ? '1' : '0'
            ];

            // check for duplicates if new entry
            if ($this->request->getVar('action') != 'edit') {
                $exists = $rooms->findWhere($data)->getRow();
                if ($exists) {
                    $this->errors[] = 'Room already exists with the same details.';
                    return;
                }
            }

            if ($this->request->getVar('action') == 'edit') $data['id'] = $this->request->getVar('id');
            if ($newFileName) $data['image_url'] = '/assets/images/' . $newFileName;
            $saved = $rooms->save($data);
            if (!$saved) $this->errors[] = $rooms->getFirstError();
            return $saved;
        }

        // we will only get here if some fields are missing
        $this->errors[] = 'Some fields are missing or empty.';
        return false;
    }
    private function deleteRoom()
    {
        $id = $this->request->getVar('id');

        if (!$id) {
            $this->errors[] = 'Room id can not be null.';
            return;
        }

        $roomModel = new Rooms();
        $room = $roomModel->find($id)->getRow();
        if (!$room) {
            $this->errors[] = 'Room could not be found';
            return;
        }

        if (!$roomModel->deleteRoom($id)) {
            $this->errors[] = $roomModel->getLastError();
            return;
        }
    }
    private function hashId(int $id)
    {
        return strrev($id + 1024);
    }

    public function isAdmin()
    {
        return session('UserType') == 'Admin';
    }
}
