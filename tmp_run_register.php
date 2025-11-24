<?php
require __DIR__.'/vendor/autoload.php';
$app=require __DIR__.'/bootstrap/app.php';
$kernel=$app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\User;
$ts=time();
$email='auto'.$ts.'@example.test';
$req=Request::create('/register','POST',['username'=>'auto'.$ts,'email'=>$email,'password'=>'password','password_confirmation'=>'password']);
$c=new RegisteredUserController();
$c->store($req);
$u=User::where('email',$email)->first();
echo $u?('FOUND: '.$u->email."\n"):'NOT FOUND'."\n";
