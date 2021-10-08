<?php
//database connection
require "connection.php";

class Syndicate_Details
{
    public function __construct()
    {

    }
    public function view_syndicate()
    {
        $sql = "SELECT enigma_racing,horse,trainer,type,syndicate_percentage,total_shares,DATE_FORMAT(next_renewal,'%d/%m/%y') AS next_renewal,syndicator,sire,nro_members FROM `syndicate_details`";
        return executeQuery($sql);
    }
    public function view_payments()
    {
        $sql = "SELECT name,buyerEmail,horse,syndicate_name,DATE_FORMAT(start,'%d/%m/%y') AS start,no_share,method,paid FROM `payments_details`";
        return executeQuery($sql);
    }
    public function myStable($email)
    {
        $sql = "SELECT s.sire,s.horse,type,trainer,syndicate_percentage,p.no_share,total_shares,DATE_FORMAT(next_renewal,'%d/%m/%y') AS next_renewal FROM syndicate_details AS s INNER JOIN payments_details AS p
		ON s.horse = p.horse AND s.sire = p.syndicate_name WHERE p.buyerEmail = '$email' ";
        return executeQuery($sql);
    }
    //Method to insert syndicate details
    public function create_syndicate($enigma_racing, $horse, $trainer, $type, $syndicate_percentage, $total_shares, $next_renewal, $syndicator, $sire, $total_members)
    {
        $sql = "INSERT INTO syndicate_details (enigma_racing,horse,trainer,type,syndicate_percentage,total_shares,next_renewal,syndicator,sire,nro_members) VALUES('$enigma_racing',$horse,$trainer,'$type',$syndicate_percentage,$total_shares,'$next_renewal',$syndicator,$sire,$total_members);";
        //return executeQuery($sql);
        $syndicateNewID = executeQueryReturnID($sql);

        return $syndicateNewID;
    }
    public function create_payment($name, $email, $horse, $sire, $payment_date, $no_share, $method, $paid)
    {
        $sql = "INSERT INTO payments_details(name,buyerEmail,syndicate_name,horse,start,no_share,method,paid) VALUES($name,$email,$sire,$horse,'$payment_date',$no_share,'$method',$paid);";
        //return executeQuery($sql);
        $PaymentNew = executeQuery($sql);

        return $PaymentNew;
    }
    public function delete()
    {
        $sql = "TRUNCATE payments_details;";
        executeQuery($sql);
        $sql = "TRUNCATE syndicate_details;";
        executeQuery($sql);
    }
    //Method to edit syndicates
    public function edit($syndicateID, $enigma_racing, $horse, $trainer, $type, $syndicate_percentage, $total_shares, $next_renewal, $syndicator, $sire)
    {
        $sql = "UPDATE companies SET enigma_racing='$enigma_racing',horse='$horse',trainer='$trainer',type='$type',syndicate_percentage='$syndicate_percentage', total_shares='$total_shares', next_renewal='$next_renewal',syndicator='$syndicator',sire='$sire' WHERE syndicateID = '$syndicateID'";
        executeQuery($sql);

        $sw = true;

        return $sw;

    }
}
