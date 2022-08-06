<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Str;
use DB;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();


        if ($user) {
            $token = Str::random(64);

            DB::table('password_resets')->insert([
              'email' => $request->email, 
              'token' => $token, 
              'created_at' => Carbon::now()
            ]);
      
            $authorization = ['Authorization' => 'eyJpdiI6Ik9UUXdOVFkyT1RZek5qSTNNVGs0T0E9PSIsInZhbHVlIjoiMEwwVjFjeTVyZ3ZnWlE1U204REtkQk0vZCtSbW4rdGZ1WXg3Uzk2Z2dLST0iLCJtYWMiOiI0MzM2M2NlNDE3YjMyY2ZhNjNlZTIxNGFmMDQwOTQyNjVhMzA3ZGNlMDQzZGQ5NDNlZWY0OTIxNWNhZjI4MmUzIn0='];

            $client = new Client();
            $client = $client->request('POST', 'https://api.esmsv.com/v1/listscontacts/create', [
            'headers' => $authorization,
            'form_params' => [
                'name' => "Restablecer contraseña: $token",
            ]]);
            $list_id = json_decode($client->getBody(), true)['data']['id'];

            $client = new Client();
            $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/getall', [
            'headers' => $authorization,
            'form_params' => [
                'email' => $request->email,
            ]]);

            if (!empty(json_decode($client->getBody(), true)['data']['data'])) {
                $contact_id[] = json_decode($client->getBody(), true)['data']['data'][0]['id'];
            } else {
                $client = new Client();
                $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/create', [
                'headers' => $authorization,
                'form_params' => [
                    'email' => $request->email,
                ]]);
                $contact_id[] = json_decode($client->getBody(), true)['data']['id'];
            }

            $client = new Client();
            $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/suscribe', [
            'headers' => $authorization,
            'form_params' => [
                'listId' => $list_id,
                'contactsIds' => $contact_id
            ]]);

            $client = new Client();
            $client = $client->request('POST', 'https://api.esmsv.com/v1/campaign/create', [
            'headers' => $authorization,
            'form_params' => [
                'name' => "Restablecer contraseña: $request->email",
                'subject' => "Solicitud de cambio de contraseña",
                'content' => '<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" border="0" cellspacing="0" cellpadding="0" width="100%"><tbody><tr><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;width: 100%; padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px" align="center"><div style="font-size: 12px;font-style: normal;font-weight: 400;"><img src="https://www.channeltalks.net/images/header.png" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: 0;height: auto;line-height: 100%;margin: undefined;float: none;width: auto;max-width: 600px;" alt="" border="0" width="auto" class="center fullwidth"><p style="max-width: 600px; font-size: 20px">'."Hola, $user->name recibimos una solicitud para cambiar tu contraseña. Si has sido tu ingrese ".'<a href="https://www.channeltalks.net/reset-password/'.$token.'">AQUÍ</a></p></div></td></tr></tbody></table>',
                'fromAlias' => 'Channel Talks',
                'fromEmail' => 'channeltalks@mediaware.news',
                'replyEmail' => 'channeltalks@mediaware.news',
                'mailListsIds' => [$list_id],
            ]]);
            $id = json_decode($client->getBody(), true)['data']['id'];

            $client = new Client();
            $client = $client->request('POST', 'https://api.esmsv.com/v1/campaign/send', [
            'headers' => $authorization,
            'form_params' => [
                'id' => $id,
                'sendNow' => 1
            ]]);
      
            return back()->with('message', 'Hemos enviado el correo de restablecimiento!');
        }        
    }
}
