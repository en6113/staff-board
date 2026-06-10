<?php

namespace App\Enums;

enum NewsPriority: string
{
    case Normal = 'normal';
    case Important = 'important';
    case Urgent = 'urgent';

    // 画面表示用の日本語を返すメソッド
    public function label(): string
    {
        return match ($this) {
            self::Normal => '通常',
            self::Important => '重要',
            self::Urgent => '至急',
        };
    }
}