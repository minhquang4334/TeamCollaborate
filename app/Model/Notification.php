<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //
    const READ = true;
    const NOT_READ = false;
    public function markAsRead()
    {
        if (is_null($this->read_at)) {
            $this->forceFill(['read_at' => $this->freshTimestamp(),
                'is_read' => self::READ,
            ])->save();
        }
    }
}
