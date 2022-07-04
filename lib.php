<?php
    
class MyLog {
    private $mode;
    
    public function __construct($mode='a') {
        date_default_timezone_set("Europe/Sofia");    
        $this->mydate = date("d-m-Y");
        $this->filename = 'log-' . $this->mydate . '.json';
        $this->mode = $mode;
        $this->handle = fopen($this->filename, $mode);
    }

    public function __desctruct() {
        if ($this->handle) {
            fclose($this->handle);
        }
    }

    public function write($msg) {
        $msg = '[' . date("H:i:s") . '] '. json_encode($msg) . "\n";
        fwrite($this->handle, $msg);
    }


}

?>
