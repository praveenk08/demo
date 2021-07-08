
<?php

class Graph_model extends CI_Model
{
 function fetch_year()
 {
  $this->db->select('year');
  $this->db->from('users');
  $this->db->group_by('year');
  $this->db->order_by('year', 'DESC');
  return $this->db->get();
}

 function fetch_chart_data($year)
 {
  $this->db->where('year', $year);
  $this->db->order_by('year', 'ASC');
  return $this->db->get('users');
 }



}

?>
