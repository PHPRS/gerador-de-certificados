<?php 

class JsonAdapter implements Adapter {
    
    private $file;

    public function __construct($file) {
        $this->file = json_decode(file_get_contents($file));
    }

    public function find($email) {
        
        $result = array();

        foreach ($this->file->attendee as $attendee) {
            if ($attendee->email == $email) {
                $result[] = (array) $attendee;
            }
        } 

        return $result;
    }
}