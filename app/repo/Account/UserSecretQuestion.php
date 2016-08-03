<?php namespace App\repo\Account;

use App\Question;

class UserSecretQuestion implements UserInterface {
    
    protected $request;
    protected $user;

    public function __construct($request, $user)
    {
        $this->request = $request;
        $this->user = $user;
    }
    
    public function update()
    {
        $question = new Question($this->request->all());
        $this->user->question()->update($question->toArray());
    }
}