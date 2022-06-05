<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use App\Models\{Visitor, User, Meeting};
use GuzzleHttp\Client;

class ScanEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $custid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($custid)
    {
        $this->custid = $custid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $visitor = Visitor::where('custid', $this->custid)->first();
        $forms = Cache::get('forms');
        // Código para mandar mail al expositor con el que tenga reunión

        $meetings = Meeting::where('visitor_id', $visitor->id)->where('approved', true)->where('event_id', Cache::get('currentEvent'))->get();

        if ($meetings->isNotEmpty()) {
            $authorization = ['Authorization' => 'eyJpdiI6Ik9UUXdOVFkyT1RZek5qSTNNVGs0T0E9PSIsInZhbHVlIjoiMEwwVjFjeTVyZ3ZnWlE1U204REtkQk0vZCtSbW4rdGZ1WXg3Uzk2Z2dLST0iLCJtYWMiOiI0MzM2M2NlNDE3YjMyY2ZhNjNlZTIxNGFmMDQwOTQyNjVhMzA3ZGNlMDQzZGQ5NDNlZWY0OTIxNWNhZjI4MmUzIn0='];

            $client = new Client();
            $client = $client->request('POST', 'https://api.esmsv.com/v1/campaign/getAll', [
            'headers' => $authorization,
            'form_params' => [
                'filter' => 'Reunión con '.$forms[$visitor->form_id]['Nombre completo'],
            ]]);
            $check = json_decode($client->getBody(), true)['data']['data'];

            if (!isset($check[0])) {
                $client = new Client();
                $client = $client->request('POST', 'https://api.esmsv.com/v1/listscontacts/create', [
                'headers' => $authorization,
                'form_params' => [
                    'name' => 'Reunión con '.$forms[$visitor->form_id]['Nombre completo'].rand(),
                ]]);
                $list_id = json_decode($client->getBody(), true)['data']['id'];

                foreach ($meetings as $meeting) {
                    $exhibitor = User::where('name', $meeting->exhibitor)->first();
                    $client = new Client();
                    $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/getall', [
                    'headers' => $authorization,
                    'form_params' => [
                        'email' => $exhibitor->email,
                    ]]);
                    $contacts_ids[] = json_decode($client->getBody(), true)['data']['data'][0]['id'];
                }

                $client = new Client();
                $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/suscribe', [
                'headers' => $authorization,
                'form_params' => [
                    'listId' => $list_id,
                    'contactsIds' => $contacts_ids
                ]]);

                $client = new Client();
                $client = $client->request('POST', 'https://api.esmsv.com/v1/campaign/create', [
                'headers' => $authorization,
                'form_params' => [
                    'name' => 'Reunión con '.$forms[$visitor->form_id]['Nombre completo'],
                    'subject' => 'El invitado '.$forms[$visitor->form_id]['Nombre completo'].' ha ingresado al evento',
                    'content' => '<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" border="0" cellspacing="0" cellpadding="0" width="100%"><tbody><tr><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;width: 100%; padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px" align="center"><div style="font-size: 12px;font-style: normal;font-weight: 400;"><img src="https://mediaware.org/channeltalks/imagenes/header.png" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: 0;height: auto;line-height: 100%;margin: undefined;float: none;width: auto;max-width: 600px;" alt="" border="0" width="auto" class="center fullwidth"><p style="max-width: 600px; font-size: 20px">El invitado '.$forms[$visitor->form_id]['Nombre completo'].' ha ingresado al evento, sugerimos contactarse para coordinar la reunión al email: '.$forms[$visitor->form_id]['Direccion de email'].'.</p></div></td></tr></tbody></table>',
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
            }
        }

        $meetings = Meeting::where('visitor_id', $visitor->id)->where('approved', true)->where('event_id', Cache::get('currentEvent'))->get();

        if ($visitor->vip == 1) {
            $organizers = User::role('organizer')->get();
            
            $authorization = ['Authorization' => 'eyJpdiI6Ik9UUXdOVFkyT1RZek5qSTNNVGs0T0E9PSIsInZhbHVlIjoiMEwwVjFjeTVyZ3ZnWlE1U204REtkQk0vZCtSbW4rdGZ1WXg3Uzk2Z2dLST0iLCJtYWMiOiI0MzM2M2NlNDE3YjMyY2ZhNjNlZTIxNGFmMDQwOTQyNjVhMzA3ZGNlMDQzZGQ5NDNlZWY0OTIxNWNhZjI4MmUzIn0='];

            $client = new Client();
            $client = $client->request('POST', 'https://api.esmsv.com/v1/campaign/getAll', [
            'headers' => $authorization,
            'form_params' => [
                'filter' => 'Ingreso VIP: '.$forms[$visitor->form_id]['Nombre completo'],
            ]]);
            $check = json_decode($client->getBody(), true)['data']['data'];

            if (!isset($check[0])) {
                $client = new Client();
                $client = $client->request('POST', 'https://api.esmsv.com/v1/listscontacts/create', [
                'headers' => $authorization,
                'form_params' => [
                    'name' => 'Ingreso VIP: '.$forms[$visitor->form_id]['Nombre completo'].rand(),
                ]]);
                $list_id = json_decode($client->getBody(), true)['data']['id'];

                foreach ($organizers as $user) {
                    $client = new Client();
                    $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/getall', [
                    'headers' => $authorization,
                    'form_params' => [
                        'email' => $user->email,
                    ]]);
                    $contacts_ids[] = json_decode($client->getBody(), true)['data']['data'][0]['id'];
                }

                $client = new Client();
                $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/suscribe', [
                'headers' => $authorization,
                'form_params' => [
                    'listId' => $list_id,
                    'contactsIds' => $contacts_ids
                ]]);

                $client = new Client();
                $client = $client->request('POST', 'https://api.esmsv.com/v1/campaign/create', [
                'headers' => $authorization,
                'form_params' => [
                    'name' => 'Ingreso VIP: '.$forms[$visitor->form_id]['Nombre completo'],
                    'subject' => 'El invitado '.$forms[$visitor->form_id]['Nombre completo'].' ha ingresado al evento',
                    'content' => '<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" border="0" cellspacing="0" cellpadding="0" width="100%"><tbody><tr><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;width: 100%; padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px" align="center"><div style="font-size: 12px;font-style: normal;font-weight: 400;"><img src="https://mediaware.org/channeltalks/imagenes/header.png" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: 0;height: auto;line-height: 100%;margin: undefined;float: none;width: auto;max-width: 600px;" alt="" border="0" width="auto" class="center fullwidth"><p style="max-width: 600px; font-size: 20px">El invitado VIP '.$forms[$visitor->form_id]['Nombre completo'].' ha ingresado al evento.</p></div></td></tr></tbody></table>',
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
            }
        }
    }
}
