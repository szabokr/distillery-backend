<?php

namespace App\Http\Traits;

use App\Models\Log;

trait LoggerTrait
{

    public function Logger($type, $content)
    {
        $log = Log::make();
        //TODO: CONFIG('user') beállítása
        $log['user_id'] = 1;
        $log['type'] = $type;
        $log['content'] = $content;
        $log->save();
    }

    /*
        1 =>  Email küldés
        2 =>  Felhasználó felvitel
        3 =>  Felhasználó módosítása
        4 =>  Felhasználó törlése
        5 =>  Felhasználó aktiválása
        6 =>  Cefre raktárba elem felvitel
        7 =>  Cefre raktárba elem törlése
        8 =>  Pálinka raktárba elem törlése
        9 =>  Raktárba elem felvitele
        10 => Eladott termék felvitele
        11 => Eladott termék törlése
        12 => Bérfőzés felvitel
        13 => Bérfőzés törlése
    */
}
