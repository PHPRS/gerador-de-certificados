<?php 
class JsonAdapter {
    public function __construct($config) {
        $this->file = json_decode(file_get_contents($config['file']));
    }

    public function find($email) {
        foreach ($this->file->attendee as $attendee) {
            if ($attendee->email == $email) {
                return $attendee;
            }
        } 
        return null;
    }
}