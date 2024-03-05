<?php

include_once("config.php");

class UserTask{

    private $userId;
    private $name;
    private $taskname;
    private $duedate;
    private $taskStatus;
    private $taskDescription;

    // Setter methods

    public function set_userId($userId) {
        $this->userId = $userId;
    }

    public function set_name($name) {
        $this->name = $name;
    }

    public function set_taskname ($taskname) {
        $this->taskname = $taskname;
    }

    public function set_duedate($duedate) {
        $this->duedate = $duedate;
    }

    public function set_taskstatus($taskStatus) {
        $this->taskStatus = $taskStatus;
    }

    public function set_Description($taskDescription) {
        $this->taskDescription = $taskDescription;
    }

    // Getter methods

    public function get_userId() {
        return $this->userId;
    }

    public function get_name() {
        return $this->name;
    }

    public function get_taskname() {
        return $this->taskname;
    }

    public function get_duedate() {
        return $this->duedate;
    }

    public function get_taskstatus() {
        return $this->taskStatus;
    }

    public function get_Description() {
        return $this->taskDescription;
    }
}

?>
