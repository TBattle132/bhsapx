<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Codeplug, CodeplugRoom, AccessId, User};

class CodeplugSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create(['email'=>'admin@bhs.local']);

        $cp = Codeplug::create([
            'name'            => 'Default BHS',
            'ws_url'          => 'ws://127.0.0.1:5001',
            'auth_mode'       => 'SIMPLE',
            'simple_key'      => 'sh@redKey',
            'default_room'    => 'Dispatch',
            'default_volume'  => 70,
            'default_hotkey'  => 'F9',
        ]);

        foreach (['Dispatch','Ops','Tac 1','Tac 2'] as $i => $r) {
            CodeplugRoom::create(['codeplug_id'=>$cp->id,'name'=>$r,'sort'=>$i]);
        }

        $aid = AccessId::create([
            'user_id'   => $user->id,
            'access_id' => 'BHS-TEST-0001',
            'active'    => true,
            'label'     => 'Demo Access',
        ]);

        $aid->codeplugs()->attach($cp->id, [
            'permissions' => json_encode(['rooms' => ['Dispatch','Ops'], 'tx' => true])
        ]);
    }
}
