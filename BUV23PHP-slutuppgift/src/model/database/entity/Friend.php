<?php

class Friend
{
    private string $user_id_a;
    private string $user_id_b;
    private string $status;
    private DateTime $created_at;



    public function getUserIdA(): string
    {
        return $this->user_id_a;
    }

    public function setUserIdA(string $user_id_a): void
    {
        $this->user_id_a = $user_id_a;
    }

    public function getUserIdB(): string
    {
        return $this->user_id_b;
    }

    public function setUserIdB(string $user_id_b): void
    {
        $this->user_id_b = $user_id_b;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }
}
