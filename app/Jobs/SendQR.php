<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\{Visitor, Event};
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use GuzzleHttp\Client;
use Image;
use Storage;
use Sheets;
use Str;

class SendQR implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $id;
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $visitor = Visitor::find($this->id);
        $event = Event::find($visitor->event_id);

        $file = QrCode::format('png')->size(305)->generate('https://www.channeltalks.net/organizer/visitor/'.$visitor->custid);
        $file_name = Str::random(32).'.'.'png';

        $qr_file = Storage::disk('public_uploads')->put($file_name, $file);
        $file = Storage::disk('public_uploads')->get($file_name);

        $bg = base_path('public/uploads').'/'.$file_name;

        $img = Image::make($bg);

        $img->text($visitor->name, 350, 200, function($font) {
            $font->file(base_path('public/Montserrat.ttf'));
            $font->align('center');
            $font->color('#000');
            $font->size(36);
        });

        $img->insert($file, 'bottom', 350, 186);

        $file_name = Str::random(32).'.'.'png';

        $img->save(base_path('public/uploads').'/'.$file_name);
        // Storage::disk('public_uploads')->delete($file_name);

        $authorization = ['Authorization' => 'eyJpdiI6Ik9UUXdOVFkyT1RZek5qSTNNVGs0T0E9PSIsInZhbHVlIjoiMEwwVjFjeTVyZ3ZnWlE1U204REtkQk0vZCtSbW4rdGZ1WXg3Uzk2Z2dLST0iLCJtYWMiOiI0MzM2M2NlNDE3YjMyY2ZhNjNlZTIxNGFmMDQwOTQyNjVhMzA3ZGNlMDQzZGQ5NDNlZWY0OTIxNWNhZjI4MmUzIn0='];

        $client = new Client();
        $client = $client->request('POST', 'https://api.esmsv.com/v1/listscontacts/create', [
        'headers' => $authorization,
        'form_params' => [
            'name' => 'Asistencia aprobada: '.$visitor->name.rand(),
        ]]);
        $list_id = json_decode($client->getBody(), true)['data']['id'];

        $client = new Client();
        $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/getall', [
        'headers' => $authorization,
        'form_params' => [
            'email' => $visitor->email,
        ]]);

        $contacts_ids = [];
        if (!empty(json_decode($client->getBody(), true)['data']['data'])) {
            $contacts_ids[] = json_decode($client->getBody(), true)['data']['data'][0]['id'];
        } else {
            $client = new Client();
            $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/create', [
            'headers' => $authorization,
            'form_params' => [
                'email' => $visitor->email,
            ]]);
            $contacts_ids[] = json_decode($client->getBody(), true)['data']['id'];
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
            'name' => 'Registro aprobado: '.$visitor->name,
            'subject' => '¡Has sido registrado exitosamente!',
            // 'content' => $img->response("png"),
            'content' => '<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" border="0" cellspacing="0" cellpadding="0" width="100%"><tbody><tr><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;width: 100%; padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px" align="center"><div style="font-size: 12px;font-style: normal;font-weight: 400;"><img src="https://channeltalks.net/uploads/'.$file_name.'" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: 0;height: auto;line-height: 100%;margin: undefined;float: none;width: auto;max-width: 600px;" alt="" border="0" width="auto" class="center fullwidth"></div></td></tr></tbody></table>',
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
    }
}