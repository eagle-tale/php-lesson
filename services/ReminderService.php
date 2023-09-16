<?php
include_once('..\repositories\ReminderRepository.php');

class ReminderService
{
    private readonly IReminderRepository $reminderRepository;

    public function __construct()
    {
        $this->reminderRepository = new ReminderRepository;
    }

    public function whosHash($hash)
    {
        $user_id = $this->reminderRepository->findUserFromHash($hash);
        return ($user_id);
    }

    public function save_hash($user_id, $hash, $expire_date)
    {
        $this->reminderRepository->save($user_id, $hash, $expire_date);
    }
}
