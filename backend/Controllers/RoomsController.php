<?php
include 'Controller.php';
include __DIR__ . '/../Models/Payments.php';

class RoomsController extends Controller
{
    protected function initialize()
    {
        // if the user id is not specified
        // send the user to a login page
        // else execution will proceed
        if (!session('UserID')) {
            $this->response->redirect('/login.php');
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
    private function hashId(int $id)
    {
        return strrev($id + 1024);
    }

    public function isAdmin()
    {
        return session('UserType') == 'Admin';
    }
}
