<?php
class Page
{
    private $headSegmentsList; 
    private $bodySegmentsList;

    public function __construct($headSegmentsList, $bodySegmentsList)
    {
        $this->headSegmentsList = $headSegmentsList; 
        $this->bodySegmentsList = $bodySegmentsList;

        $this->htmlOpen();
        $this->headOpen(); 
        foreach ($headSegmentsList as $headSegment){
            include_once "pages/html/".$headSegment;
        }
        $this->headClose(); 
        $this->bodyOpen(); 
        foreach ($bodySegmentsList as $bodySegment){
            include_once "pages/html/".$bodySegment;
        }
        $this->bodyClose(); 

        $this->htmlClose(); 
    }
    public function htmlOpen()
    {
        echo '<!DOCTYPE html>
        <html lang="en">';
    }
    public function htmlClose()
    {
        echo '</html>'; 
    }
    public function bodyOpen()
    {
        echo '<body>'; 
    }
    public function bodyClose()
    {
        echo '</body>'; 
    }
    public function headOpen()
    {
        echo '<head>'; 
    }
    public function headClose()
    {
        echo '</head>'; 
    }
}
?>