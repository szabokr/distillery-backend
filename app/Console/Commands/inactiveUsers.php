<?php

namespace App\Console\Commands;

use App\Http\Traits\MailerTrait;
use App\Models\User;
use DateTime;
use Illuminate\Console\Command;

class inactiveUsers extends Command
{
    use MailerTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inactiveUsers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inaktív felhasználók törlése';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $activationDay = 10;
        $expireDay=3;
        $users = User::where('status', 0)->get();

        for ($i = 0; $i < count($users); $i++) {
            $nowDate = new DateTime('now');
            $interval = $nowDate->diff($users[$i]->created_at);
            $days = $interval->format('%a');
            switch ($days) {
                case $activationDay:
                    $mailData=[
                        'name'=> $users[$i]['name'],
                      'activation_day'=>$activationDay,  
                      'expire_day'=>$expireDay,  
                      'link' => "Linkhelye:" . '?' . $users[$i]['activation_key'],
                    ];
                    $this->sendMail('unactivate_user_registration',$users[$i]['email'],$mailData);
                    break;
                case $activationDay + $expireDay:
                    $mailData=[
                        'name'=> $users[$i]['name'],
                    ];
                    $this->sendMail('unactivate_user_delete',$users[$i]['email'],$mailData);
                    $users[$i]->delete();
                    break;
            }
        }
    }
}
