<?php

require_once('AppSettings.php');
require_once('controller/MainController.php');
require_once('controller/FeedbackController.php');
require_once('controller/LoginController.php');
require_once('controller/RegisterController.php');
require_once('controller/CookieController.php');
require_once('controller/NoteController.php');
require_once('view/LoginView.php');
require_once('view/RegisterView.php');
require_once('view/LayoutView.php');
require_once('view/CookieView.php');
require_once('view/NoteView.php');
require_once('view/StartView.php');
require_once('model/Session.php');
require_once('model/Database.php');
require_once('model/UserDatabase.php');
require_once('model/MessageDatabase.php');
require_once('model/User.php');
require_once('model/ValidatedUser.php');
require_once('model/Username.php');
require_once('model/Password.php');
require_once('model/Message.php');
require_once('model/errors/PasswordTooShortException.php');
require_once('model/errors/UsernameInvalidCharsException.php');
require_once('model/errors/UsernameTooShortException.php');
require_once('model/errors/UserExistsException.php');
require_once('view/calendar/tc_calendar.php');

session_start();

try {
    $mainController = new \controller\MainController();
    $mainController->run();
} catch (Exception $error) {
    // LOG ERROR 
    // haven't found how to log an error in nginx without throwing, and throwing negates reset.
    header('Location: ?'); // reset app on error, untested.
    exit();
}
// $database = new \model\Database();
// $truckInsert = "INSERT INTO trucks (regnr, model, min_weight, max_weight, axels, trailer, equipment, build_year, warranty, last_tested, last_service, last_lubrication, unavailable_period, rental_period) "; 
// $truckVal1 = "VALUES ('BXP465', 'SCANIA R480', '32500', '48000', '4', '1', 'plow, salter, hooklift', '2010', '2015-10-10', '2018-07-19', '2018-11-01', '2018-12-01', '0000-00-00', '0000-00-00')";
// $truckVal2 = "VALUES ('TXY621', 'SCANIA R550', '32500', '48000', '4', '1', 'salter, hooklift', '2012', '2018-01-14', '2018-12-01', '2018-09-05', '2018-12-20', '0000-00-00', '0000-00-00')";
// $truckVal3 = "VALUES ('VHA253', 'VOLVO F40', '24500', '40000', '3', '1', 'hooklift', '2010', '2014-03-11', '2018-01-09', '2018-09-12', '2018-11-25', '0000-00-00', '0000-00-00')";
// $truckVal4 = "VALUES ('VAX128', 'VOLVO F50', '27000', '42000', '3', '1', 'plow, salter, hooklift', '2014', '2018-06-11', '2018-06-06', '2018-10-12', '2018-12-11', '2019-01-03', '0000-00-00')";
// $truckVal5 = "VALUES ('RXY248', 'SCANIA R650', '31900', '48000', '4', '1', 'hooklift', '2018', '2023-10-10', '2018-10-16', '2018-10-16', '2018-11-23', '0000-00-00', '0000-00-00')";
// $truckVal6 = "VALUES ('RXY256', 'SCANIA R650', '31900', '48000', '4', '1', 'hooklift', '2018', '2023-10-10', '2018-10-16', '2018-10-16', '2018-11-15', '0000-00-00', '0000-00-00')";
// $truckVal7 = "VALUES ('RXY242', 'SCANIA R650', '31900', '48000', '4', '1', 'hooklift', '2018', '2023-10-10', '2018-10-16', '2018-11-12', '2018-11-12', '0000-00-00', '0000-00-00')";
// $truckVal8 = "VALUES ('BNL376', 'SCANIA R500', '27000', '60000', '3', '1', 'gravel_trailer', '2017', '2022-09-07', '2017-06-03', '2018-09-12', '2018-09-12', '0000-00-00', '0000-00-00')";
// $truckVal9 = "VALUES ('BRE292', 'VOLVO F50', '27000', '42000', '3', '1', 'hooklift', '2018', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '2019-01-23')";
// $truckVal10 = "VALUES ('EXB053', 'MAN TGM', '24500', '33000', '2', '0', 'garbage', '2008', '2013-04-12', '2018-03-12', '2018-07-13', '2018-07-13', '0000-00-00', '0000-00-00')";
// $truckVal11 = "VALUES ('EXB058', 'MAN TGM', '24500', '33000', '2', '0', 'garbage', '2008', '2013-04-12', '2018-03-19', '2018-07-26', '2018-07-26', '0000-00-00', '0000-00-00')";
// $trucks = array($truckVal1, $truckVal2, $truckVal3, $truckVal4, $truckVal5, $truckVal6, $truckVal7, $truckVal8, $truckVal9, $truckVal10, $truckVal11);
// runQueryForArray($database, $trucks, $truckInsert);

// $contractorInsert = "INSERT INTO contractors (name, description, address, phone, email)";
// $contractorVal1 = "VALUES ('JM Bygg', 'Company handling construction, renovation, entreprenad', 'Gustav III:s Boulevard 64, 169 74 Solna', '004687828700', 'info@jm.se')";
// $contractorVal2 = "VALUES ('Adelso Entreprenad', 'Company handling roadwork, digging, entreprenad', 'Bryggavägen 127, 178 31 Ekerö', '0046856031015', 'info@adelsoentreprenad.se')";
// $contractorVal3 = "VALUES ('Svevia', 'Company handling infrastructure, roadwork, asphalt', 'Svetsarvägen 8A, 171 41 Solna', '004684041000', 'info@svevia.se')";
// $contractorVal4 = "VALUES ('Peab', 'Company handling construction, roadwork, infrastructure, asphalt', 'Gårdsvägen 6, 169 70 Solna', '004686236800', 'info@peab.se')";
// $contractorVal5 = "VALUES ('Foria', 'Company handling roadwork, digging, entreprenad', 'Hammarbacken 6A, 191 49 Sollentuna', '0046104745000', 'info@foria.se')";
// $contractorVal6 = "VALUES ('Ragn-Sells', 'Company handling garbage, recycling', 'Regeringsgatan 55, 111 56 Stockholm', '0046771888888', 'info@ragnsells.com')";
// $contractors = array($contractorVal1, $contractorVal2, $contractorVal3, $contractorVal4, $contractorVal5, $contractorVal6);
// runQueryForArray($database, $contractors, $contractorInsert);


// $driverInsert = "INSERT INTO drivers (persnr, name, address, email, phone, contract_start, contract_end, d_license, exp_ykb, fuel_card, status)";
// $driverVal1 =  "VALUES ('198409080051', 'Jonas Strandqvist', 'Dovregatan 20, 16436, Kista', 'lendzin@gmail.com', '0046733502189', '2004-06-12', '2015-09-22', 'ABCE', '2019-07-12', '9292838727282', 'unavailable')";
// $driverVal2 =  "VALUES ('196112310023', 'Billy Strandqvist', 'Oxdragarbacken 11, xxxxx, Norrtalje', 'oxdragarbacken@gmail.com', '0046708392411', '1990-03-22', '0000-00-00', 'BCE', '2022-03-14', '12311125466', 'available')";
// $driverVal3 =  "VALUES ('198212160246', 'Andreas Strandqvist', 'Avldalsvagen 21, 16575 Hassleby', 'likvidation@gmail.com', '0046723125223', '2004-06-12', '2015-09-22', 'BCE', '2020-06-14', '2242638221222', 'available')";
// $driverVal4 =  "VALUES ('197307020240', 'Fredrik Bergkvist', 'Akersbergavagen 12, xxxxx, Akersberga', 'fredrik@gmail.com', '0046733502189', '2004-06-12', '2015-09-22', 'BC', '2019-07-12', '1292835767272', 'available')";
// $driverVal5 =  "VALUES ('198602140045', 'Peter Hammar', 'Tabyvagen 1, xxxxx, Taby', 'peter@gmail.com', '0046987402345', '2004-06-12', '2015-09-22', 'CE', '2019-07-12', '2292438757687', 'available')";
// $driverVal6 =  "VALUES ('198905080230', 'Bert Adil', 'Bergsvagen 121, xxxxx, Danderyd', 'bert@gmail.com', '0046879645888', '2004-06-12', '2015-09-22', 'BC', '2019-07-12', '6276858323282', 'available')";
// $driverVal7 =  "VALUES ('199011020167', 'Rolf Mojner', 'Tapetserarvagen 14, xxxxx, Norrtalje', 'rolf@gmail.com', '0046119874758', '2004-06-12', '2015-09-22', 'BC', '2019-07-12', '2342833467282', 'vacation')";
// $driverVal8 =  "VALUES ('199509120220', 'Erik Stenkvist', 'Kvistvagen 421, xxxxx, Bergshamra', 'erik@gmail.com', '0046098277833', '2004-06-12', '2015-09-22', 'BCE', '2019-07-12', '2342834726682', 'available')";
// $driverVal9 =  "VALUES ('196406240022', 'Rickard Brunholf', 'Hemnasvagen 220, xxxxx, Upplands Vasby', 'rickard@gmail.com', '0046733892888', '2004-06-12', '2015-09-22', 'BCE', '2019-07-12', '234283556282', 'available')";
// $driverVal10 = "VALUES ('195606110205', 'John Bergman', 'Rimbovagen 140, xxxxx, Rimbo', 'john@gmail.com', '0046720990034', '2004-06-12', '2015-09-22', 'BCE', '2019-07-12', '5232855527282', 'available')";
// $driverVal11 = "VALUES ('198104180254', 'Stefan Klingberg', 'Vallentunavagen 9, xxxxx, Vallentuna', 'stefan@gmail.com', '0046789828223', '2004-06-12', '2015-09-22', 'ABCE', '2019-07-12', '5295568922282', 'sick')";
// $drivers = array($driverVal1, $driverVal2, $driverVal3, $driverVal4, $driverVal5, $driverVal6, $driverVal7, $driverVal8, $driverVal9, $driverVal10, $driverVal11);
// runQueryForArray($database, $drivers, $driverInsert);

// $contactInsert = "INSERT INTO contacts (name, address, phone, email, contractor)";
// $contactVal1 = "VALUES ('Johan Sibart', 'none', '0046704995993', 'johan_sibart@jm.se', 'JM Bygg')";
// $contactVal2 = "VALUES ('Fredirk Grund', 'none', '0046734295193', 'grund_fr@gmail.com', 'Adelso Entreprenad')";
// $contactVal3 = "VALUES ('Stefan Berg', 'none', '0046744291123', 'berg_stefan@svevia.se', 'Svevia')";
// $contactVal4 = "VALUES ('Johan Ritwerd', 'none', '0046733295913', 'ritwerd@svevia.se', 'Svevia')";
// $contactVal5 = "VALUES ('Anna Klint', 'none', '0046734921953', 'klint_anna@peab.se', 'Peab')";
// $contactVal6 = "VALUES ('Therese Bergart', 'none', '0046724496793', 'bergart@gmail.com', 'Peab')";
// $contactVal7 = "VALUES ('Linus Akesson', 'none', '0046714294793', 'linus@jm.se', 'JM Bygg')";
// $contactVal8 = "VALUES ('Timo Wolf', 'none', '0046733295672', 'timo@adelso.se', 'Adelso Entreprenad')";
// $contactVal9 = "VALUES ('Linus Johansson', 'none', '0046723995221', 'linus@gmail.com', 'Foria')";
// $contacts = array($contactVal1, $contactVal2, $contactVal3, $contactVal4, $contactVal5, $contactVal6, $contactVal7, $contactVal8, $contactVal9);
// runQueryForArray($database, $contacts, $contactInsert);

// $jobInsert = "INSERT INTO jobs (start_time, end_time, location, description, truck, contractor, driver, contact)";
// $jobVal1 =  "VALUES ('2019-01-03', '2019-01-27', 'SOLNA', 'bortforsling av sten', 'BXP465', 'JM Bygg', '198409080051', '0046704995993')";
// $jobs = array($jobVal1);
// runQueryForArray($database, $jobs, $jobInsert);

function runQuery($database,$query) {
        $db = $database->startMySQLi();
        $result = $db->query($query);
        $insert_id = $db->insert_id;
        $count = 0;
        
        if ($result) {
        //     var_dump($result);
        //     while ($row = $result->fetch_assoc())
        //     {
        //         if ($count < 1) {
        //         var_dump($row);
        //         }
        //     $count++;
        //     }
        // echo "Amount of rows : " . $count . "<br>";
        } else {
            echo $db->error;
            echo "<br>";
        }
        $database->killMySQLi($db);
        return $insert_id;
}

function runQueryForArray($database, $array, $insert) {
    foreach ($array as $value) {
        $queryValue = $insert . $value;
        runQuery($database, $queryValue);
    }
}

