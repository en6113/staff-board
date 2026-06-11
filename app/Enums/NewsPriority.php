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

    // 画面表示用の色をつけるメソッド
    public function colorClass(): string
    {
        return match ($this) {
            self::Normal => 'bg-gray-100 text-gray-800',
            self::Important => 'bg-purple-100 text-purple-800',
            self::Urgent => 'bg-red-100 text-red-800',
        };
    }
}