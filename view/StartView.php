<?php
namespace view;

class StartView {

    private static $startDate = 'StartView::StartDate';
    private static $endDate = 'StartView::EndDate';
    private static $searchDate = 'StartView::SearchDate';
    private static $contractor = 'StartView::Contractor';
    private static $searchContractor = 'StartView::SearchContractor';
    private static $driver = 'StartView::Driver';
    private static $load = 'StartView::Load';
    private static $trailer = 'StartView::Trailer';
    private static $truck = 'StartView::Truck';
    private static $searchTruck = 'StartView::SearchTruck';
    private static $searchJobs = 'StartView::SearchJobs';
    private static $searchService = 'StartView::SearchService';
    private static $addJob = 'StartView::AddJob';
    private static $contact = 'StartView::Contact';
    private static $location = 'StartView::Location';
    private static $description = 'StartView::Description';
    private static $searchDriver = 'StartView::SearchDriver';
    private static $retrieveContacts = 'StartView::RetrieveContacts';

    private $db;
    private $dateObject;

    public function __construct() {
        $this->db = new \model\TruckDatabase();
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
                    <h1>Functionality</h1>
                <div class="messagebox">
                    <form action="?" class="editform" method="post">
                    <Label>Which date can we add a job in a timeperiod?</label><br>
                    <label>From :<input type="text" name="' . self::$startDate . '" class="IP_calendar" title="d/m/Y"></label>
                    <label>To:<input type="text" name="' . self::$endDate . '" class="IP_calendar" title="d/m/Y"></label>
                    <label>Trailer:<select name="' . self::$trailer . '" class="IP_calendar"><option value="0">No</option><option value="1">Yes</option></select></label>
                    <label>Load:<select name="' . self::$load . '" class="IP_calendar"> ' . $this->getLoadsDropDown() . '</select></label>
                    <input type="submit" class="button" name="' . self::$searchDate . '" value="Search Date"/>
                </form>
                </div>
                ' . $this->userWantsToSearchDate() . '
                    <div class="messagebox">
                        <form action="?" class="editform" method="post">
                        <Label>Add job to database</label><br>
                        <label>Start Date :<input type="text" name="' . self::$startDate . '" class="IP_calendar" value= "'. $this->getStartDate() .'" title="d/m/Y"></label>
                        <label>End Date :<input type="text" name="' . self::$endDate . '" class="IP_calendar" value= "'. $this->getEndDate() .'"title="d/m/Y"></label>
                        <label>Trailer:<select name="' . self::$trailer . '" class="IP_calendar"><option value="0">No</option><option value="1">Yes</option></select></label>
                        <label>Address:<textarea type="text" name="' . self::$location . '" class="IP_calendar">'. $this->getAddress() .'</textarea></label>
                        ' . $this->getErrorMessage() . '
                        ' . $this->unsetError() . '
                        ' . $this->unsetNonError() . '
                        <br>
                        <label>Description:<textarea type="text" name="' . self::$description . '" class="IP_calendar">'. $this->getDescription() .'</textarea></label>
                        <label>Contractor :<select name="' . self::$contractor . '"   class="IP_calendar">' . $this->getContractorsDropDown() . '</select></label>
                        <label>Contact :<select name="' . self::$contact . '"  class="IP_calendar">' . $this->getContactsDropDown() . ' </select></label>
                        <label>Truck:<select name="' . self::$truck . '" class="IP_calendar">' . $this->getTruckOptions() . ' </select></label>
                        <label>Driver:<select name="' . self::$driver . '" class="IP_calendar">' . $this->getDriverOptions() . '</select></label>
                        
                        <input type="submit" class="button" name="' . self::$addJob . '" value="Add Job"/>
                        </form>
                    </div>
                    ' . $this->userWantsToAddJob() . '
                    <div class="messagebox">
                        <form action="?" class="editform" method="post">
                        <Label>When did we last work for?</label><br>
                        <label>Contractor :<select name="' . self::$contractor . '" class="IP_calendar">' . $this->getContractorsDropDown() . '</select></label>
                        <input type="submit" class="button" name="' . self::$searchContractor . '" value="Search Contractor"/>
                        </form>
                    </div>
                    ' . $this->userWantsToCheckContractor() . '
                    <div class="messagebox">
                        <form action="?" class="editform" method="post">
                        <Label>Which jobs do we have within timeframe by?</label><br>
                        <label>From :<input type="text" name="' . self::$startDate . '" class="IP_calendar" title="d/m/Y"></label>
                        <label>To:<input type="text" name="' . self::$endDate . '" class="IP_calendar" title="d/m/Y"></label>
                        <label>Contractor:<select name="' . self::$contractor . '"   class="IP_calendar">' . $this->getContractorsDropDown() . '</select></label>
                        <input type="submit" class="button" name="' . self::$searchJobs . '" value="Search Jobs"/>
                        </form>
                    </div>
                    ' . $this->userWantsToSearchJobs() . '
                    <div class="messagebox">
                        <form action="?" class="editform" method="post">
                        <Label>List trucks available for specified day</label><br>
                        <label>From :<input type="text" name="' . self::$startDate . '" class="IP_calendar" title="d/m/Y"></label>
                        <label>Trailer:<select name="' . self::$trailer . '" class="IP_calendar"><option value="0">No</option><option value="1">Yes</option></select></label>
                        <input type="submit" class="button" name="' . self::$searchTruck . '" value="Search Truck"/>
                    </form>
                    </div>
                    ' . $this->userWantsToListTrucksForTheDay() . '
                    <div class="messagebox">
                        <form action="?" class="editform" method="post">
                        <Label>List drivers available for specified day</label><br>
                        <label>Date :<input type="text" name="' . self::$startDate . '" class="IP_calendar" title="d/m/Y"></label>
                        <label>CE-License?:<select name="' . self::$trailer . '" class="IP_calendar"><option value="0">No</option><option value="1">Yes</option></select></label>
                        <input type="submit" class="button" name="' . self::$searchDriver . '" value="Search Driver"/>
                    </form>
                    </div>
                    ' . $this->userWantsToListDriversForTheDay() . '
                    <div class="messagebox">
                    <form action="?" class="editform" method="post">
                    <Label>Get all contacts with their contractors</label><br>
                    <input type="submit" class="button" name="' . self::$retrieveContacts . '" value="Get Contacts"/>
                    </form>
                    </div>
                    ' . $this->userWantsTorRetrieveAllContactsWithContractors() . '
                    <div class="messagebox">
                        <form action="?" class="editform" method="post">
                        <Label>Which trucks have service, lubrication or inspection within timeframe?</label><br>
                        <label>From :<input type="text" name="' . self::$startDate . '" class="IP_calendar" title="d/m/Y"></label>
                        <label>To:<input type="text" name="' . self::$endDate . '" class="IP_calendar" title="d/m/Y"></label>
                        <input type="submit" class="button" name="' . self::$searchService. '" value="Search Service"/>
                    </form>
                    </div>
                    ' . $this->userWantsToSeeTrucksInNeedOfMaintenence() . '
                    <div class="container">
                        ' . $this->renderTimeTag() . '
                    </div>
                </div>
                <div><p class="unselectable footer">js224nk@student.lnu.se | Jonas Strandqvist</p></div>
            </body>
        </html>';
    }
    private function getErrorMessage() {
        if (isset($_SESSION['errorMessage'])) {
            return '<span class="alert-fail">' . $_SESSION['errorMessage'] . '</span>';
        } else if (isset($_SESSION['Message'])){
            return '<span class="alert-success">' . $_SESSION['Message'] . '</span>';
        } else {
            return "";
        }
    }
    private function unsetNonError() {
        if(isset($_SESSION['Message'])) {
            unset($_SESSION['Message']);
        };
    }
    private function unsetError() {
        if (isset($_SESSION['errorMessage'])) {
            unset($_SESSION['errorMessage']);
        }
    }
    private function getTruckOptions() {
        if ($this->datesAreSet()) {
        $result = $this->db->getTrucksForDays($this->fixDateString(($this->getStartDate())),$this->fixDateString(($this->getEndDate())),$this->getTrailerStatus());
        $returnString = '<option>---</option>';
        foreach ($result as $value) {
            $returnString .= '<option value = "' . $value->getRegnr() . '">' . $value->getRegnr() . '</option>';
        }
        return $returnString;
        } else 
        return $this->getTrucksDropDown();
    }
    private function getDriverOptions() {
        if ($this->datesAreSet()) {
        $result = $this->db->getDriversForDays($this->fixDateString(($this->getStartDate())),$this->fixDateString(($this->getEndDate())),$this->getTrailerStatus());
        $returnString = '<option>---</option>';
        foreach ($result as $value) {
            $returnString .= '<option value="' . $value->getPersnr() . '">' . $value->getName() . '</option>';
        }
        return $returnString;
        } else 
        return $this->getDriversDropDown();
    
    }



    private function getTrailerStatus() {
        return isset($_POST[self::$trailer]) ? $_POST[self::$trailer] : "0";
    }

    public function datesAreSet() {
        return ($this->getStartDate() && $this->getEndDate()) ? true : false;        
    }
    private function getStartDate() {
        return isset($_POST[self::$startDate]) ? $_POST[self::$startDate] : "";
    }
    private function getEndDate() {
        return isset($_POST[self::$endDate]) ? $_POST[self::$endDate] : "";
    }
    private function getAddress() {
        return isset($_POST[self::$location]) ? $_POST[self::$location] : "";
    }
    private function getDescription() {
        return isset($_POST[self::$description]) ? $_POST[self::$description] : "";
    }
    private function getDriver() {
        return isset($_POST[self::$driver]) ? $_POST[self::$driver] : "";
    }
    private function getTruck() {
        return isset($_POST[self::$truck]) ? $_POST[self::$truck] : "";
    }
    private function getContact() {
        return isset($_POST[self::$contact]) ? $_POST[self::$contact] : "";
    }
    private function getContractor() {
        return isset($_POST[self::$contractor]) ? $_POST[self::$contractor] : "";
    }
    private function getLoad() {
        return isset($_POST[self::$load]) ? $_POST[self::$load] : "";
    }

    private function userWantsToSeeTrucksInNeedOfMaintenence() {
        if( isset($_POST[self::$searchService])) {
            $this->searchService();
        }
    }

    private function userWantsToListTrucksForTheDay() {
        if( isset($_POST[self::$searchTruck])) {
            $this->listTrucksForTheDay();
        }
    }
    private function userWantsToListDriversForTheDay() {
        if( isset($_POST[self::$searchDriver])) {
            $this->listDriversForTheDay();
        }
    }

    private function userWantsToAddJob() {
        if( isset($_POST[self::$addJob])) {
            $this->addJob();
        }
    }
    private function addJob() {
        try {
            $this->db->addJobToDatabase($this->fixDateString($this->getStartDate()), $this->fixDateString($this->getEndDate()), $this->getTrailerStatus(), $this->getAddress(),
            $this->getDescription(), $this->getContractor(), $this->getContact(), $this->getTruck(), $this->getDriver());
        } catch (\model\addJobException $error) {
            $_SESSION['errorMessage'] = $error->getMessage();
        }
        if (!isset($_SESSION['errorMessage'])) {
            $_SESSION['Message'] = 'Job Added!';
        }

    }
    private function userWantsToSearchJobs() {
        if( isset($_POST[self::$searchJobs])) {
            $this->searchJobs();
        }
    }

    private function userWantsToCheckContractor() {
        if( isset($_POST[self::$searchContractor])) {
            $this->searchContractor();
        }
    }

    private function userWantsToSearchDate() {
        if( isset($_POST[self::$searchDate])) {
            $this->searchDate();
        }
    }

    private function searchService() {
        $startDate = $this->fixDateString($this->getStartDate());
        $endDate = $this->fixDateString($this->getEndDate());
        $services = $this->db->getTrucksForMaintenence($startDate, $endDate);
        echo '<div class="whitepost">';
        echo "<h2>Between " . $startDate . " and " . $endDate . " these trucks are due for maintenece or inspection:</h2>";
        $renderString =
        '<TABLE class="table">
        <tr>
            <th>Past due:</th>
            <th>Truck:</th>
            <th>Lubrication:</th>
            <th>Service:</th>
            <th>Inspection:</th>
        </tr>';
        foreach ($services as $service) {
            if ($service->getPastDue() == 'yes') {
                $renderString .='
                <tr>
                    <td class="redcolorTD">'. $service->getPastDue() .'</td>
                    ';
                } else {
                    $renderString .='
                    <tr>
                        <td>'. $service->getPastDue() .'</td>';
                }
                $renderString .='
                    <td>'. $service->getRegnr() .'</td>';
                $renderString .='
                    <td class="'.$this->getColorWarning($service->getLubrication(), $startDate).'">'. $service->getLubrication() .'</td>
                    <td class="'.$this->getColorWarning($service->getService(), $startDate).'">'. $service->getService() .'</td>
                    <td class="'.$this->getColorWarning($service->getInspection(), $startDate).'">'. $service->getInspection() .'</td>
                </tr>';

            
        }
        echo $renderString . "</TABLE>";
        echo "</div>";
    }

    private function getColorWarning($date, $controlDate) {
        return ($controlDate >= $date) ? "redcolorTD" : "";
    }

    private function listDriversForTheDay() {
        $date = $this->fixDateString($this->getStartDate());
        $drivers = $this->db->getDriversForDays($date, $date, $this->getTrailerStatus());
        echo '<div class="whitepost">';
        echo
        '<TABLE class="table">
        <h2>For ' . $date . ' these drivers ';
        if ($this->getTrailerStatus() == 1) {
            echo 'with CE license, ';
        }
         echo 'are available:</h2>
        <tr>
            <th>Driver</th>
            <th>Persnr</th>
        </tr>';
        foreach ($drivers as $driver) {
            echo '<tr><td>' . $driver->getName() . '</td> <td>' . $driver->getPersnr() . '</td></tr>';
        }
        echo "</table></div>";
    }
    private function listTrucksForTheDay() {
        $date = $this->fixDateString($this->getStartDate());
        $trucks = $this->db->getTrucksForDays($date, $date, $this->getTrailerStatus());
        echo '<div class="whitepost">';
        echo
        '<TABLE class="table">
        <h2>For ' . $date . ' these trucks ';
        if ($this->getTrailerStatus() == 1) {
            echo 'with trailer, ';
        }
        echo 'are available:</h2>
        <tr>
            <th>Model</th>
            <th>Regnr</th>
        </tr>';
        foreach ($trucks as $truck) {
            echo '<tr><td>' . $truck->getModel() . '</td> <td>' . $truck->getRegnr() . '</td></tr>';
        }
        echo "</table></div>";
    }

    private function searchJobs() {
        $startDate = $this->fixDateString($this->getStartDate());
        $endDate = $this->fixDateString($this->getEndDate());
        $contractor = $this->getContractor();
        $jobs = $this->db->getJobsInTimeFrameFromContractor($startDate, $endDate, $contractor);
        echo '<div class="whitepost">';
        if ($contractor == '---') {
            echo "<h2>Listing ALL jobs between: " . $startDate . " and " . $endDate . "</h2>";
        } else {
            echo "<h2>Listing jobs for " . $contractor . " between: " . $startDate . " and " . $endDate . "</h2>";
        }
        if (count($jobs) != 0) {
            $renderString =
            '<TABLE class="table">
            <tr>
            <th>Job ID:</th>
            <th>Start-date</th>
            <th>End-date</th>
            <th>Location</th>
            <th>Description</th>
            <th>Truck</th>
            <th>Driver</th>
            <th>Contact</th>';
            if ($contractor = '---') {
                $renderString .= '<th>Contractor</th>';
            }
            $renderString .='</tr>';
            foreach ($jobs as $job) {
                $renderString .=
                '<tr><td>' . $job->getID() . '</td>
                <td>' . $job->getStart() . '</td>
                <td>' . $job->getEnd() . '</td>
                <td>' . $job->getLocation() . '</td>
                <td>' . $job->getDescription() . '</td>
                <td>' . $job->getTruck() . '</td>
                <td>' . $job->getDriver() . '</td>
                <td>' . $job->getContact() . '</td>';
                if ($contractor == '---') {
                    $renderString .= '<td>' . $job->getContractor() . "</td>";
                }
                $renderString .= '</tr>';
            }
            echo $renderString;
            echo '</TABLE></div>';
        } else {
            echo '<h2>No jobs listed under this time period</h2></div>';
        }
        
    }
    private function userWantsTorRetrieveAllContactsWithContractors() {
        if( isset($_POST[self::$retrieveContacts])) {
            $this->retrieveAllContactsWithContractors();
        }
    }

    private function retrieveAllContactsWithContractors() {
        $result = $this->db->getContactsWithContractors();
        echo '
        <div class="whitepost">
        <TABLE class="table">
        <tr>
            <th>Contact</th>
            <th>Contact address</th>
            <th>Contact phone</th>
            <th>Contact email</th>
            <th>Contractor</th>
            <th>Contractor desc.</th>
            <th>Contractor address</th>
            <th>Contractor phone</th>
            <th>Contractor email</th>
        </tr>';
        while ($row = $result->fetch_assoc())
        {
            echo '<tr>';
            echo '<td>' . $row['contact'] .'</td>';
            echo '<td>' . $row['contact address'] .'</td>';
            echo '<td>' . $row['contact phone'] .'</td>';
            echo '<td>' . $row['contact email'] .'</td>';
            echo '<td>' . $row['contractor'] .'</td>';
            echo '<td>' . $row['contractor description'] .'</td>';
            echo '<td>' . $row['contractor address'] .'</td>';
            echo '<td>' . $row['contractor phone'] .'</td>';
            echo '<td>' . $row['contractor email'] .'</td>';
            echo '</tr>';
        }
        echo '</TABLE></div>';

    }

    private function searchContractor() {
        $date = $this->db->getLastWorkedFor($this->getContractor());
        $today = $this->dateObject->format('Y-m-d');
        echo '<div class="whitepost">';
        if ($date == '') {
            echo "<h2>We have never worked for " . $this->getContractor() . "</h2>";;
        }
        else if ($today < $date) {
            echo "<h2>We are working for " . $this->getContractor() . " until $date" . "</h2>";;
        } else if ($today > $date){
            echo "<h2>Last we worked for " . $this->getContractor() . " was: $date " . "</h2>";;
        } else {
            echo "<h2>Today is the last scheduled time that we work for " . $this->getContractor() . "</h2>";
        }
        echo '</div>';
    }

    private function searchDate() {
        $days = $this->db->searchAvailableDaysInPeriod($this->fixDateString($this->getStartDate()), $this->fixDateString($this->getEndDate()), $this->getTrailerStatus(), $this->getLoad());
        echo '<div class="whitepost">';
        if (count($days) != 0) {
            foreach ($days as $day) {
                $trucks = $day->getTrucks();
                $drivers = $day->getDrivers();
                if (count($trucks) != 0 && count($drivers) != 0) {
                    $renderString =
                    '<TABLE class="table">
                    <h3> Date:' . $day->getDate() . '</h3>';
                    $renderString .=
                    '<tr><th colspan="2">Drivers</th><th colspan="2">Trucks</th></tr>
                    <tr>                    
                        <th>Driver Persnr</th>    
                        <th>Driver Name</th>
                        <th>Truck Regnr</th>
                        <th>Truck Model</th>
                    </tr>';
                    $counter = (count($trucks) >= count($drivers)) ? count($trucks) : count($drivers);
                    for($i = 0; $i < $counter; $i++) {
                        $renderString.='<tr>';
                        if (count($drivers) > $i) {
                            $renderString .= '<td>' . $drivers[$i]->getPersnr() . '</td>
                            <td>' . $drivers[$i]->getName()  . '</td>';
                        } else {
                            $renderString .= '<td> - - </td>
                            <td> - - </td>';
                        }
                        if (count($trucks) > $i) {
                            $renderString .= '<td>' . $trucks[$i]->getRegnr() . '</td>
                            <td>' . $trucks[$i]->getModel() . '</td>';
                        } else {
                            $renderString .= '<td> - - </td>
                            <td> - - </td>';
                        }
                        $renderString.='</tr>';
                    }
                    echo $renderString;
                    echo "</TABLE>";
                } else {
                    echo "<h2>Sorry, there are not enough drivers or trucks available for this time-frame.</h2>";
                }
            }
            echo '</div>';
        } else {
            echo "<h2>Sorry, there are not enough drivers or trucks available for this time-frame.</h2>";
            echo "</div>";
        }
        
    }

    private function fixDateString($string) {
        if ($string != '') {
            $array = explode('/', $string);
            $temp = $array[0];
            $array[0] = $array[2];
            $array[2] = $temp;
            $string = implode('-', $array);
        }
        return $string;
    }
    private function getContractorsDropDown() {
        $result = $this->db->getContractors();
        $returnString = '<option>---</option>';
        foreach ($result as $value) {
            $returnString .= '<option value = "' . $value->getName() . '">' . $value->getName() . '</option>';
        }
        return $returnString;
    }
    private function getDriversDropDown() {
        $result = $this->db->getDrivers();
        $returnString = '<option>---</option>';
        foreach ($result as $value) {
            $returnString .= '<option value="' . $value->getPersnr() . '">' . $value->getName() . '</option>';
        }
        return $returnString;
    }
    private function getTrucksDropDown() {
        $result = $this->db->getTrucks();
        $returnString = '<option>---</option>';
        foreach ($result as $value) {
            $returnString .= '<option value = "' . $value->getRegnr() . '">' . $value->getRegnr() . '</option>';
        }
        return $returnString;
    }
    private function getContactsDropDown() {
        $result = $this->db->getContacts();
        $returnString = '<option>---</option>';
        foreach ($result as $value) {
            $returnString .= '<option value = "' . $value->getPhone() . '">' . $value->getName() . '</option>';
        }
        return $returnString;
    }
    private function getLoadsDropDown() {
        $result = $this->db->getMaxLoads();
        $returnString = '<option>---</option>';
        foreach ($result as $value) {
            $returnString .= '<option>' . $value . '</option>';
        }
        return $returnString;
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

