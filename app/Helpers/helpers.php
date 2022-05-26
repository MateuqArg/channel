<?php
    function cachedForms($query) {
        if ($query == 'all') {
            $events = App\Models\Event::all();
            $forms = collect();
            foreach ($events as $event) {
                $sheets = Sheets::spreadsheet($event->spread)->sheet('Respuestas de formulario 1')->get();
                $header = $sheets->pull(0);
                $collection = Sheets::collection($header, $sheets);
                // foreach ($collection as $key => $row) {
                //     $collection[$key]->put('event_id', $event->id);
                // }
                $forms = $collection->concat($forms);
                // $forms[$event->id] = $collection;
            }
        } else {
            $events = App\Models\Event::all();
            $sheets = Sheets::spreadsheet($query)->sheet('Respuestas de formulario 1')->get();
            $header = $sheets->pull(0);
            $forms = Sheets::collection($header, $sheets);
        }
        \Cache::put('forms', $forms);
    }

    function getNames($query) {
        if ($query == 'all') {
            $events = App\Models\Event::all();
            $forms = array();
            foreach ($events as $event) {
                $sheets = Sheets::spreadsheet($event->spread)->sheet('Respuestas de formulario 1')->range('A:A')->range('C:C')->get();
                $header = $sheets->pull(0);
                $collection = Sheets::collection($header, $sheets);
                foreach ($collection as $key => $row) {
                    $collection[$key]->put('event_id', $event->id);
                    $collection[$key]->put('id', $key);
                }
                $forms = $collection->merge($forms);
                // $forms[$event->id] = $collection;
            }
        }
        return $forms;
    }

    function createCustomid($length = 6) {
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }