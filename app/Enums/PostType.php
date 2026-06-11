<?php

namespace App\Enums;

enum PostType: string
{
    case Notice = 'notice';
    case Circular = 'circular';

    // 画面表示用の日本語を返すメソッド
    public function label(): string
    {
        return match ($this) {
            self::Notice => '掲示',
            self::Circular => '回覧',
        };
    }
}