<?php namespace TPS\Card\Components;

use Cms\Classes\ComponentBase;

class Application extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Card application',
            'description' => 'Plastic card application component'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onSend()
    {
        // Get request data
        $data = \Input::only([
            'firstname',
            'lastname',
            'email',
            'content'
        ]);

        // Validate request
        $this->validate($data);

        //todo register payment, register application, Send email, redirect to payment,



    }

    private function sendNotification(\TPS\Card\Models\Application $app){
        //todo send email to admin
//        $receiver = 'admin@gmail.com';
//
//        \Mail::send('progmatiq.contact::contact', $data, function ($message) use ($receiver) {
//            $message->to($receiver);
//        });
    }

    protected function validate(array $data)
    {
        // Validate request
        $rules = [
            'firstname' => 'required|min:3|max:255',
            'lastname' => 'required|min:3|max:255',
            'email' => 'required|email',
            'address' => 'required',
        ];

        $validator = \Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
