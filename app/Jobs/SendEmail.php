<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use App\Models\Visitor;
use App\Models\Email;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Sheets;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = Email::find($id);
        $date = Carbon::create($email->date);
        
        if ($date->isToday()) {
            if ($email->objective == 'all') {
                $visitors = Visitor::where('event_id', $email->event_id)->where('approved', true)->get();
            } else {
                $visitors = Visitor::where('event_id', $email->event_id)->where('approved', true)->whereIn('id', explode('*', $email->objective))->get();
            }

                $authorization = ['Authorization' => 'eyJpdiI6Ik9UUXdOVFkyT1RZek5qSTNNVGs0T0E9PSIsInZhbHVlIjoiMEwwVjFjeTVyZ3ZnWlE1U204REtkQk0vZCtSbW4rdGZ1WXg3Uzk2Z2dLST0iLCJtYWMiOiI0MzM2M2NlNDE3YjMyY2ZhNjNlZTIxNGFmMDQwOTQyNjVhMzA3ZGNlMDQzZGQ5NDNlZWY0OTIxNWNhZjI4MmUzIn0='];

                $client = new Client();
                $client = $client->request('POST', 'https://api.esmsv.com/v1/listscontacts/create', [
                'headers' => $authorization,
                'form_params' => [
                    'name' => $email->name,
                ]]);
                $list_id = json_decode($client->getBody(), true)['data']['id'];

                foreach ($visitors as $visitor) {
                    $contacts_ids = [];
                    $client = new Client();
                    $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/getall', [
                    'headers' => $authorization,
                    'form_params' => [
                        'email' => $visitor->email,
                    ]]);
                    $contacts_ids[] = json_decode($client->getBody(), true)['data']['data'][0]['id'];

                    $client = new Client();
                    $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/suscribe', [
                    'headers' => $authorization,
                    'form_params' => [
                        'listId' => $list_id,
                        'contactsIds' => $contacts_ids
                    ]]);
                }

                $client = new Client();
                $client = $client->request('POST', 'https://api.esmsv.com/v1/campaign/create', [
                'headers' => $authorization,
                'form_params' => [
                    'name' => $email->name,
                    'subject' => $email->subject,
                    'content' => '<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" border="0" cellspacing="0" cellpadding="0" width="100%"><tbody><tr><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;width: 100%; padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px" align="center"><div style="font-size: 12px;font-style: normal;font-weight: 400;"><img src="https://channeltalks.net/uploads/'.$email->content.'" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: 0;height: auto;line-height: 100%;margin: undefined;float: none;width: auto;max-width: 600px;" alt="" border="0" width="auto" class="center fullwidth"></div></td></tr></tbody></table>',
                    'fromAlias' => 'Channel Talks',
                    'fromEmail' => 'channeltalks@mediaware.news',
                    'replyEmail' => 'channeltalks@mediaware.news',
                    'mailListsIds' => [$list_id],
                ]]);
                $id = json_decode($client->getBody(), true)['data']['id'];

                // $client = new Client();
                // $client = $client->request('POST', 'https://api.esmsv.com/v1/campaign/send', [
                // 'headers' => $authorization,
                // 'form_params' => [
                //     'id' => $id,
                //     'sendNow' => 1
                // ]]);

            $email->sended = true;
            $email->update();
        }
    }
}
