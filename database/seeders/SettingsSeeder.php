<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $options =['centralYear', 'curYear'];
        $values =['2022', '2022'];
        $format = ['number','number'];
        $title = ['Центральный год','Год, с которого можно заполнять'];
        foreach ($options as $num=>$value){
            if (!count(Setting::Where('option','=',$value)->get())){
                $setting = new Setting;
                $setting->option = $value;
                $setting->value = $values[$num];
                $setting->format = $format[$num];
                $setting->title = $title[$num];
                $setting->save();
            }
        }
    }
}
