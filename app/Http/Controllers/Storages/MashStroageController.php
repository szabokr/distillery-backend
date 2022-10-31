<?php

namespace App\Http\Controllers\Storages;

use App\Http\Controllers\Controller;
use App\Http\Traits\LoggerTrait;
use App\Models\Mash_storage;
use App\Models\Storage;
use Illuminate\Http\Request;

class MashStroageController extends Controller
{
    use LoggerTrait;

    public $model = Mash_storage::class;

    public function list(Request $request)
    {
        return $this->model::get();
    }

    public function create(Request $request)
    {
        $data = $request->validate($this->model::$createRules);

        $sugar = Storage::where('key', 'sugar')->first();
        $pectinBreaker = Storage::where('key', 'pectin_breaker')->first();
        $yeast = Storage::where('key', 'yeast')->first();

        $message = "Raktáron nincs elég";
        if ($sugar['value'] - $data['sugar'] < 0) {
            $message .= " cukor,";
        }
        if ($pectinBreaker['value'] - $data['pectin_breaker'] < 0) {
            $message .= " pectin bontó,";
        }
        if ($yeast['value'] - $data['yeast'] < 0) {
            $message .= " élesztő,";
        }
        if ($message != "Raktáron nincs elég") {
            $message = substr($message, 0, -1) . "!";
            return response()->json([
                'success' => false,
                'message' => $message,
            ], 422);
        }
        $content = "Cefre felvitele: \nGyümölcs: " . $data['fruit_id'] . "\nGyümölcs ára: " . $data['fruit_price'] . "\nCefre mennyisége: " . $data['mash'] . "\nCukor: " . $data['sugar'] . "\nPektinbontó: " . $data['pectin_breaker'] . "\nVíz: " . $data['water'] . "\nÉlesztő: " . $data['yeast'];
        ($sugar['value'] == $sugar['value'] - $data['sugar'] && $pectinBreaker['value'] == $pectinBreaker['value'] - $data['pectin_breaker'] && $yeast['value'] == $yeast['value'] - $data['yeast']) ? "" : $content .= "\n\nRaktárkészlet módosítása: ";
        ($sugar['value'] == $sugar['value'] - $data['sugar']) ? "" : $content .= ("\nCukor: " . $sugar['value'] . " => " . $sugar['value'] - $data['sugar']);
        ($pectinBreaker['value'] == $pectinBreaker['value'] - $data['pectin_breaker']) ? "" : $content .= "\nPektinbontó: " . $pectinBreaker['value'] . " => " . $pectinBreaker['value'] - $data['pectin_breaker'];
        ($yeast['value'] == $yeast['value'] - $data['yeast']) ? "" : $content .= "\nÉlesztő: " . $yeast['value'] . " => " . $yeast['value'] - $data['yeast'];
        $this->Logger(6, $content);

        $sugar['value'] -=  $data['sugar'];
        $pectinBreaker['value'] -=  $data['pectin_breaker'];
        $yeast['value'] -=  $data['yeast'];
        $sugar->save();
        $pectinBreaker->save();
        $yeast->save();
        $model = $this->model::make();
        $model->fill($data);
        $model->save();

        return ["success" => true];
    }

    public function delete(Request $request, $id)
    {
        //TODO: FRONTENDEN HA CREATED_AT=MA AKKOR LEHET TÖRÖLNI KÜLÖNBEN NEM;
        $model = $this->model::find($id);
        if (!$model) throw new \Exception('A rekord nem található!');
        $pectinBreaker = Storage::where('key', 'pectin_breaker')->first();
        $sugar = Storage::where('key', 'sugar')->first();
        $yeast = Storage::where('key', 'yeast')->first();
        $pectinBreaker['value'] += $model['pectin_breaker'];
        $sugar['value'] += $model['sugar'];
        $yeast['value'] += $yeast['pectin_breaker'];

        $content = "Cefre törlése: \nGyümölcs: " . $model['fruit_id'] . "\nGyümölcs ára: " . $model['fruit_price'] . "\nCefre mennyisége: " . $model['mash'] . "\nCukor: " . $model['sugar'] . "\nPektinbontó: " . $model['pectin_breaker'] . "\nVíz: " . $model['water'] . "\nÉlesztő: " . $model['yeast'];
        ($sugar['value'] == $sugar['value'] + $model['sugar'] && $pectinBreaker['value'] == $pectinBreaker['value'] - $model['pectin_breaker'] && $yeast['value'] == $yeast['value'] + $model['yeast']) ? "" : $content .= "\n\nRaktárkészlet módosítása: ";
        ($sugar['value'] == $sugar['value'] + $model['sugar']) ? "" : $content .= ("\nCukor: " . $sugar['value'] . " => " . $sugar['value'] + $model['sugar']);
        ($pectinBreaker['value'] == $pectinBreaker['value'] - $model['pectin_breaker']) ? "" : $content .= "\nPektinbontó: " . $pectinBreaker['value'] . " => " . $pectinBreaker['value'] + $model['pectin_breaker'];
        ($yeast['value'] == $yeast['value'] + $model['yeast']) ? "" : $content .= "\nÉlesztő: " . $yeast['value'] . " => " . $yeast['value'] + $model['yeast'];
        $this->Logger(7, $content);

        $pectinBreaker->save();
        $sugar->save();
        $yeast->save();
        $model->delete();
        return ["success" => true];
    }
}
