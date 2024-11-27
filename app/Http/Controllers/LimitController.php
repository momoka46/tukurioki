<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Recipe;
use Auth;

class LimitController extends Controller
{
    public function create(Request $request, Event $event){
        // バリデーション（eventsテーブルの中でNULLを許容していないものをrequired）
        $request->validate([
            'event_title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'event_color' => 'required',
        ]);

        // 登録処理
        $event->event_title = $request->input('event_title');
        $event->event_body = $request->input('event_body');
        $event->start_date = $request->input('start_date');
        $event->end_date = date("Y-m-d", strtotime("{$request->input('end_date')} +1 day")); // FullCalendarが登録する終了日は仕様で1日ずれるので、その修正を行っている
        $event->event_color = $request->input('event_color');
        $event->event_border_color = $request->input('event_color');
        $event->save();

        // カレンダー表示画面にリダイレクトする
        return redirect("/");
    }
}

    if(!empty($recipe->cold_storage)) {
        Event::create([
            'event_title' => "{$recipe->name}（冷蔵保存）",
            'event_body' => "冷蔵保存可能期間が終了します。",
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDays($recipe->cold_storage)->toDateString(),
            'event_color' => 'blue',
            'event_border_color' => 'blue',
            'user_id' => $userId,
        ]);
    }

    // 冷凍保存イベント
    if (!empty($recipe->frozen_storage)) {
        Event::create([
            'event_title' => "{$recipe->name}（冷凍保存）",
            'event_body' => "冷凍保存可能期間が終了します。",
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDays($recipe->frozen_storage)->toDateString(),
            'event_color' => 'green',
            'event_border_color' => 'green',
            'user_id' => $userId,
        ]);
    }


