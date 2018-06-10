<?php
class Page
{
    private $headSegmentsList; 
    private $bodySegmentsList;

    public function __construct($headSegmentsList, $bodySegmentsList)
    {
        $this->headSegmentsList = $headSegmentsList; 
        $this->bodySegmentsList = $bodySegmentsList;

        foreach ($headSegmentsList as $headSegment){
            include_once "pages/html/".$headSegment;
        }

        foreach ($bodySegmentsList as $bodySegment){
            include_once "pages/html/".$bodySegment;
        }
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