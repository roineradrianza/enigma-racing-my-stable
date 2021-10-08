<?php
ini_set('max_execution_time', 1500);
ini_set('memory_limit', "512M");
session_start();
require '../vendor/autoload.php';
if ($_SESSION['position'] == "admin" or $_SESSION['position'] == "Admin") {
    //Require the model of the syndicate details;

    require_once '../model/Syndicate_details.php';
    $syndicateModel = new Syndicate_Details();

    /*Get the new file to be uploaded*/
    $excelFile = $_FILES['excelFile'];
    $data = array('success' => false, 'message' => "");
    $ext = explode(".", $_FILES["excelFile"]["name"]);
    $excelFile = 'ENIGMA_Racing_Syndicates' . '.' . end($ext);
    move_uploaded_file($_FILES["excelFile"]["tmp_name"], "../files/" . $excelFile);

    /*Delete the old data of the database to be replaced with the new ones*/
    $syndicateModel->delete();

    //File where the data is going to be extracted
    $inputFileName = '../files/ENIGMA_Racing_Syndicates.xlsx';

    //Extension of the file, in this case is 'Xlsx';
    $inputFileType = 'Xlsx';

    /**  Create a new Reader of the type defined in $inputFileType  **/
    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
    /**  Advise the Reader to load all Worksheets  **/
    $reader->setReadDataOnly(true)->setLoadAllSheets();
    $spreadsheet = $reader->load($inputFileName);
    $totalSheets = $spreadsheet->getSheetCount();

    //Read each worksheet and start to import the required data to the database

    for ($sheetIndex = 0; $sheetIndex < $totalSheets; $sheetIndex++) {
        $actualSheet = $spreadsheet->getSheet($sheetIndex);
        //syndicate details vars
        $enigma_racing = '';
        $horse = '';
        $trainer = '';
        $type = '';
        $syndicate_percentage = '';
        $total_shares = '';
        $next_renewal = '';
        $syndicator = '';
        $sire = '';
        $syndicate_members = "";
        $total_members = 0;
        foreach ($actualSheet->getRowIterator() as $row) {
            foreach ($row->getCellIterator() as $cell) {
                //Obtaining the value of the cell
                $docValue = $cell->getCalculatedValue();
                //Get the number of row e.g "1"
                $row = $cell->getRow();
                //Get the letter of the column e.g "A"
                $column = $cell->getColumn();

                //Load data from the syndicate details to be uploaded
                if ($docValue === "Enigma Racing") {
                    $enigma_racing = $actualSheet->getCell("B" . "$row");

                }
                /*Get Sire data*/
                if ($docValue === "Sire") {
                    $sire = '"' . $actualSheet->getCell("B" . "$row") . '"';

                }
                /*Get Horse data*/
                if ($docValue === "Horse") {
                    $horse = '"' . $actualSheet->getCell("B" . "$row") . '"';
                    $sire_row = $row + 7;
                    $sire = '"' . $actualSheet->getCell("B" . "$sire_row") . '"';
                    $row2 = 1;

                    /*Get Members data*/
                    for ($i = $row - 5; $i > $row2; $i--) {
                        $total_members++;
                        $name = '"' . $actualSheet->getCell("A" . $i) . '"';
                        $email = '"' . $actualSheet->getCell("B" . $i) . '"';
                        $start = $actualSheet->getCell("C" . $i)->getFormattedValue();
                        $dateStartFormatted = array("date" => "");
                        if ($start !== "") {
                            $converStartToDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($start);
                            $dateStartFormatted = (array) $converStartToDate;
                        } else {
                            $dateStartFormatted = array("date" => "");
                        }
                        $no_share = $actualSheet->getCell("D" . $i);
                        $method = $actualSheet->getCell("E" . $i);
                        if ($actualSheet->getCell("F" . $i)->getCalculatedValue() == "" or $actualSheet->getCell("F" . $i)->getCalculatedValue() == null) {
                            $paid = 0.00;
                        } else {
                            $paid = $actualSheet->getCell("F" . $i)->getCalculatedValue();
                        }
                        $start = $dateStartFormatted["date"];

                        $syndicateModel->create_payment($name, $email, $horse, $sire, $start, $no_share, $method, $paid);
                    }
                }
                /*Get Trainer data*/
                if ($docValue === "Trainer" and $docValue !== "") {
                    $trainer = '"' . $actualSheet->getCell("B" . "$row") . '"';

                }
                /*Get Type data*/
                if ($docValue === "Type" and $docValue !== "") {
                    $type = $actualSheet->getCell("B" . "$row");

                }
                /*Get Syndicate % data*/
                if ($docValue === "Syndicate %") {
                    $syndicate_percentage = $actualSheet->getCell("B" . "$row")->getCalculatedValue() * 100.00;

                }
                /*Get Total shares data*/
                if ($docValue === "Total shares") {
                    $total_shares = $actualSheet->getCell("B" . "$row")->getCalculatedValue();

                }
                /*Get Next renewal data*/
                if ($docValue === "Next renewal") {
                    $date = $actualSheet->getCell("B" . "$row")->getFormattedValue();
                    if ($date !== "") {
                        $converToDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date);
                        $DateFormatted = (array) $converToDate;
                        $next_renewal = $DateFormatted["date"];

                    }
                }
                /*Get syndicator data*/
                if ($docValue === "Syndicator") {
                    $syndicator = '"' . $actualSheet->getCell("B" . "$row") . '"';

                }
            }
        }
        $syndicateModel->create_syndicate($enigma_racing, $horse, $trainer, $type, $syndicate_percentage, $total_shares, $next_renewal, $syndicator, $sire, $total_members);
        $total_member = 0;
    }
    $message = 'success';
    return $message;
}
