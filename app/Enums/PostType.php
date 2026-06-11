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

    // 画面表示用の色をつけるメソッド
    public function colorClass(): string
    {
        return match ($this) {
            self::Notice => 'bg-green-100 text-gray-800',
            self::Circular => 'bg-gray-100 text-gray-800',
        };
    }
}