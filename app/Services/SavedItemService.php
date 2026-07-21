<?php

namespace App\Services;

use App\Models\Member;
use App\Models\BookData;
use App\Models\SavedItem;

class SavedItemService
{
    public function saveItem(Member $member, BookData $bookData): SavedItem
    {
        // Use firstOrCreate to prevent duplicates
        return SavedItem::firstOrCreate([
            'member_id' => $member->member_id,
            'book_data_id' => $bookData->book_data_id,
        ]);
    }

    public function removeItem(Member $member, BookData $bookData): void
    {
        SavedItem::where('member_id', $member->member_id)
            ->where('book_data_id', $bookData->book_data_id)
            ->delete();
    }
}
