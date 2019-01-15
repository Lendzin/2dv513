<?php
namespace model;

class TruckDatabase extends Database {

    public function addJobToDatabase($startDate, $endDate, $trailer, $address, $description, $contractor, $contact, $truck, $driver) {
        if ($startDate > $endDate) {
            throw new addJobException("End Date is later than Start Date!?");
        }
        $queryDriver = "SELECT * FROM (SELECT * FROM drivers WHERE persnr NOT IN
         (SELECT driver FROM jobs WHERE start_time BETWEEN ? - INTERVAL 1 DAY AND ? + INTERVAL 1 DAY 
         OR end_time BETWEEN ?- INTERVAL 1 DAY AND ? + INTERVAL 1 DAY) 
         AND ce_license >= ? AND unavailable = '0000-00-00') AS selection 
         WHERE persnr = ?";

        if ($this->checkSafeQuery($queryDriver, $startDate, $endDate, $trailer, $driver)) {
            throw new addJobException("Driver not usable for this job!");
        }
        $queryTruck = "SELECT * FROM (SELECT * FROM trucks WHERE regnr NOT IN
         (SELECT truck FROM jobs WHERE start_time BETWEEN ? - INTERVAL 1 DAY AND ? + INTERVAL 1 DAY
         OR end_time BETWEEN ? - INTERVAL 1 DAY AND ? + INTERVAL 1 DAY) 
         AND unavailable_until = '0000-00-00' AND trailer >= ?) AS selection 
         WHERE regnr = ?";

        if ($this->checkSafeQuery($queryTruck, $startDate, $endDate, $trailer, $truck)) {
            throw new addJobException("Truck not usable for this job!");
        }
        $queryContractor = "SELECT * FROM contractors WHERE name = '$contractor'";
        if ($this->checkQuery($queryContractor)) {
            throw new addJobException("Missing Contractor!?");
        }
        $queryContact = "SELECT * FROM contractors WHERE phone = '$contact'";
        if ($this->checkQuery($queryContractor)) {
            throw new addJobException("Missing Contact!?");
        }
        if ($address == "") {
            throw new addJobException("Missing Address!?");
        }
        if ($description == "") {
            throw new addJobException("Missing Description!?");
        }
        $this->addJob($startDate, $endDate, $address, $description, $truck, $contractor, $driver, $contact);
    }

    public function addJob($startDate, $endDate, $address, $description, $truck, $contractor, $driver, $contact) {
        $queryInsert = "INSERT INTO jobs (start_time, end_time, location, description, truck, contractor, driver, contact)";
        $queryVals = " VALUES (?,?,?,?,?,?,?,?)";
        $statement = $queryInsert . $queryVals;
        $mysqli = $this->startMySQLi();
        try {
            if (!($prepStatement = $mysqli->prepare($statement))) {
                throw new \Exception("Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
            }
            if (!$prepStatement->bind_param("ssssssss", $startDate, $endDate, $address, $description, $truck, $contractor, $driver, $contact)) {
                throw new \Exception( "Binding parameters failed: (" 
                . $prepStatement->errno . ") " . $prepStatement->error);
            }
            if (!$prepStatement->execute()) {
                throw new \Exception("Execute failed: (" 
                . $prepStatement->errno . ") " . $prepStatement->error);
            }
        } catch (Exception $error) {
            throw $error;
        } finally {
            $this->killMySQLi($mysqli);
        }
    }

    private function checkSafeQuery($statement, $startDate, $endDate, $trailer, $variable) {
        $mysqli = $this->startMySQLi();
        try {
            if (!($prepStatement = $mysqli->prepare($statement))) {
                throw new \Exception("Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
            }
            if (!$prepStatement->bind_param("ssssss", $startDate, $endDate, $startDate, $endDate, $trailer, $variable)) {
                throw new \Exception( "Binding parameters failed: (" 
                . $prepStatement->errno . ") " . $prepStatement->error);
            }
            if (!$prepStatement->execute()) {
                throw new \Exception("Execute failed: (" 
                . $prepStatement->errno . ") " . $prepStatement->error);
            }
            $result = $prepStatement->get_result();
            if ($result && $result->num_rows === 1) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $error) {
            throw $error;
        } finally {
            $this->killMySQLi($mysqli);
        }
    }

    private function checkQuery($query) {
        $mysqli = $this->startMySQLi();
        $result = $mysqli->query($query);
        echo $mysqli->error;
        $this->killMySQLi($mysqli);
        if ($result && $result->num_rows === 1) {
            return false;
        } else {
            return true;
        }
    }

    public function getJobsInTimeFrameFromContractor($startDate, $endDate, $contractor) {
        $mysqli = $this->startMySQLi();
        $query = '';
        if ($contractor == '---') {
            $query = "SELECT * FROM jobs WHERE (start_time BETWEEN '$startDate' AND '$endDate') 
            AND (end_time BETWEEN '$startDate' AND '$endDate')";;
        } else {
            $query = "SELECT * FROM jobs WHERE contractor = '$contractor' 
            AND (start_time BETWEEN '$startDate' AND '$endDate') 
            AND (end_time BETWEEN '$startDate' AND '$endDate')";
        }
        $result = $mysqli->query($query);
        $this->killMySQLi($mysqli);
        $jobsArray = [];
        while ($row = $result->fetch_assoc())
        {
            $job = new Job($row['id'], $row['start_time'], $row['end_time'], $row['location'], $row['description'],
            $row['truck'], $row['contractor'], $row['driver'], $row['contact']);
            array_push($jobsArray, $job);
        }
        return $jobsArray;
    }

    public function getTrucksForDays($startDate, $endDate, $trailer) {
        $mysqli = $this->startMySQLi();
        $query = "SELECT * FROM trucks WHERE regnr NOT IN
         (SELECT truck FROM jobs WHERE start_time BETWEEN '$startDate - INTERVAL 1 DAY' AND '$endDate + INTERVAL 1 DAY' 
         OR end_time BETWEEN '$startDate - INTERVAL 1 DAY' AND '$endDate + INTERVAL 1 DAY') 
          AND unavailable_until = '0000-00-00' AND trailer >= '$trailer'";
        $result = $mysqli->query($query);
        $this->killMySQLi($mysqli);
        $trucksArray = [];
        while ($row = $result->fetch_assoc())
        {
            $truck = new Truck($row['regnr'], $row['model'], $row['min_weight'], $row['max_weight'], $row['axels'],
             $row['trailer'], $row['equipment'], $row['build_year'], $row['warranty'], $row['last_tested'],
              $row['last_service'], $row['last_lubrication'], $row['unavailable_until'], $row['rented_until']);
            array_push($trucksArray, $truck);
        }
        return $trucksArray;

    }
    public function getLastWorkedFor($contractor) {
        $query = "SELECT end_time FROM jobs WHERE contractor = '$contractor' ORDER BY `jobs`.`end_time` DESC LIMIT 1";
        $mysqli = $this->startMySQLi();
        $result = $mysqli->query($query);
        $this->killMySQLi($mysqli);
        $row = $result->fetch_assoc();
        if ($row['end_time']) {
            return $row['end_time'];
        } else {
            return '';
        }
        
    }

    public function getContactsWithContractors() {
        $query = "SELECT contact, `contact address`, `contact phone`, `contact email`, `contractor`, `contractor description`, `contractor address`, `contractor phone`, `contractor email`  FROM
        (SELECT name AS 'contact', address AS 'contact address', phone AS 'contact phone', email AS 'contact email', contractor FROM contacts) AS contact
        INNER JOIN
        (SELECT name, description AS 'contractor description', address AS 'contractor address', phone AS 'contractor phone', email AS 'contractor email' FROM contractors) AS contractor
        ON (contact.contractor = contractor.name)";
        $mysqli = $this->startMySQLi();
        $result = $mysqli->query($query);
        $this->killMySQLi($mysqli);
        return $result;
    }

    public function searchAvailableDaysInPeriod($startDate, $endDate, $trailer, $load) {
        $startDate = new \DateTime($startDate);
        $endDate = new \DateTime($endDate);
        $endDate->modify('+1 day');
        $period = new \DatePeriod(
            $startDate,
            new \DateInterval('P1D'),
            $endDate
        );
        if ($load == '---') {
            $load = 0;
        }

        $query = '';
        $days = array();
        foreach ($period as $value) {
            $date = $value->format('Y-m-d');
            $dayAvail = new DayAvailables($date);
            array_push($days, $dayAvail);
            $query .= "(SELECT '$date' AS date, persnr, regnr FROM drivers CROSS JOIN trucks WHERE persnr
            NOT IN (SELECT driver FROM jobs WHERE '$date' BETWEEN jobs.start_time AND jobs.end_time)
            AND regnr
            NOT IN (SELECT truck FROM jobs WHERE '$date' BETWEEN jobs.start_time AND jobs.end_time)
            AND unavailable = '0000-00-00' AND unavailable_until = '0000-00-00' 
            AND ce_license >= $trailer AND trailer >= $trailer AND ((max_weight - min_weight)*($trailer+1)) >= $load
            GROUP BY regnr, persnr)
            UNION ";
        }
        
        $query = rtrim($query, 'UNION ');
        $mysqli = $this->startMySQLi();
        if ($result = $mysqli->query($query)) {
            $resultClone = $mysqli->query($query);
            $date = '';
            $persnr = '';
            $regnr = '';
            $dateClone = '';
            $count = 0;
            $changeDay = 0;
            while ($row = $result->fetch_assoc())
            {   
                if($count != 0) {
                    $row2 = $resultClone->fetch_assoc();
                    $dateClone = $row2['date'];
                }
                $date = $row['date'];

                if ($date !== $dateClone) {
                    if ($count > 0) {
                        $changeDay++;
                    }
                } 
                if ($row['regnr']) {
                    $regnr = $row['regnr'];
                    if($truck = $this->getTruck($regnr)) {
                        if (!$days[$changeDay]->searchTruck($regnr)) {
                            $days[$changeDay]->addTruck($truck);
                        }
                    }
                }
                if ($row['persnr']) {
                    $persnr = $row['persnr'];
                    if ($driver = $this->getDriver($persnr)) {
                        if (!$days[$changeDay]->searchDriver($persnr)){
                            $days[$changeDay]->addDriver($driver);
                        }
                    }
                }
                $count++;
 
            }
            
        } 
        echo $mysqli->error;
        $this->killMySQLi($mysqli);
        return $days;
    }

    public function getDriversForDays($startDate, $endDate, $trailer) {
        $mysqli = $this->startMySQLi();
        $query = "SELECT * FROM drivers WHERE persnr NOT IN
         (SELECT driver FROM jobs WHERE start_time BETWEEN '$startDate - INTERVAL 1 DAY' AND '$endDate + INTERVAL 1 DAY'
        OR end_time BETWEEN '$startDate - INTERVAL 1 DAY' AND '$endDate + INTERVAL 1 DAY') 
        AND ce_license >= $trailer AND unavailable = '0000-00-00'";
        $result = $mysqli->query($query);
        $this->killMySQLi($mysqli);
        $driversArray = [];
        while ($row = $result->fetch_assoc())
        {
            $driver = new Driver($row['persnr'], $row['name'], $row['address'], $row['email'], $row['phone'], $row['contract_start'],
             $row['contract_end'], $row['ce_license'], $row['exp_ykb'], $row['fuel_card'], $row['unavailable']);
            array_push($driversArray, $driver);
        }
        return $driversArray;
    }

    public function getTrucksForMaintenence($startdate, $endDate) {
        $mysqli = $this->startMySQLi();
        $query = "(
        SELECT 'yes' AS past_due, regnr, last_lubrication + INTERVAL 2 MONTH AS 'lubrication', last_service + INTERVAL 4 MONTH AS 'service', last_tested + INTERVAL 1 YEAR AS 'inspection' 
        FROM trucks 
        WHERE last_lubrication  + INTERVAL 2 MONTH < '$startdate' 
        OR last_service + INTERVAL 4 MONTH < '$startdate' 
        OR last_tested + INTERVAL 1 YEAR < '$startdate')
        UNION
        (SELECT 'no' AS past_due, regnr, last_lubrication + INTERVAL 2 MONTH AS 'lubrication', last_service + INTERVAL 4 MONTH AS 'service', last_tested + INTERVAL 1 YEAR AS 'inspection' 
        FROM trucks 
        WHERE last_lubrication + INTERVAL 2 MONTH >= '$startdate'
        AND last_service + INTERVAL 4 MONTH  >= '$startdate'
        AND last_tested + INTERVAL 1 YEAR >= '$startdate'
        AND (last_lubrication  + INTERVAL 2 MONTH BETWEEN '$startdate' AND '$endDate'
        OR last_service + INTERVAL 4 MONTH BETWEEN '$startdate' AND '$endDate'
        OR last_tested + INTERVAL 1 YEAR BETWEEN '$startdate' AND '$endDate')
        )";
        $result = $mysqli->query($query);
        $this->killMySQLi($mysqli);
        $serviceArray = [];
        while ($row = $result->fetch_assoc())
        {
            $service = new Service($row['regnr'], $row['past_due'], $row['lubrication'], $row['service'], $row['inspection']);
            array_push($serviceArray, $service);
        }
        return $serviceArray;
    }

    public function getContacts() : Array {
        $mysqli = $this->startMySQLi();
        $query = "SELECT * FROM contacts";
        $result = $mysqli->query($query);
        $this->killMySQLi($mysqli);
        $contactsArray = [];
        while ($row = $result->fetch_assoc())
        {
            $contact = new Contact($row['name'], $row['address'], $row['phone'], $row['email'], $row['contractor']);
            array_push($contactsArray, $contact);
        }
        return $contactsArray;
    }
    public function getContractors() : Array {
        $mysqli = $this->startMySQLi();
        $query = "SELECT * FROM contractors";
        $result = $mysqli->query($query);
        $this->killMySQLi($mysqli);
        $contractorsArray = [];
        while ($row = $result->fetch_assoc())
        {
            $contractor = new Contractor($row['name'], $row['description'], $row['address'], $row['phone'], $row['email']);
            array_push($contractorsArray, $contractor);
        }
        return $contractorsArray;
    }
    public function getDriver($driver) {
        $mysqli = $this->startMySQLi();
        $query = "SELECT * FROM drivers WHERE persnr = $driver";
        $result = $mysqli->query($query);
        $this->killMySQLi($mysqli);
        $row = $result->fetch_assoc();
        return new Driver($row['persnr'], $row['name'], $row['address'], $row['email'], $row['phone'], $row['contract_start'],
        $row['contract_end'], $row['ce_license'], $row['exp_ykb'], $row['fuel_card'], $row['unavailable']);
    }
    public function getDrivers() : Array {
        $mysqli = $this->startMySQLi();
        $query = "SELECT * FROM drivers";
        $result = $mysqli->query($query);
        $this->killMySQLi($mysqli);
        $driversArray = [];
        while ($row = $result->fetch_assoc())
        {
            $driver = new Driver($row['persnr'], $row['name'], $row['address'], $row['email'], $row['phone'], $row['contract_start'],
             $row['contract_end'], $row['ce_license'], $row['exp_ykb'], $row['fuel_card'], $row['unavailable']);
            array_push($driversArray, $driver);
        }
        return $driversArray;
    }

    public function getTruck($truck) {
        $mysqli = $this->startMySQLi();
        $query = "SELECT * FROM trucks WHERE regnr = '$truck'";
        $result = $mysqli->query($query);
        $this->killMySQLi($mysqli);
        $row = $result->fetch_assoc();
        return new Truck($row['regnr'], $row['model'], $row['min_weight'], $row['max_weight'], $row['axels'],
        $row['trailer'], $row['equipment'], $row['build_year'], $row['warranty'], $row['last_tested'],
        $row['last_service'], $row['last_lubrication'], $row['unavailable_until'], $row['rented_until']);
        

    }
    public function getTrucks() : Array {
        $mysqli = $this->startMySQLi();
        $query = "SELECT * FROM trucks";
        $result = $mysqli->query($query);
        $this->killMySQLi($mysqli);
        $trucksArray = [];
        while ($row = $result->fetch_assoc())
        {
            $truck = new Truck($row['regnr'], $row['model'], $row['min_weight'], $row['max_weight'], $row['axels'],
             $row['trailer'], $row['equipment'], $row['build_year'], $row['warranty'], $row['last_tested'],
              $row['last_service'], $row['last_lubrication'], $row['unavailable_until'], $row['rented_until']);
            array_push($trucksArray, $truck);
        }
        return $trucksArray;
    }

    public function getMaxLoads() : Array {
        $mysqli = $this->startMySQLi();
        $query = "SELECT trailer, (max_weight - min_weight) AS summed FROM trucks GROUP BY summed";
        $result = $mysqli->query($query);
        $this->killMySQLi($mysqli);
        $weightsArray = [];
        while ($row = $result->fetch_assoc())
        {
            array_push($weightsArray, $row['summed']);
            if ($row['trailer'] == 1) {
                if ($row['summed'] <= 16000 && $row['summed'] >= 13000) {
                    array_push($weightsArray, (string)($row['summed']*2));
                }
            }
        }
        sort($weightsArray);

        return $weightsArray;
    }
}