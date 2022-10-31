<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMailContentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('mail_contents', function (Blueprint $table) {
      $table->integer('id', true)->comment('Egyedi azonosító');
      $table->string('mail_key')->comment('Email sablon kulcs');
      $table->string('sender', 320)->comment('Küldő email cím');
      $table->string('subject')->comment('Email tárgya');
      $table->text('content')->comment('Email tartalma');
    });

    DB::table('mail_contents')->insert(
      array(
        [
          'mail_key' => "user_registration",
          'sender' => "krisztianszabodev@gmail.com",
          'subject' => "Felhasználó regisztrálása",
          'content' => "
                    <h4>Tisztelt ##name##!</h4>
                    <br>
                    <p>Az alábbi linkre kattintva aktiválhatja jelszavát: </p>
                    <a href='##link##?##'>##link##</a>
                    <br><br>
                    <p>Köszönettel:</p>
                    <p>Szabó Szeszfőzde csapata</p>"
        ],
        [
          'mail_key' => "cooking_for_hire_statistics",
          'sender' => "krisztianszabodev@gmail.com",
          'subject' => "Főzde statisztikája",
          'content' => "
                    <h4>Tisztelt ##name##!</h4>
                    <br>
                    <p>A ##date##  bérfőzés statisztika: </p>
                    <br>
                    <table style='border-collapse:collapse;'>
  <tr>
    <th style='border-bottom:1px dotted black;'>Statisztika</th>
    <th style='border-bottom:1px dotted black; border-left:1px dotted black;'> Mennyiség</th>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Főzések száma</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##number_of_cooking## db</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Cefre mennyisége</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##mash## l</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Vodka mennyisége</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##vodka## l</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Nem bekevert pálinka mennyisége</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##unadjusted_palinka## l</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Bekevert pálinka mennyisége</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##finished_palinka## l</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Bevétel</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##income## Ft</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Kiadás</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##expenditure## Ft</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Profit</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##profit## Ft</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Elhasznált gáz</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##used_gas## m³</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Elhasznált gáz ára</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##used_gas_price## Ft</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Elhasznált áram</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##used_electricity## kW</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Elhasznált áram ára</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##used_electricity_price## Ft</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Elhasznált desztilált víz</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##used_distilled_water## l</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Elhasznált desztilált víz ára</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##used_distilled_water_price## Ft</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Elhasznált habzásgátló</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##used_antifoam## ml</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Elhasznált habzásgátló ára</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##used_antifoam_price## Ft</td>
  </tr>
</table>
<br>
<br>
                    <p>A ##date## saját főzés statisztika: </p>
                    <br>
                    <table>
  <tr>
    <th style='border-bottom:1px dotted black;'>Statisztika</th>
    <th style='border-bottom:1px dotted black; border-left:1px dotted black;'> Mennyiség</th>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Főzések száma</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##number_of_cooking_own## db</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Cefre mennyisége</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##mash_own## l</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Vodka mennyisége</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##vodka_own## l</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Nem bekevert pálinka mennyisége</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##unadjusted_palinka_own## l</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Bekevert pálinka mennyisége</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##finished_palinka_own## l</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Kiadás</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##expenditure_own## Ft</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Elhasznált gáz</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##used_gas_own## m³</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Elhasznált gáz ára</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##used_gas_price_own## Ft</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Elhasznált áram</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##used_electricity_own## kW</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Elhasznált áram ára</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##used_electricity_price_own## Ft</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Elhasznált desztilált víz</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##used_distilled_water_own## l</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Elhasznált desztilált víz ára</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##used_distilled_water_price_own## Ft</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Elhasznált habzásgátló</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##used_antifoam_own## ml</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Elhasznált habzásgátló ára</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##used_antifoam_price_own## Ft</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Gyümölcs ára</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##fruit_price_own## Ft</td>
  </tr>
  <tr>
    <td style='border-bottom:1px dotted black;'>Elhasznált cukor</td>
    <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##sugar_own## kg</td>
  </tr>
  <tr>
  <td style='border-bottom:1px dotted black;'>Elhasznált cukor ára</td>
  <td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##sugar_price_own## Ft</td>
</tr>
<tr>
<td style='border-bottom:1px dotted black;'>Elhasznált pektinbontó</td>
<td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##pectin_breaker_own## db</td>
</tr>
<tr>
<td style='border-bottom:1px dotted black;'>Elhasznált pektinbontó ára</td>
<td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##pectin_breaker_price_own## Ft</td>
</tr>
<tr>
<td style='border-bottom:1px dotted black;'>Elhasznált élesztő</td>
<td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##yeast_own## db</td>
</tr>
<tr>
<td style='border-bottom:1px dotted black;'>Elhasznált élesztő ára</td>
<td style='border-bottom:1px dotted black; border-left:1px dotted black;'> ##yeast_price_own## Ft</td>
</tr>
<br>
                    <p>Üdvözlettel:</p>
                    <p>Szabó Szeszfőzde csapata</p>"
        ],
        [
          'mail_key' => "sold_product_statistics",
          'sender' => "krisztianszabodev@gmail.com",
          'subject' => "Eladott pálinka statisztika",
          'content' => "
                    <h4>Tisztelt ##name##!</h4>
                    <br>
                    <p>A ##date## eladott pálinka statisztika: </p>
                    <br>
                    <table>
  <tr>
    <th style='border-bottom:1px dotted black; border-right:1px dotted black;'>Gyümölcs</th>
    <th style='border-bottom:1px dotted black; border-right:1px dotted black;'>Mennyiség</th>
    <th style='border-bottom:1px dotted black; border-right:1px dotted black;'>Bevétel</th>
    <th style='border-bottom:1px dotted black; border-right:1px dotted black;'>Kiadás</th>
    <th style='border-bottom:1px dotted black;'>Profit</th>
  </tr>
  ##soldProductContent##
</table>
                    <p>Üdvözlettel:</p>
                    <p>Szabó Szeszfőzde csapata</p>"
        ],
        [
          'mail_key' => "user_registration_success",
          'sender' => "krisztianszabodev@gmail.com",
          'subject' => "Felhasználó sikeres regisztrálása",
          'content' => "
                    <h4>Tisztelt ##name##!</h4>
                    <br>
                    <p>Regisztrációját sikeresen feldolgoztuk, köszönjük, hogy minket választott!</p>
                    <br><br>
                    <p>Köszönettel:</p>
                    <p>Szabó Szeszfőzde csapata</p>"
        ],
        [
          'mail_key' => "unactivate_user_registration",
          'sender' => "krisztianszabodev@gmail.com",
          'subject' => "Nem aktivált felhasználó regisztrálásának határideje",
          'content' => "
                    <h4>Tisztelt ##name##!</h4>
                    <br>
                    <p>Ön ##activation_day## napja nem regisztrálta felhasználóját rendszerünkbe, felhívjuk figyelmét, hogy még ##expire_date## napja van hátra felhasználójának törléséig!</p>
                    <p>Az alábbi linkre kattintva még aktiválhatja jelszavát: </p>
                    <a href='##link##?##'>##link##</a>
                    <br><br>
                    <p>Köszönettel:</p>
                    <p>Szabó Szeszfőzde csapata</p>"
        ],
        [
          'mail_key' => "email_modify",
          'sender' => "krisztianszabodev@gmail.com",
          'subject' => "Email módosítása",
          'content' => "
                    <h4>Tisztelt ##name##!</h4>
                    <p>E-mail címének módosítása sikeresen megtörtént!</p>
                    <br>
                    <p>Az alábbi linkre kattintva még aktiválhatja jelszavát: </p>
                    <a href='##link##?##'>##link##</a>
                    <br><br>
                    <p>Köszönettel:</p>
                    <p>Szabó Szeszfőzde csapata</p>"
        ],
        [
          'mail_key' => "unactivate_user_delete",
          'sender' => "krisztianszabodev@gmail.com",
          'subject' => "Nem regisztálr felhasználók törlése",
          'content' => "
                    <h4>Tisztelt ##name##!</h4>

                    <p>Felhasználóját töröltük rendszerünkből, mivel nem aktiválta magát!</p>
                    <p>Megértését köszönjük!</p>
                    <br><br>
                    <p>Köszönettel:</p>
                    <p>Szabó Szeszfőzde csapata</p>"
        ],



      )
    );
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mail_contents');
  }
}
