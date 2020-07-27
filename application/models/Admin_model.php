<?php

class Admin_Model extends CI_Model
{

    public $tbl;

    public function __construct()
    {
        parent::__construct();

        $this->config->load('authme');
    }

     public function _get_all_rooms(){
        $this -> db -> select('
            tbl_room_info.id AS room_id,
            tbl_room_info.room_name,
            tbl_room_info.rate,
            tbl_room_info.floor,
            tbl_room_info.count  AS total_room_count,
            tbl_room_type.type AS room_type
            ');
        $this -> db -> from('tbl_room_info');
        $this-> db -> join('tbl_room_type', 'tbl_room_info.room_type = room_type.id');
        $this -> db -> order_by('tbl_room_info.room_name','ASC');

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

     public function _get_room($room_name){
        $this -> db -> select('
            tbl_room_info.id AS room_id,
            tbl_room_info.room_name,
            tbl_room_info.rate,
            tbl_room_info.floor
            ');
        $this -> db -> from('tbl_room_info');
        $this -> db -> where('tbl_room_info.room_name LIKE',$room_name);

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> row() : false;
    }

    public function _get_room_by_id($room_id){
        $this -> db -> select('
            tbl_room_info.id AS room_id,
            tbl_room_info.room_name,
            tbl_room_info.rate,
            tbl_room_info.floor,
            tbl_room_info.max_capacity
            ');
        $this -> db -> from('tbl_room_info');
        $this -> db -> where('tbl_room_info.id',$room_id);

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> row() : false;
    }

    public function _get_all_checkin_data(){
        $this -> db -> select('*');
        $this -> db -> from('tbl_checkin');
        $this-> db -> join('tbl_room_info', 'tbl_checkin.room_id = tbl_room_info.id');
        $this-> db -> join('tbl_room_type', 'tbl_room_info.room_type = tbl_room_type.id');
        $this-> db -> join('tbl_guest_info', 'tbl_checkin.guest_id = tbl_guest_info.id');
        $this -> db -> order_by('tbl_room_info.room_name','ASC');

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

    public function _get_all_guests(){
        $this -> db -> select('*, id AS guest_id');
        $this -> db -> from('tbl_guest_info');

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

    //  public function _get_payment_by_guest($guest_id){
    //     $this -> db -> select('*,');
    //     $this -> db -> from('tbl_payment_history');
    //     $this-> db -> join('tbl_checkin', 'tbl_checkin.service_id = tbl_payment_history.service_id');
    //     $this -> db -> order_by('payment_id','DESC');
    //     $this -> db -> where('tbl_payment_history.guest_id',$guest_id);

    //     $query = $this-> db -> get();
    //     return ($query -> num_rows() > 0) ? $query -> result() : false;
    // }

    public function _get_payment_by_guest($guest_id){
        $this -> db -> select('*,');
        $this -> db -> from('tbl_payment_history');
        $this-> db -> join('tbl_checkin', 'tbl_checkin.service_id = tbl_payment_history.service_id
            or tbl_checkin.guest_id = tbl_payment_history.guest_id');
        $this -> db -> order_by('payment_id','DESC');
        $this -> db -> group_by('tbl_payment_history.payment_id');
        $this -> db -> where('tbl_payment_history.guest_id',$guest_id);

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

    public function _get_sum_payment_by_guest($guest_id){
        $this -> db -> select('SUM(payment_amount) AS sum_payment');
        $this -> db -> from('tbl_payment_history');
        $this -> db -> where('tbl_payment_history.guest_id',$guest_id);

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> row() : false;
    }

     public function _get_total_due_by_guest($guest_id){
        $this -> db -> select('SUM(total_amount) AS total_due');
        $this -> db -> from('tbl_checkin');
        $this -> db -> where('tbl_checkin.guest_id',$guest_id);

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> row() : false;
    }

    public function _get_payment_by_id($payment_id,$service_id){
        $this -> db -> select('*');
        $this -> db -> from('tbl_payment_history');
        $this-> db -> join('tbl_checkin', 'tbl_checkin.service_id = tbl_payment_history.service_id');
        $this -> db -> where('tbl_payment_history.payment_id',$payment_id);
        $this -> db -> where('tbl_payment_history.service_id',$service_id);
        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

    // FOR FULL PAYMENT
    public function _get_payment_by_guest_id($guest_id){
        $this -> db -> select('SUM(payment_amount) AS total_payment, SUM(total_amount_due) AS total_due');
        $this -> db -> from('tbl_payment_history');
       // $this-> db -> join('tbl_checkin', 'tbl_checkin.service_id = tbl_payment_history.service_id');
        $this -> db -> where('tbl_payment_history.guest_id',$guest_id);
        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

    public function _get_checkin_data($service_id){
        $this -> db -> select('*');
        $this -> db -> from('tbl_checkin');
        $this-> db -> join('tbl_room_info', 'tbl_checkin.room_id = tbl_room_info.id');
        $this-> db -> join('tbl_room_type', 'tbl_room_info.room_type = tbl_room_type.id');
        $this-> db -> join('tbl_guest_info', 'tbl_checkin.guest_id = tbl_guest_info.id');
       // $this -> db -> where('tbl_checkin.status', 0); // where still checked in
        $this -> db -> where('service_id',$service_id);
       // $this -> db -> group_by('tbl_checkin.guest_id'); // group by user

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

    public function _get_checkin_data_by_guest($guest_id){
        $this -> db -> select('*, tbl_checkin.status AS c_status');
        $this -> db -> from('tbl_checkin');
        $this-> db -> join('tbl_room_info', 'tbl_checkin.room_id = tbl_room_info.id');
        $this-> db -> join('tbl_room_type', 'tbl_room_info.room_type = tbl_room_type.id');
        $this-> db -> join('tbl_guest_info', 'tbl_checkin.guest_id = tbl_guest_info.id');
        // $this-> db -> join('tbl_payment_history', 'tbl_checkin.guest_id = tbl_payment_history.guest_id');
        $this -> db -> order_by('tbl_checkin.service_id', 'DESC');
        $this -> db -> where('tbl_checkin.guest_id',$guest_id);

       // $this -> db -> group_by('tbl_checkin.guest_id'); // group by user

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

     public function _get_total_amount_due_payment($service_id){
        $this -> db -> select('total_amount_due, payment_amount');
        $this -> db -> from('tbl_payment_history');
        $this -> db -> order_by('payment_id', 'DESC');
        $this -> db -> where('service_id',$service_id);

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> row() : false;
    }

    public function _get_total_amount_due_payment_by_guest($guest_id){
        $this -> db -> select('SUM(total_amount_due) AS total_due, SUM(payment_amount) AS payment_amt');
        $this -> db -> from('tbl_payment_history');
        $this -> db -> order_by('payment_id', 'DESC');
        $this -> db -> where('tbl_payment_history.guest_id',$guest_id);
        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> row() : false;
    }

    public function _get_total_amount_due_payment_by_id($guest_id){
        $this -> db -> select('total_amount_due, payment_amount');
        $this -> db -> from('tbl_payment_history');
        $this -> db -> order_by('payment_id', 'DESC');
        $this -> db -> where('guest_id',$guest_id);

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> row() : false;
    }

    public function _get_total_amount_due_checkin($service_id){
        $this -> db -> select('total_amount');
        $this -> db -> from('tbl_checkin');
        $this -> db -> where('service_id',$service_id);

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> row() : false;
    }

    public function _get_total_amount_due_checkin_by_id($guest_id){
        $this -> db -> select('SUM(total_amount) AS total_checkin_amount');
        $this -> db -> from('tbl_checkin');
        $this -> db -> where('guest_id',$guest_id);

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> row() : false;
    }

     public function _get_guest_details($guest_id){
        $this -> db -> select('*');
        $this -> db -> from('tbl_guest_info');
        $this -> db -> where('id',$guest_id);

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

     public function _get_guest_details_by_name($firstname, $lastname){
        $this -> db -> select('*');
        $this -> db -> from('tbl_guest_info');
        $this -> db -> where('firstname',$firstname);
        $this -> db -> where('lastname',$lastname);

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> row() : false;
    }



    public function _get_all_room_types(){
        $this -> db -> select('*');
        $this -> db -> from('tbl_room_type');
        $this -> db -> order_by('type','ASC');

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

     public function _get_available_rooms() {
       /* $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d');

        $this -> db -> select('*, `tbl_room_info`.`id` AS room_id');
        $this -> db -> from('tbl_room_info');
        $this-> db -> join('tbl_checkin', 'tbl_checkin.room_id = tbl_room_info.id');
        $this-> db -> join('tbl_room_type', 'tbl_room_info.room_type = tbl_room_type.id');
        $this -> db -> where('tbl_checkin.service_id',NULL);
        $this -> db -> or_where('tbl_checkin.status',0);
        $this -> db -> or_where('tbl_checkin.checkin_date > ',$curr_date);
        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;*/

         $sql = "SELECT *, `tbl_room_info`.`id` AS room_id FROM `tbl_room_info`
        LEFT JOIN `tbl_room_type` ON `tbl_room_info`.room_type = `tbl_room_type`.id
        LEFT JOIN `tbl_checkin` on `tbl_room_info`.id = `tbl_checkin`.room_id
        LEFT JOIN `tbl_guest_info` ON `tbl_guest_info`.id = `tbl_checkin`.`guest_id`
        WHERE (checkin_date > now()) AND (checkout_date < now()) AND `tbl_checkin`.status = 0
        OR `tbl_checkin`.`service_id` IS NULL
        ORDER BY `tbl_room_type`.`type` ASC
        ";

        $query = $this->db->query($sql);

        return $query->result();
    }

    public function _get_room_types() {

         $sql = "SELECT * FROM `tbl_room_type`";

        $query = $this->db->query($sql);

        return $query->result();
    }

   public function _get_available_rooms_date($checkin, $checkout) {

        /* $sql = "SELECT *, `tbl_room_info`.`id` AS room_id  FROM `tbl_room_info`
         INNER JOIN `tbl_room_type` ON `tbl_room_info`.room_type = `tbl_room_type`.id
         LEFT JOIN `tbl_checkin` ON `tbl_checkin`.`room_id` = `tbl_room_info`.`id`
         WHERE room_id IS NULL
         OR DATE(checkin_date) >= $checkin OR DATE(checkin_date) < $checkout
        OR DATE(checkout_date) >= $checkin OR DATE(checkout_date) < $checkout
         OR `tbl_checkin`.`status` = 0
        ";*/

        $sql = "SELECT *, `tbl_room_info`.`id` AS room_id FROM `tbl_room_info`
        INNER JOIN `tbl_room_type` ON `tbl_room_info`.room_type = `tbl_room_type`.`id`
        WHERE  `tbl_room_info`.`id` NOT IN (
              SELECT room_id
              FROM `tbl_checkin`
              WHERE (`tbl_checkin`.`status` = 1  AND `tbl_checkin`.`checkin_date` >= '$checkin' AND `tbl_checkin`.`checkin_date` < '$checkout' )
                    OR
                    (`tbl_checkin`.`status` = 1  AND  `tbl_checkin`.`checkout_date` >= '$checkin' AND `tbl_checkin`.`checkout_date` < '$checkout')
            ) ";


        $query = $this->db->query($sql);
        return $query->result();
    }

     public function _get_available_rooms_datetype($checkin, $checkout, $type) {

        $sql = "SELECT *, `tbl_room_info`.`id` AS room_id FROM `tbl_room_info`
        INNER JOIN `tbl_room_type` ON `tbl_room_info`.room_type = `tbl_room_type`.`id`
        WHERE  `tbl_room_info`.`room_type` = '$type' AND `tbl_room_info`.`id` NOT IN (
              SELECT room_id
              FROM `tbl_checkin`
              WHERE (`tbl_checkin`.`status` = 1  AND `tbl_checkin`.`checkin_date` >= '$checkin' AND `tbl_checkin`.`checkin_date` < '$checkout')
                    OR
                    (`tbl_checkin`.`status` = 1  AND `tbl_checkin`.`checkout_date` >= '$checkin' AND `tbl_checkin`.`checkout_date` < '$checkout')
            ) ";


        $query = $this->db->query($sql);
        return $query->result();
    }

    public function _get_available_rooms_type($type) {
        $sql = "SELECT *, `tbl_room_info`.`id` AS room_id FROM `tbl_room_info`
        INNER JOIN `tbl_room_type` ON `tbl_room_info`.room_type = `tbl_room_type`.`id`
        WHERE `tbl_checkin`.`status` = 1  AND  `tbl_room_info`.`room_type` = '$type' ";


        $query = $this->db->query($sql);
        return $query->result();
    }

    public function _get_occupied_rooms() {

        $sql = "SELECT * FROM `tbl_room_info`
        INNER JOIN `tbl_room_type` ON `tbl_room_info`.room_type = `tbl_room_type`.id
        INNER JOIN `tbl_checkin` on `tbl_room_info`.id = `tbl_checkin`.room_id
        INNER JOIN `tbl_guest_info` ON `tbl_guest_info`.id = `tbl_checkin`.guest_id
        WHERE (checkin_date < now()) AND (checkout_date > now()) AND `tbl_checkin`.status = 1
        ";

        $query = $this->db->query($sql);

        return $query->result();
    }

    public function _get_occupied_rooms_distinct() {

        $sql = "SELECT service_id, guest_id, firstname, lastname, room_name, type, checkin_date,
        checkout_date, contact_number, reservation_date, rate, guests
        FROM  `tbl_room_info`
        INNER JOIN `tbl_room_type` ON `tbl_room_info`.room_type = `tbl_room_type`.id
        INNER JOIN `tbl_checkin` ON `tbl_room_info`.id = `tbl_checkin`.room_id
        INNER JOIN `tbl_guest_info` ON `tbl_guest_info`.id = `tbl_checkin`.guest_id
        WHERE `tbl_checkin`.status = 1
        GROUP BY `tbl_checkin`.guest_id
        ";


        $query = $this->db->query($sql);

        return $query->result();
    }

    public function _checkin($data){
        $this -> db -> insert('tbl_checkin',$data);
        return $this->db->insert_id();
    }

     //francis
    public function _add_account($data){
        $this -> db -> insert('tbl_accounts',$data);
    }

    public function _add_guest_info($data){
        $this -> db -> insert('tbl_guest_info',$data);
        return $this->db->insert_id();
    }
     public function _add_room_info($data){
        $this -> db -> insert('tbl_room_info',$data);
    }

    public function _update_room_info($room_id,$data){
        $array = array('id' => $room_id);
        $this->db->where($array);
        $this->db->update('tbl_room_info', $data);
    }

    public function _remove_room_info($room_id){
        $this -> db -> delete('tbl_room_info', array('id' => $room_id));
    }

    public function _checkout( $service_id, $data ) {
        $array = array('service_id' => $service_id);
        $this->db->where($array);
        $this->db->update('tbl_checkin', $data);
    }

     //FRANCIS
    public function _edit_products($data, $id) {
        $this->db->where('id',$id);
        $this->db->update('tbl_products', $data);
    }

    //FRANCIS
    public function _remove_account($data, $id) {
        $this->db->where('id',$id);
        $this->db->update('tbl_accounts', $data);
    }

    //francis
    public function _change_password($id,$data){
        $this->db->where('id',$id);
        $this->db->update('tbl_accounts', $data);
    }

    public function _add_products($data) {
        $this->db->insert('tbl_products', $data);
    }

    public function _delete_products($id) {
        $this->db->where('id',$id);
        $this->db->delete('tbl_products');
    }

    public function _delete_checkin($id) {
        $this->db->where('service_id',$id);
        $this->db->delete('tbl_checkin');
    }

    public function _delete_payment($id) {
        $this->db->where('service_id',$id);
        $this->db->delete('tbl_payment_history');
    }

    public function _get_rooms_by_user($guest_id){
        $this -> db -> select('*');
        $this -> db -> from('tbl_checkin');
        $this-> db -> join('tbl_room_info', 'tbl_checkin.room_id = tbl_room_info.id');
        $this-> db -> join('tbl_room_type', 'tbl_room_info.room_type = tbl_room_type.id');
        $array = array('guest_id' => $guest_id, 'status' => 1);
        $this->db->where($array);
        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }


    public function _checkin_guests_this_day(){
        $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d ');

        $this -> db -> select('*');
        $this -> db -> from('tbl_checkin');
        $this-> db -> join('tbl_room_info', 'tbl_checkin.room_id = tbl_room_info.id');
        $this-> db -> join('tbl_room_type', 'tbl_room_info.room_type = tbl_room_type.id');
        $this-> db -> join('tbl_guest_info', 'tbl_checkin.guest_id = tbl_guest_info.id');
        $array = array('DATE(checkin_date)' => $curr_date, 'tbl_checkin.status' => 1);
        $this->db->where($array);
        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

    public function _checkout_guests_this_day(){
        $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d ');

        $this -> db -> select('*');
        $this -> db -> from('tbl_checkin');
        $this-> db -> join('tbl_room_info', 'tbl_checkin.room_id = tbl_room_info.id');
        $this-> db -> join('tbl_room_type', 'tbl_room_info.room_type = tbl_room_type.id');
         $this-> db -> join('tbl_guest_info', 'tbl_checkin.guest_id = tbl_guest_info.id');
        $array = array('DATE(checkout_date)' => $curr_date, 'tbl_checkin.status' => 0);
        $this->db->where($array);
        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

    public function _checkin_guests_this_week(){

        $sql = "SELECT *
        FROM  `tbl_checkin`
        INNER JOIN `tbl_room_info` ON `tbl_checkin`.room_id = `tbl_room_info`.id
        INNER JOIN `tbl_room_type` ON `tbl_room_info`.room_type = `tbl_room_type`.id
        INNER JOIN `tbl_guest_info` ON `tbl_guest_info`.id = `tbl_checkin`.guest_id
        WHERE `tbl_checkin`.checkin_date > DATE_SUB(NOW(), INTERVAL 1 WEEK)
        AND `tbl_checkin`.checkin_date > NOW() LIMIT 10
        ";

        $query = $this->db->query($sql);

        return $query->result();
    }

    public function _all_guests_this_day(){
        $this -> db -> select('*, tbl_checkin.status');
        $this -> db -> from('tbl_checkin');
        $this-> db -> join('tbl_room_info', 'tbl_checkin.room_id = tbl_room_info.id');
        $this-> db -> join('tbl_room_type', 'tbl_room_info.room_type = tbl_room_type.id');
        $this-> db -> join('tbl_guest_info', 'tbl_checkin.guest_id = tbl_guest_info.id');
        $this-> db -> order_by('tbl_checkin.checkin_date', 'DESC');
        $this-> db -> limit('5');
        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

    public function get_events($start, $end)
    {
        $this -> db -> select('*');
        $this -> db -> from('tbl_checkin');
        $this-> db -> join('tbl_room_info', 'tbl_checkin.room_id = tbl_room_info.id');
        $this-> db -> join('tbl_room_type', 'tbl_room_info.room_type = tbl_room_type.id');
        $this-> db -> join('tbl_guest_info', 'tbl_checkin.guest_id = tbl_guest_info.id');
        $this->db->where("tbl_checkin.status =", 2);
        $this->db->where("checkin_date >=", $start);
        $this->db->where("checkin_date <=", $end);
        $query = $this-> db -> get();
        return $query;

    }
    //francis
    public function _get_daily_report($date){

     $newdate = new DateTime($date);
     $curr_date = $newdate->format('Y-m-d');

     $this -> db -> select('*, tbl_room_type.type AS room_type');
     $this -> db -> from('tbl_checkin');
     $this-> db -> join('tbl_room_info', 'tbl_checkin.room_id = tbl_room_info.id');
     $this-> db -> join('tbl_room_type', 'tbl_room_info.room_type = tbl_room_type.id');
     $this-> db -> join('tbl_guest_info', 'tbl_checkin.guest_id = tbl_guest_info.id');
     $this-> db -> join('tbl_payment_history', 'tbl_payment_history.guest_id = tbl_checkin.guest_id');
    // $this->db->where("tbl_checkin.status", 0); // compute checked out guests only
     $this -> db -> order_by('tbl_checkin.service_id','ASC');
     $this->db->where("DATE(tbl_payment_history.date_time)",$curr_date);
     $this -> db -> order_by('tbl_room_info.room_name','ASC');
     $this -> db -> group_by('tbl_payment_history.payment_id');

     $query = $this-> db -> get();
     return ($query -> num_rows() > 0) ? $query -> result() : false;
 }

    public function _get_daily_sales_report($date){

       $newdate = new DateTime($date);
       $curr_date = $newdate->format('Y-m-d');

       $this -> db -> select('tbl_products.name,tbl_transaction_history.quantity,
       tbl_products.cost,tbl_products.amount');
       $this -> db -> from('tbl_products');
       $this-> db -> join('tbl_transaction_history', 'tbl_transaction_history.product_id = tbl_products.id');
       $this-> db -> join('tbl_transaction', 'tbl_transaction.trans_id = tbl_transaction_history.transaction_id');

       $this->db->where("DATE(tbl_transaction.date_time)",$curr_date);
       $this -> db -> order_by('tbl_products.name','ASC');
       $this -> db -> order_by('tbl_transaction.date_time','ASC');
       $query = $this-> db -> get();
       return ($query -> num_rows() > 0) ? $query -> result() : false;

   }

   public function _get_monthly_sales_report($month){

     $this -> db -> select('tbl_products.name,tbl_transaction_history.quantity,
     tbl_products.cost,tbl_products.amount');
     $this -> db -> from('tbl_products');
     $this-> db -> join('tbl_transaction_history', 'tbl_transaction_history.product_id = tbl_products.id');
     $this-> db -> join('tbl_transaction', 'tbl_transaction.trans_id = tbl_transaction_history.transaction_id');

     $this->db->where("MONTH(tbl_transaction.date_time)",$month);
     $this -> db -> order_by('tbl_products.name','ASC');
     $this -> db -> order_by('tbl_transaction.date_time','ASC');

      $query = $this-> db -> get();
      return ($query -> num_rows() > 0) ? $query -> result() : false;
  }

   public function total_daily_sales_report($date){
      $newdate = new DateTime($date);
      $curr_date = $newdate->format('Y-m-d');
      $this -> db -> select('SUM(tbl_transaction.total_amount) AS sum_total');
      $this -> db -> from('tbl_transaction');
      $this->db->where("DATE(tbl_transaction.date_time)",$curr_date);

      $query = $this-> db -> get();
      return ($query -> num_rows() > 0) ? $query -> result() : false;
  }

  public function total_cost_daily_sales_report($date){
     $newdate = new DateTime($date);
     $curr_date = $newdate->format('Y-m-d');

     $this -> db -> select('SUM(tbl_products.cost) AS cost_total');
     $this -> db -> from('tbl_transaction_history');
     $this-> db -> join('tbl_products', 'tbl_products.id = tbl_transaction_history.product_id');
     $this-> db -> join('tbl_transaction', 'tbl_transaction.trans_id = tbl_transaction_history.transaction_id');
     $this->db->where("DATE(tbl_transaction.date_time)",$curr_date);

     $query = $this-> db -> get();
     return ($query -> num_rows() > 0) ? $query -> result() : false;
 }

 public function total_cost_monthly_sales_report($month){

    $this -> db -> select('SUM(tbl_products.cost) AS cost_total');
    $this -> db -> from('tbl_transaction_history');
    $this-> db -> join('tbl_products', 'tbl_products.id = tbl_transaction_history.product_id');
    $this-> db -> join('tbl_transaction', 'tbl_transaction.trans_id = tbl_transaction_history.transaction_id');
    $this->db->where("MONTH(tbl_transaction.date_time)",$month);

    $query = $this-> db -> get();
    return ($query -> num_rows() > 0) ? $query -> result() : false;
}

public function total_cost_yearly_sales_report($year){

   $this -> db -> select('SUM(tbl_products.cost) AS cost_total');
   $this -> db -> from('tbl_transaction_history');
   $this-> db -> join('tbl_products', 'tbl_products.id = tbl_transaction_history.product_id');
   $this-> db -> join('tbl_transaction', 'tbl_transaction.trans_id = tbl_transaction_history.transaction_id');
   $this->db->where("YEAR(tbl_transaction.date_time)",$year);

   $query = $this-> db -> get();
   return ($query -> num_rows() > 0) ? $query -> result() : false;
}

//francis
public function _get_yearly_sales_report($year){

  $this -> db -> select('tbl_products.name,tbl_transaction_history.quantity,
  tbl_products.cost,tbl_products.amount');
  $this -> db -> from('tbl_products');
  $this-> db -> join('tbl_transaction_history', 'tbl_transaction_history.product_id = tbl_products.id');
  $this-> db -> join('tbl_transaction', 'tbl_transaction.trans_id = tbl_transaction_history.transaction_id');

  $this->db->where("YEAR(tbl_transaction.date_time)",$year);
  $this -> db -> order_by('tbl_products.name','ASC');
  $this -> db -> order_by('tbl_transaction.date_time','ASC');

  $query = $this-> db -> get();
  return ($query -> num_rows() > 0) ? $query -> result() : false;
}

  public function total_monthly_sales_report($month){
    $this -> db -> select('SUM(tbl_transaction.total_amount) AS sum_total');
    $this -> db -> from('tbl_transaction');
    $this->db->where("MONTH(tbl_transaction.date_time)",$month);
    $query = $this-> db -> get();
    return ($query -> num_rows() > 0) ? $query -> result() : false;
  }

  public function total_yearly_sales_report($year){
    $this -> db -> select('SUM(tbl_transaction.total_amount) AS sum_total');
    $this -> db -> from('tbl_transaction');
    $this->db->where("YEAR(tbl_transaction.date_time)",$year);

     $query = $this-> db -> get();
     return ($query -> num_rows() > 0) ? $query -> result() : false;
 }

    public function _get_inventory_report(){

       $this -> db -> select('*');
       $this -> db -> from('tbl_products');

       $query = $this-> db -> get();
       return ($query -> num_rows() > 0) ? $query -> result() : false;
   }

     public function _get_monthly_report($month){

        $this -> db -> select('*, tbl_room_type.type AS room_type');
        $this -> db -> from('tbl_checkin');
        $this-> db -> join('tbl_room_info', 'tbl_checkin.room_id = tbl_room_info.id');
        $this-> db -> join('tbl_room_type', 'tbl_room_info.room_type = tbl_room_type.id');
        $this-> db -> join('tbl_guest_info', 'tbl_checkin.guest_id = tbl_guest_info.id');
         $this-> db -> join('tbl_payment_history', 'tbl_payment_history.guest_id = tbl_checkin.guest_id');
       // $this->db->where("tbl_checkin.status", 0); // compute checked out guests only
        $this -> db -> order_by('tbl_checkin.service_id','ASC');
        $this->db->where("MONTH(tbl_payment_history.date_time)",$month);
        $this -> db -> order_by('tbl_room_info.room_name','ASC');
        $this -> db -> group_by('tbl_payment_history.payment_id');

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

      //francis
    public function _get_yearly_report($year){

        $this -> db -> select('*');
        $this -> db -> from('tbl_checkin');
        $this-> db -> join('tbl_room_info', 'tbl_checkin.room_id = tbl_room_info.id');
        $this-> db -> join('tbl_room_type', 'tbl_room_info.room_type = tbl_room_type.id');
        $this-> db -> join('tbl_guest_info', 'tbl_checkin.guest_id = tbl_guest_info.id');
        $this-> db -> join('tbl_payment_history', 'tbl_payment_history.guest_id = tbl_checkin.guest_id');
        $this -> db -> order_by('tbl_checkin.service_id','ASC');
        $this->db->where("YEAR(tbl_payment_history.date_time)",$year);
        $this -> db -> order_by('tbl_room_info.room_name','ASC');
        $this -> db -> group_by('tbl_payment_history.payment_id');

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

    //francis
    public function total_daily_report($date){

       $newdate = new DateTime($date);
       $curr_date = $newdate->format('Y-m-d');

       $this -> db -> select('SUM(tbl_payment_history.payment_amount) AS sum_total');
       $this -> db -> from('tbl_payment_history');
       $this->db->where("DATE(tbl_payment_history.date_time)",$curr_date);
       $this -> db -> group_by('tbl_payment_history.payment_id');

       $query = $this-> db -> get();
       return ($query -> num_rows() > 0) ? $query -> result() : false;
   }

    public function total_monthly_report($month){

        $this -> db -> select('SUM(tbl_payment_history.payment_amount) AS sum_total');
        $this -> db -> from('tbl_payment_history');
        $this->db->where("MONTH(tbl_payment_history.date_time)",$month);
        $this -> db -> group_by('tbl_payment_history.payment_id');

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

     public function total_yearly_report($year){


       $this -> db -> select('SUM(tbl_payment_history.payment_amount) AS sum_total');
       $this -> db -> from('tbl_payment_history');

        $this->db->where("YEAR(tbl_payment_history.date_time)",$year);

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

     //francis
    public function _get_user_password_by_id($id)
    {
      $this -> db -> select('password');
      $this -> db -> from('tbl_accounts');
      $this-> db ->where('id',$id);
      $query = $this-> db -> get();
      return ($query -> num_rows() > 0) ? $query -> row() : false;
    }

     public function _get_all_products(){
        $this -> db -> select('*');
        $this -> db -> from('tbl_products');
        $this -> db -> order_by('name','ASC');
        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

    public function _get_all_products_low_quantity(){
        $this -> db -> select('*');
        $this -> db -> from('tbl_products');
        $this-> db ->where('quantity <=',5);
        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

    public function _get_available_products(){
        $this -> db -> select('*');
        $this -> db -> from('tbl_products');
        $this-> db ->where('quantity <',0);
        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

    public function _get_all_accounts(){
        $this -> db -> select('tbl_accounts.*,tbl_roles.role_name as role_name');
        $this -> db -> from('tbl_accounts');
        $this-> db -> join('tbl_roles', 'tbl_accounts.role = tbl_roles.id');
        $array = array( 'status' => 1);
        $this->db->where($array);
        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

    public function _get_all_roles(){
        $this -> db -> select('*');
        $this -> db -> from('tbl_roles');
        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

     public function _edit_guest_info($guest_id,$data){
        $array = array('id' => $guest_id);
        $this->db->where($array);
        $this->db->update('tbl_guest_info', $data);
    }

    public function _edit_checkin_details($service_id,$data){
        $array = array('service_id' => $service_id);
        $this->db->where($array);
        $this->db->update('tbl_checkin', $data);
    }

    public function _edit_checkin_details_by_guest_id($guest_id,$data){
        $array = array('guest_id' => $guest_id);
        $this->db->where($array);
        $this->db->update('tbl_checkin', $data);
    }

    public function _remove_checkin_details($service_id){
        $this -> db -> delete('tbl_checkin', array('service_id' => $service_id));
    }

    public function _add_item_temp($data){
        $this -> db -> insert('tbl_temp',$data);
    }

     public function _edit_item_temp($product_id,$cashier_id, $data){
        $array = array('product_id' => $product_id, 'cashier_id' => $cashier_id);
        $this->db->where($array);
        $this->db->update('tbl_temp', $data);
    }

    public function _check_existing_temp($product_id, $cashier_id){
        $this -> db -> select('*');
        $this -> db -> from('tbl_temp');
        $array = array('product_id' => $product_id, 'cashier_id' => $cashier_id);
        $this->db->where($array);

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> row() : false;
    }

    public function sum_temp_data($cashier_id) {
        $this -> db -> select('SUM(tbl_products.amount * tbl_temp.quantity) AS total_amount');
        $this -> db -> from('tbl_temp');
        $this-> db -> join('tbl_products', 'tbl_products.id = tbl_temp.product_id');
        $array = array('cashier_id' => $cashier_id);
        $this->db->where($array);

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> row() : false;
    }

    public function _get_products_bought_temp($cashier_id) {
        $this -> db -> select('*, tbl_temp.quantity');
        $this -> db -> from('tbl_temp');
        $this-> db -> join('tbl_products', 'tbl_products.id = tbl_temp.product_id');
        $array = array('cashier_id' => $cashier_id);
        $this->db->where($array);

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

    public function _insert_transaction_history($data){
        $this -> db -> insert('tbl_transaction_history',$data);
        return $this->db->insert_id();
    }

    public function _get_last_transaction_id() {
        $this -> db -> select('MAX(service_id) AS last_id');
        $this -> db -> from('tbl_transaction');
        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> row() : false;
    }

     public function _insert_transaction($data){
        $this -> db -> insert('tbl_transaction',$data);
        return $this->db->insert_id();
    }

    public function _remove_temp_details($cashier_id){
        $this -> db -> delete('tbl_temp', array('cashier_id' => $cashier_id));
    }

    public function _remove_temp_item($item_id){
        $this -> db -> delete('tbl_temp', array('product_id' => $item_id));
    }

    public function _get_all_transactions() {
        $this -> db -> select('tbl_transaction.trans_id AS transaction_id, tbl_transaction_history.quantity,
                    tbl_transaction_history.date_time, tbl_products.amount, tbl_products.name AS product_name, tbl_accounts.username AS cashier');
        $this -> db -> from('tbl_transaction');
        $this -> db-> join('tbl_transaction_history', 'tbl_transaction_history.transaction_id = tbl_transaction.trans_id');
        $this-> db -> join('tbl_products', 'tbl_products.id = tbl_transaction_history.product_id');
        $this-> db-> join('tbl_accounts', 'tbl_accounts.id = tbl_transaction.cashier_id');

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

     public function _get_transactions() {
        $this -> db -> select('tbl_transaction.trans_id');
        $this -> db -> from('tbl_transaction');

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

     public function _get_recent_transactions() {
        $this -> db -> select('*, tbl_transaction.trans_id');
        $this -> db -> from('tbl_transaction');
        $this-> db-> join('tbl_accounts', 'tbl_accounts.id = tbl_transaction.cashier_id');
        $this-> db -> order_by('tbl_transaction.date_time', 'DESC');
        $this-> db -> limit('10');
        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

     public function _get_rooms_by_group($group_id) {
        $this -> db -> select('*');
        $this -> db -> from('tbl_checkin');
        $this-> db -> join('tbl_room_info', 'tbl_checkin.room_id = tbl_room_info.id');
        $this-> db -> join('tbl_room_type', 'tbl_room_info.room_type = tbl_room_type.id');
        $this-> db -> join('tbl_guest_info', 'tbl_checkin.guest_id = tbl_guest_info.id');
        $this -> db -> where('group_guest_id',$group_id);
        //$this -> db -> where('tbl_checkin.status',0); // where checked out

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

    public function _get_rooms_by_guest_bill($guest_id) {
       $this -> db -> select('*');
       $this -> db -> from('tbl_checkin');
       $this-> db -> join('tbl_room_info', 'tbl_checkin.room_id = tbl_room_info.id');
       $this-> db -> join('tbl_room_type', 'tbl_room_info.room_type = tbl_room_type.id');
       $this-> db -> join('tbl_guest_info', 'tbl_checkin.guest_id = tbl_guest_info.id');
       $this -> db -> where('service_id',$guest_id);
       //$this -> db -> where('tbl_checkin.status',0); // where checked out

       $query = $this-> db -> get();
       return ($query -> num_rows() > 0) ? $query -> result() : false;
   }

     public function _update_service_id_to_group($service_id){
        $data = array(
            'group_guest_id' => $service_id
            );
        $array = array('service_id' => $service_id);
        $this->db->where($array);
        $this->db->update('tbl_checkin', $data);
    }

     public function _checkout_group($group_id){
        $data = array(
            'status' => 0
            );
        $array = array('group_guest_id' => $group_id);
        $this->db->where($array);
        $this->db->update('tbl_checkin', $data);
    }

     public function _search_products($keyword){
         $this->db->like('name', $keyword);
         $this->db->or_like('id', $keyword);
         $query = $this->db->get('tbl_products');
         return $query->result();
    }

    public function _add_payment($data) {
        $this->db->insert('tbl_payment_history', $data);
    }

    public function _update_other_charges($data,$guest_id,$amount) {
        $this->db->where('guest_id',$guest_id);
        $this->db->where('amount',$amount);
        $this->db->update('tbl_other_charges', $data);
    }

    public function _user_confirm_checkout($service_id){
        $data = array('status' => 0);
        $array = array('service_id' => $service_id);
        $this->db->where($array);
        $this->db->update('tbl_checkin', $data);
    }

    // francis
     public function _get_checkin_data_status(){
        $this -> db -> select('*,tbl_payment_history.date_time as payment_date');
        $this -> db -> from('tbl_checkin');
        $this-> db -> join('tbl_room_info', 'tbl_checkin.room_id = tbl_room_info.id');
        $this-> db -> join('tbl_room_type', 'tbl_room_info.room_type = tbl_room_type.id');
        $this-> db -> join('tbl_guest_info', 'tbl_checkin.guest_id = tbl_guest_info.id');
        $this-> db -> join('tbl_payment_history', 'tbl_payment_history.service_id = tbl_checkin.service_id','Left');
       // $this -> db -> where('tbl_checkin.status', 0); // where still checked in
       $this -> db -> group_by('tbl_checkin.guest_id'); // group by user
       $this -> db -> order_by('tbl_payment_history.date_time','DESC');

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

    public function _get_total_amount_due_checkin_dashboard($service_id){

      $sql = "SELECT total_amount_due, payment_amount,checkin_date,date_time FROM `tbl_checkin`
      LEFT JOIN `tbl_payment_history` ON `tbl_checkin`.service_id = `tbl_payment_history`.service_id
      WHERE `tbl_checkin`.checkin_date > DATE_SUB(NOW(), INTERVAL 5 DAY)
      ORDER BY  `tbl_payment_history`.date_time ";

     $query = $this->db->query($sql);

     return $query->row();
   }

    public function _get_checkin_data_by_guest_dashboard(){
        $this -> db -> select('*');
        $this -> db -> from('tbl_checkin');
        $this-> db -> join('tbl_room_info', 'tbl_checkin.room_id = tbl_room_info.id');
        $this-> db -> join('tbl_room_type', 'tbl_room_info.room_type = tbl_room_type.id');
        $this-> db -> join('tbl_guest_info', 'tbl_checkin.guest_id = tbl_guest_info.id');

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

    public function _get_checkin_data_by_guest_dashboard_distinct(){
        $this -> db -> select('*');
        $this -> db -> from('tbl_checkin');
        $this-> db -> join('tbl_room_info', 'tbl_checkin.room_id = tbl_room_info.id');
        $this-> db -> join('tbl_room_type', 'tbl_room_info.room_type = tbl_room_type.id');
        $this-> db -> join('tbl_guest_info', 'tbl_checkin.guest_id = tbl_guest_info.id');
        $this-> db -> join('tbl_payment_history', 'tbl_checkin.guest_id = tbl_payment_history.guest_id');
        $this-> db ->group_by('tbl_checkin.guest_id');

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

    public function _update_checkin_status($data, $service_id){
       $this->db->where('service_id',$service_id);
       $this->db->update('tbl_checkin', $data);
   }

   public function _update_advance_payment($data, $guest_id){
      $this->db->where('guest_id',$guest_id);
      $this->db->update('tbl_checkin', $data);
  }

  public function _update_payment_flag($data, $guest_id){
      $this->db->where('guest_id',$guest_id);
      $this->db->update('tbl_payment_history', $data);
  }

   public function _get_advance_payment_by_guest($guest_id){
        $this -> db -> select('SUM(advance_payment) AS total_advance_payment');
        $this -> db -> from('tbl_checkin');
        $this->db->where('guest_id',$guest_id);
        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> row() : false;
    }

     public function _get_advance_payment_by_guest_room($guest_id, $room_id){
        $this -> db -> select('SUM(advance_payment) AS total_advance_payment');
        $this -> db -> from('tbl_checkin');
        $this->db->where('guest_id',$guest_id);
        $this->db->where('room_id',$room_id);
        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> row() : false;
    }

    public function _get_advance_payment_room_id($guest_id){
        $this -> db -> select('room_id');
        $this -> db -> from('tbl_checkin');
        $this->db->where('guest_id',$guest_id);
        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> row() : false;
    }

     public function _add_charges($service_id, $data) {
        $this->db->insert('tbl_other_charges', $data);
    }

    public function _get_charges($service_id){
        $this -> db -> select('description, amount');
        $this -> db -> from('tbl_other_charges');
        $this->db->where('service_id',$service_id);
        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> result() : false;
    }

    public function _get_sum_charges($service_id){
        $this -> db -> select('SUM(amount) as sum_charges');
        $this -> db -> from('tbl_other_charges');
        $this->db->where('service_id',$service_id);
        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> row() : false;
    }

    public function _get_sum_charges_by_guest($guest_id){
        $this -> db -> select('SUM(amount) as sum_charges');
        $this -> db -> from('tbl_other_charges');
        $this->db->where('guest_id',$guest_id);
        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> row() : false;
    }

    public function _get_advance_checker($guest_id){
        $this -> db -> select('has_advance_or_full');
        $this -> db -> from('tbl_payment_history');
        $this->db->where('guest_id',$guest_id);
        $this->db->where('has_advance_or_full',1);
        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> row() : false;
    }

    public function _get_advance_checkin($service_id){
        $this -> db -> select('advance_payment');
        $this -> db -> from('tbl_checkin');
        $this->db->where('service_id',$service_id);
        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> row() : false;
    }

    public function _get_charges_by_guest($guest_id){
        $this -> db -> select('SUM(amount) AS total_charges');
        $this -> db -> from('tbl_other_charges');
        $this->db->where('guest_id',$guest_id);
        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> row() : false;
    }

    //FRANCIS
     public function _edit_reservation($data, $id) {
         $this->db->where('service_id',$id);
         $this->db->update('tbl_checkin', $data);
     }

       public function _delete_other_charges($id) {
         $this->db->where('service_id',$id);
         $this->db->delete('tbl_other_charges');
     }


      //FRANCIS
     public function _banned_guest_details($data, $id) {
         $this->db->where('id',$id);
         $this->db->update('tbl_guest_info', $data);
     }
     //francis
    public function _cancel_reservation($id) {
        $this->db->where('service_id',$id);
        $this->db->delete('tbl_checkin');
    }
    //Francis Dy
    public function _get_banned_customer(){
      $sql = "SELECT *
      FROM  `tbl_guest_info`
      WHERE `tbl_guest_info`.is_banned = 1
      ";

      $query = $this->db->query($sql);
      return $query->result();
    }

    public function _get_recent_payment($service_id){
        $this -> db -> select('payment_id, payment_amount');
        $this -> db -> from('tbl_payment_history');
        $this->db->where('service_id',$service_id);
        $this -> db -> order_by('date_time','DESC');

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> row() : false;
    }

    public function _update_recent_payment($data, $payment_id){
        $array = array('payment_id' => $payment_id);
        $this->db->where($array);
        $this->db->update('tbl_payment_history', $data);
    }

    public function _get_unpaid_old_account($guest_id){
         $this -> db -> select('SUM(amount) AS unpaid_balance');
        $this -> db -> from('tbl_other_charges');
        $this->db->where('guest_id', $guest_id);
        $this->db->where('service_id', 0);

        $query = $this-> db -> get();
        return ($query -> num_rows() > 0) ? $query -> row() : false;
    }
}
