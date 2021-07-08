<?php
defined('BASEPATH') OR exit('No direct script access allowed');

error_reporting(0);
class Graph extends CI_Controller {
 public function __construct()
 {
  parent::__construct();
  $this->load->model('admin/Graph_model');
  $this->load->model('admin/Orders_model');
 
 }

 function index()
 {
  $data['year_list'] = $this->Graph_model->fetch_year();
  $this->load->view('admin/graph', $data);
 }

  public function invoice($value='')
 {
  $id=1059;
  $response=[];
  $pdfFilePath = "output_pdf_name.pdf";
  $this->load->library('m_pdf');
  $order=$this->Orders_model->getOrdersByID($id);

    if($id>0){
      $response['products']=$this->Common_model->getOrderProducts ($id);
      $response['total_amount']=$order['total_amount']; 
      $response['transaction_id']=$order['transaction_id'];
      //  $response['address']=$this->Common_model->getOrderAddress ($id);
    }
  // /prd($response);
  $html=$this->load->view('admin/invoice',$response,true); 
  $this->m_pdf->pdf->WriteHTML($html);
  $this->m_pdf->pdf->Output(); // opens in browser
 }

 function fetch_data()
 {
  if($this->input->post('year'))
  {
   $chart_data = $this->Graph_model->fetch_chart_data($this->input->post('year'));  
   foreach($chart_data->result_array() as $row)
   {
    $output[] = array(
     'first_name'  => $row["first_name"],
     
  );
   }
   echo json_encode($output);
  }
 }
 
}

?>
