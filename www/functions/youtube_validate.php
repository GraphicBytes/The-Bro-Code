<?php

class CheckYouTubeVideo {

    /** Set Success Message */
    private function setSuccessMsg(){
        $this->exists = "YouTube Video Exists :)";
        return $this->exists;
    }

    /** Set Error Message */
    private function setErrorMsg(){
        $this->notExists = "Error... Video Broken or Doesn't Exists...";
        return $this->notExists;
    }

    /** Get Success Message */
    public function getSuccessMsg(){
        return $this->setSuccessMsg();
    }

    /** Get Error Message */
    public function getErrorMsg(){
        return $this->setErrorMsg();
    }

    /** Check if Video Exists or URL provided is Valid */
    public function checkVideo($YouTubeVideo){
        /** Check file_get_contents on https://php.net/manual/en/function.file-get-contents.php
        *   suppress the warning(FALSE) by putting an @ in front of file_get_contents.
        */
        $json_output = @file_get_contents("https://www.youtube.com/oembed?url=".$YouTubeVideo."&format=json");
        /** Check $json_output result */
        if($json_output != FALSE || $json_output != 0){
            /** Takes JSON encoded string and convert it into a PHP variable.*/
            $this->json = json_decode($json_output, true);
            /** Return encoded string */
            return $this->json;

        } else {
            /** Echo Error */
            echo $this->getErrorMsg();
            return false;
        }
    }

    /** Get YouTube Link Result...*/
    public function getResult($YouTubeVideo){
            return $this->checkVideo($YouTubeVideo);
    }
} // Class Ends

?>
