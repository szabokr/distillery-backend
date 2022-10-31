<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Traits\ExcelTrait;
use App\Http\Traits\LoggerTrait;
use App\Http\Traits\MailerTrait;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use LoggerTrait;
    use MailerTrait;

    public $model = User::class;

    public function list(Request $request)
    {
        return $this->model::where('status', 1)->get();
    }

    public function create(Request $request)
    {
        $data = $request->validate($this->model::$createRules);
        $model = $this->model::make();
        $data['activation_key'] = uniqid();
        $model->fill($data);

        $mailData = array(
            'name' => $data['name'],
            'email' => $data['email'],
            'link' => "Linkhelye:" . '?' . $data['activation_key'],
        );
        $this->sendMail('user_registration', $data['email'], $mailData);

        $logContent = "Felhasználó felvitel: \nNév: " . $data['name'] . "\nE-mail: " . $data['email'] . "\nAktiváló kulcs: " . $data['activation_key'];
        $this->Logger(2, $logContent);
        $model->save();
        return ["success" => true];
    }

    public function update(Request $request, $id)
    {
        $model = $this->model::find($id);
        if (!$model) throw new \Exception('A rekord nem található!');
        $data = $request->validate($this->model::$updateRules);
        $content = "Felhasználó adatmódosítása: ";
        ($model->name != $data['name']) ? $content .= "\nNév: " . $model->name . " => " . $data['name'] : "";
        if ($model->email != $request->email) {
            $data += $request->validate([
                'email' => 'required|unique:users|max:320|email',
            ]);
            $data['activation_key'] = uniqid();
            $data['password'] = null;
            if ($model->email != $data['email']) {
                $content .= "\nEmail: " . $model->email . " => " . $data['email'];
                $content .= "\nAktiváló kulcs: null => " . $data['activation_key'];
                $content .= "\nJelszó: " . $model->password . " => null";
            }

            $mailData = array(
                'name' => $data['name'],
                'link' => "Linkhelye:" . '?' . $data['activation_key'],
            );

            $this->sendMail('email_modify', $data['email'], $mailData);
        }
        $model->fill($data);
        $model->save();
        $this->Logger(3, $content);
        return ["success" => true];
    }

    public function delete(Request $request, $id)
    {
        $model = $this->model::find($id);
        if (!$model) throw new \Exception('A rekord nem található!');
        $model['status'] = 0;
        $model['password'] = null;
        $model['activation_key'] = null;
        $model->save();
        $content = "Felhasználó inaktiválása(törlése): \n Név: " . $model->name . "\nEmail: " . $model->email . "\nStátusz: " . $model->status;
        $this->Logger(4, $content);
        return ["success" => true];
    }
}
