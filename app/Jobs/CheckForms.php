<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Visitor;
use App\Models\Meeting;
use App\Models\User;
use App\Models\Event;
use GuzzleHttp\Client;
use Sheets;
use Image;
use Storage;
use Printing;

class CheckForms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $spread = '1KZXp18tUAQvlpHsI9n8QIH24osjQuECQ0hso7fjZ-Nw';
        $currentEvent = 'Respuestas de formulario 1';
        $sheets = Sheets::spreadsheet($spread)->sheet($currentEvent)->get();
        $header = $sheets->pull(0);
        $forms = Sheets::collection($header, $sheets);

        foreach ($forms as $form) {
            $check = Visitor::where('form_id', $form['id'])->first();
            if ($check == null) {
                do {
                    $custid = createCustomid();
                } while (Visitor::where('custid', $custid)->first() <> null);

                $event = Event::find(substr($currentEvent, strrpos($currentEvent, ' ') + 1));

                $approved = false;
                if ($event->approve == 0) {
                    $approved = true;
                }

                $visitor = new Visitor([
                    'custid' => $custid,
                    'event_id' => substr($currentEvent, strrpos($currentEvent, ' ') + 1),
                    'form_id' => $form['id'],
                    'approved' => $approved,
                    'present' => null,
                    'vip' => 0
                ]);
                $visitor->save();


                if ($event->approve == 0) {
                //     $file = QrCode::format('png')->size(305)->generate(route('organizer.visitor.track', ['custid' => $visitor->custid]));
                //     $qr_file = 'qr.png';
                //     Storage::disk('public_uploads')->put($qr_file, $file);
                //     $file = Storage::disk('public_uploads')->get($qr_file);

                //     $bg = Storage::disk('public')->get('/images/registro.jpg');

                //     $file_name = time().'.'.'png';

                //     $img = Image::make($bg);

                //     $img->text($forms[$visitor->form_id]['Nombre completo'], 350, 200, function($font) {
                //         $font->file(public_path("Montserrat.ttf"));
                //         $font->align('center');
                //         $font->color('#000');
                //         $font->size(36);
                //     });

                //     $img->insert($file, 'bottom', 350, 186);

                //     $img->save(public_path('uploads/'.$file_name));
                //     Storage::disk('public_uploads')->delete($qr_file);

                    $authorization = ['Authorization' => 'eyJpdiI6Ik9UUXdOVFkyT1RZek5qSTNNVGs0T0E9PSIsInZhbHVlIjoiMEwwVjFjeTVyZ3ZnWlE1U204REtkQk0vZCtSbW4rdGZ1WXg3Uzk2Z2dLST0iLCJtYWMiOiI0MzM2M2NlNDE3YjMyY2ZhNjNlZTIxNGFmMDQwOTQyNjVhMzA3ZGNlMDQzZGQ5NDNlZWY0OTIxNWNhZjI4MmUzIn0='];

                //     $client = new Client();
                //     $client = $client->request('POST', 'https://api.esmsv.com/v1/listscontacts/create', [
                //     'headers' => $authorization,
                //     'form_params' => [
                //         'name' => 'Asistencia aprobada: '.$forms[$visitor->form_id]['Nombre completo'],
                //     ]]);
                //     $list_id = json_decode($client->getBody(), true)['data']['id'];

                    $client = new Client();
                    $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/getall', [
                    'headers' => $authorization,
                    'form_params' => [
                        'email' => $forms[$visitor->form_id]['Direccion de email'],
                    ]]);

                    if (isset(json_decode($client->getBody(), true)['data']['data'][0]['id'])) {
                        $contacts_ids[] = json_decode($client->getBody(), true)['data']['data'][0]['id'];
                    } else {
                        $client = new Client();
                        $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/create', [
                        'headers' => $authorization,
                        'form_params' => [
                            'email' => $forms[$visitor->form_id]['Direccion de email'],
                        ]]);
                        $contacts_ids[] = json_decode($client->getBody(), true)['data']['id'];
                    }


                //     $client = new Client();
                //     $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/suscribe', [
                //     'headers' => $authorization,
                //     'form_params' => [
                //         'listId' => $list_id,
                //         'contactsIds' => $contacts_ids
                //     ]]);

                //     $client = new Client();
                //     $client = $client->request('POST', 'https://api.esmsv.com/v1/campaign/create', [
                //     'headers' => $authorization,
                //     'form_params' => [
                //         'name' => 'Registro aprobado: '.$forms[$visitor->form_id]['Nombre completo'],
                //         'subject' => '¡Has sido registrado exitosamente!',
                //         // 'content' => $img->response("png"),
                //         'content' => '<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" border="0" cellspacing="0" cellpadding="0" width="100%"><tbody><tr><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;width: 100%; padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px" align="center"><div style="font-size: 12px;font-style: normal;font-weight: 400;"><img src="'.public_path('uploads/'.$file_name).'" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: 0;height: auto;line-height: 100%;margin: undefined;float: none;width: auto;max-width: 600px;" alt="" border="0" width="auto" class="center fullwidth"></div></td></tr></tbody></table>',
                //         'fromAlias' => 'Channel Talks',
                //         'fromEmail' => 'channeltalks@mediaware.news',
                //         'replyEmail' => 'channeltalks@mediaware.news',
                //         'mailListsIds' => [$list_id],
                //     ]]);
                //     $id = json_decode($client->getBody(), true)['data']['id'];

                //     $client = new Client();
                //     $client = $client->request('POST', 'https://api.esmsv.com/v1/campaign/send', [
                //     'headers' => $authorization,
                //     'form_params' => [
                //         'id' => $id,
                //         'sendNow' => 1
                //     ]]);
                }

                if (!empty($form['Pido reunirme con...'])) {
                    $meetings = explode(', ', $form['Pido reunirme con...']);

                    foreach($meetings as $meeting) {
                        do {
                            $custid = createCustomid();
                        } while (Meeting::where('custid', $custid)->first() <> null);

                        $exhibitor = User::where('name', $meeting)->first();

                        if (!empty($exhibitor)) {
                            $meeting = new Meeting([
                                'custid' => $custid,
                                'event_id' => substr($currentEvent, strrpos($currentEvent, ' ') + 1),
                                'visitor_id' => $visitor->id,
                                'exhibitor' => $exhibitor->id,
                                'approved' => null,
                                'requested' => 'visitor'
                            ]);
                            $meeting->save();
                        }
                    }
                }
            }
        }
    }
}
