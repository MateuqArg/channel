<?php
    function createCustomid($length = 6) {
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function cachedForms($query) {
        if ($query == 'all') {
            $events = App\Models\Event::where('date', '>=', Carbon\Carbon::today())->orderBy('id', 'DESC')->get();

            $forms = [];
            foreach ($events as $event) {
                $sheets = Sheets::spreadsheet($event->spread)->sheet('Respuestas de formulario 1')->get();
                $header = $sheets->pull(0);
                $collection = Sheets::collection($header, $sheets);
                $forms[$event->title] = $collection;
            }
        } else {
            $events = App\Models\Event::all();
            $sheets = Sheets::spreadsheet($query)->sheet('Respuestas de formulario 1')->get();
            $header = $sheets->pull(0);
            $forms = Sheets::collection($header, $sheets);
        }
        return $forms;
        // \Cache::put('forms', $forms);
    }