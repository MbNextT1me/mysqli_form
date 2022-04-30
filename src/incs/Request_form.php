<?php

include "dbh.php";

class Request_form extends dbh
{
    public static $subjects = [
        1 => 'Бизнес',
        2 => 'Технологии',
        3 => 'Реклама и Маркетинг',
    ];

    public static $payments = [
        1 => 'WebMoney',
        2 => 'Яндекс.Деньги',
        3 => 'PayPal',
        4 => 'Кредитная карта',
    ];

    public $flag = 0;
    public $name = '';
    public $surname = '';
    public $email = '';
    public $phone = '';
    public $subject = '';
    public $payment = '';
    public $mailing = 0;
    public $date = 0;
    public $ipaddr = '';

    public $data= array();

    public function __construct($data){
        if(is_array($data)) {
            $this->flag = 0;
            $this->name = $data['name'];
            $this->surname = $data['surname'];
            $this->email = $data['email'];
            $this->phone = $data['phone'];
            $this->subject = in_array($data['subjects'], self::$subjects);
            $this->payment = in_array($data['payment'], self::$payments);
            $this->mailing = $data['mailing'];
            $this->date = date('Y-m-d H:i:s');
            $this->ipaddr = $_SERVER['REMOTE_ADDR'];
        }
        else if (is_int($data) and $data == 0){
            return;
        }
    }


   public function save(){
        array_push($this->data, $this->flag,$this->name,$this->surname,$this->email,$this->phone,$this->subject,$this->payment,$this->mailing,$this->date,$this->ipaddr);
        $this->saveAllInfo($this->data);
   }

    public function coutForm(){
        $datas = $this->getAllInfo();
        if ($datas != null) {
            $counter = 1;
            foreach ($datas as $data) {
                if ($data["deleted"] == 0) {
                    echo "<tr>";
                    echo "<td><input type='checkbox' name='{$data["id"]}'></td>";
                    echo "<td>" . $counter . "</td>";
                    $sliced = array_slice($data, 2);
                    foreach ($sliced as $key => $row) {
                        if ($key == "subject") $row = self::$subjects[$row];
                        if ($key == "payment") $row = self::$payments[$row];
                        echo "<td>" . $row . "</td>";
                    }
                    $counter++;
                    echo "</tr>";
                }
            }
        }
    }

    public function dellRow($data) {
        foreach ($data  as $k => $v) {
            $this->delRow($k);
        }
    }
}