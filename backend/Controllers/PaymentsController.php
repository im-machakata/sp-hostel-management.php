<?php
include 'Controller.php';
include __DIR__ . '/../Models/Payments.php';

class PaymentsController extends Controller
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
        if (Request::isFile('/fake-payment.php')) {
            if ($this->request->get('id') && $this->request->get('status')) {
                $this->fakePayment();
            } else {
                $this->errors[] = 'Provide us with everything we need and we\'ll help you.';
            }
        }
    }
    private function fakePayment()
    {
        $payments = new Payments();
        $status = ucwords($this->request->get('status'));
        $id = $this->getIdFromHash($this->request->get('id'));
        $paymentExists = $payments->find($id)->getRow();

        if (!in_array($status, ['Paid', 'Failed'])) {
            $this->errors[] = 'The payment status you provided is invalid.';
            return;
        }

        if (!$paymentExists) {
            $this->errors[] = 'We could not find the payment you\'re talking about.' . $id;
            return;
        }

        if ($paymentExists['status'] === 'Paid') {
            $this->errors[] = 'This payment has been already been completed.';
            return;
        }
        $done = $payments->save([
            'status' => $status,
            'id' => $id
        ]);

        if (!$done) {
            $this->errors[] = $payments->getFirstError();
            return;
        }

        $this->response->redirect('/');
    }
    private function getIdFromHash(int $hash)
    {
        return strrev($hash) - 1024;
    }
}
