<?php
include_once('..\services\ReminderService.php');

class ReminderController
{
    private readonly ReminderService $reminderService;

    public function __construct()
    {
        $this->reminderService = new ReminderService;
    }
    public function whosHash($hash)
    {
        if (strlen($hash) == 15) {
            return ($this->reminderService->whosHash($hash));
        } else {
            echo 'エラー：ハッシュの長さ';
        }
    }

    public function save_hash($user_id, $hash, $expire_date)
    {
        $this->reminderService->save_hash($user_id, $hash, $expire_date);
    }
}
