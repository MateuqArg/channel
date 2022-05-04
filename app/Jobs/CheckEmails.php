<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Visitor;
use App\Models\Email;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Sheets;

class CheckEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->spread = '1KZXp18tUAQvlpHsI9n8QIH24osjQuECQ0hso7fjZ-Nw';
        $this->currentEvent = 'Respuestas de formulario 1';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $currentEvent = 1;
        $sheets = Sheets::spreadsheet($this->spread)->sheet($this->currentEvent)->get();
        $forms = Sheets::collection($sheets->pull(0), $sheets);

        $emails = Email::where('sended', false)->get();
        foreach ($emails as $email) {
           $date = Carbon::create($email->date);
           if ($date->isToday()) {
               if ($email->objective == 'all') {
                   $visitors = Visitor::where('event_id', $currentEvent)->where('approved', true)->get();

                    $authorization = ['Authorization' => 'eyJpdiI6Ik9UUXdOVFkyT1RZek5qSTNNVGs0T0E9PSIsInZhbHVlIjoiMEwwVjFjeTVyZ3ZnWlE1U204REtkQk0vZCtSbW4rdGZ1WXg3Uzk2Z2dLST0iLCJtYWMiOiI0MzM2M2NlNDE3YjMyY2ZhNjNlZTIxNGFmMDQwOTQyNjVhMzA3ZGNlMDQzZGQ5NDNlZWY0OTIxNWNhZjI4MmUzIn0='];

                    $client = new Client();
                    $client = $client->request('POST', 'https://api.esmsv.com/v1/listscontacts/create', [
                    'headers' => $authorization,
                    'form_params' => [
                        'name' => $email->name,
                    ]]);
                    $list_id = json_decode($client->getBody(), true)['data']['id'];

                    foreach ($visitors as $visitor) {
                        $client = new Client();
                        $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/getall', [
                        'headers' => $authorization,
                        'form_params' => [
                            'email' => $forms[$visitor->form_id]['Direccion de email'],
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
                        'name' => $email->name,
                        'subject' => $email->subject,
                        'content' => $email->content,
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

           $email->sended = true;
           $email->update();
        }
    }
}
