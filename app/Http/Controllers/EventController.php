<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function show(){
        return view("calendars/calendar");
    }

    public function create(Request $request, Event $event){
        // バリデーション（eventsテーブルの中でNULLを許容していないものをrequired）
        $request->validate([
            'name' => 'required',
            'start' => 'required',
            'end' => 'required',
            'color' => 'required',
            'user_id'=>'required'
        ]);

        // 登録処理
        $event->name = $request->input('name');
        //$event->event_body = $request->input('event_body');
        $event->start = $request->input('start');
        $event->end= date("Y-m-d", strtotime("{$request->input('end')} +1 day")); // FullCalendarが登録する終了日は仕様で1日ずれるので、その修正を行っている
        $event->color = $request->input('color');
       // $event->event_border_color = $request->input('event_color');
        $event->save();

        // カレンダー表示画面にリダイレクトする
        return redirect(route("show"));
    }

    // DBから予定取得
    public function get(Request $request, Event $event){
        // バリデーション
        $request->validate([
            'start' => 'required|integer',
            'end' => 'required|integer'
        ]);

        // 現在カレンダーが表示している日付の期間
        $start = date('Y-m-d', $request->input('start') / 1000); // 日付変換（JSのタイムスタンプはミリ秒なので秒に変換）
        $end = date('Y-m-d', $request->input('end') / 1000);

        // 予定取得処理（これがaxiosのresponse.dataに入る）
        return $event->query()
            // DBから取得する際にFullCalendarの形式にカラム名を変更する
            ->select(
                'id',
                'name as name',
               // 'event_body as description',
                'start as start',
                'end as end',
                'color as backgroundColor',
                //'event_border_color as borderColor'
            )
            // 表示されているカレンダーのeventのみをDBから検索して表示
            ->where('end', '>', $start)
            ->where('start', '<', $end) // AND条件
            ->get();
    }

}
