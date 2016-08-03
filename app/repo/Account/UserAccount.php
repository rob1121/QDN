<?php namespace App\repo\Account;


use Hash;
use Intervention\Image\Facades\Image;

class UserAccount implements UserInterface
{
    protected $request;
    public $user;

    public function __construct($request, $user)
    {
        $this->request = $request;
        $this->user = $user;
    }

    public function update() {
        if ($this->isImageExist())
            $this->user->avatar = $this->uploadAvatar();

        if ($this->request->password != '')
            $this->user->password = Hash::make($this->request->password);

        $this->user->save();
    }

        protected function isImageExist() {
            return $this->request->hasFile('avatar');
        }

        protected function uploadAvatar() {
            $filename = $this->nameFileByUserId();
            $this->makeAvatar($filename);
            return $filename;
        }

            protected function nameFileByUserId() {
                return $this->user->id . '.' . $this->getAvatarExtension();
            }

                protected function getAvatarExtension() {
                    return $this->request->file('avatar')->getClientOriginalExtension();
                }

            protected function makeAvatar($filename) {
                Image::make($this->request->file('avatar'))
                    ->resize(300,300)
                    ->save(public_path('/uploads/avatar/' . $filename));
            }
}