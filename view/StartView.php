<?php
namespace view;

class StartView {

    private static $search = 'StartView::Search';
    private static $date = 'StartView::Date';
    private $dateObject;

    public function __construct() {

    }
  
    public function render() : void {
        $this->setDateObject();
        echo 
        '<!DOCTYPE html>
        <html lang="en">
            <head>
                <link rel="stylesheet" type="text/css" href="styles.css" />
                <meta charset="utf-8">
                <title>Login Example</title>
                <script type="text/javascript" src="http://services.iperfect.net/js/IP_generalLib.js"></script>
            </head>
            <body class="unselectable">
                <div><p class="unselectable header">SITENAME_UNDERSCORE</p></div>
                <div class="maindiv">
                    <h1>Adding a job?</h1>
                    <div class="messagebox">
                    <form action="?" class="editform" method="post">
                    <label>Get list of available :<input type="text" name="' . self::$date . '" id="date1" alt="date" class="IP_calendar" title="d/m/Y"></label>
                    <input type="submit" class="button" name="' . self::$search . '" value="Search"/>
                    </form>
                    </div>
                    <div class="container">
                        ' . $this->renderTimeTag() . '
                    </div>
                </div>
                <div><p class="unselectable footer">js224nk@student.lnu.se | Jonas Strandqvist</p></div>
            </body>
        </html>';
    }

    public function calenderPicker() {

    }
  
    public function setDateObject() {
        $this->dateObject = new \DateTime('now', new \DateTimeZone('Europe/Stockholm'));
    }
    public function renderTimeTag() {
		$dayOfMonth = $this->dateObject->format('Y-m-d');
        $dateString =  $dayOfMonth;
        return "<p class='time'>" . $dateString . "</p>";
	}
}