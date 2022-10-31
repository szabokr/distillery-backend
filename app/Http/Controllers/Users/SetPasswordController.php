<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Traits\LoggerTrait;
use App\Http\Traits\MailerTrait;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SetPasswordController extends Controller
{
    use LoggerTrait;
    use MailerTrait;
    public $model = User::class;

    public function update(Request $request, $id)
    {
        $model = $this->model::where('activation_key', $request->activation_key)->first();
        if (!$model) throw new \Exception('A rekord nem található!');
        $data = $request->validate($this->model::$setPasswordRules);
        $data['activation_key'] = null;
        $data['status'] = 1;
        $data['password'] = Hash::make($request->password);
        $content = "Felhasználó jelszó beállítása: \nAktiváló kulcs: " . $model->activation_key . " => null\nStátusz: " . $model->status . " => " . $data['status'] . "\nJelszó: Sikeresen beállítva";
        $this->Logger(5, $content);
        $mailData = [
            'name' => $model->name,
        ];
        $this->sendMail('user_registration_success', $model->email, $mailData);
        $model->fill($data);
        $model->save();
        return ["success" => true];
    }
}

//TODO: SIKERES REGISZTACIÓ EMAIL;
