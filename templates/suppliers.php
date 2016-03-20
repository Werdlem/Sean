<?php 
require_once './DAL/PDOConnection.php';
$suppliers = new products; 
?>

<div class="panel panel-primary">
  <div class="panel-heading" style="text-align:center;">
    <h3>Supplier Performance Monitor</h3>
  </div>
  <div class="panel-body">
    <form method="post" action="" id="Search">
      <select name="taskOption">
        <option value="dnu">Select supplier</option>
        <option>Manchester Paper box</option>
        <option>John Roberts</option>
        <option>Krystals</option>
        <option>Weedon</option>
        <option>Antalis</option>
        <option>DS Smith</option>
        <option>Curran</option>
        <option>DS Smith</option>
        <option>Drayton</option>
        <option>Sansetsu</option>
      </select>
      <input class="suppliers" name="date-from" placeholder=" date from" type="text" onfocus="(this.type='date')" />
      <input class="suppliers" name="date-to" placeholder=" date to" type="text" onfocus="(this.type='date')" />
      <button type="submit" class="btn btn-large btn-success" name="submit">Search</button>
      <input type="hidden" name="doSearch" value="1"  />
    </form>
<!-- <<<<<<< HEAD  ====== origin/master >>>>>>>>>-->
    <?php
  if(isset($_POST['doSearch'])){
	  
	  if ($_POST['taskOption'] == "dnu") {die ("please select a supplier");} else{
  
 
 $dateFrom = $_POST['date-from'];
 $dateTo = $_POST['date-to'];
 
 $supplier_name = $_POST['taskOption'];
 ?>
    <br />
    <p><?php echo $supplier_name .  ' supply performance between ' . $dateFrom . ' & '. $dateTo;?> <br />
    <table width="100%" class="listing_table" >
      <thead>
        <tr class="heading" style="text-align:center">
          <th>Due Date</th>
          <th>Schedule Date & Time</th>
          <th>Delivery Date & Time</th>
          <th>On Time/Late/Early</th>
          <th>Margin </th>
        </tr>
      </thead>
      <tbody>
        <?php
	 
		 $fetch = $suppliers->select($supplier_name, $dateFrom, $dateTo);
		 	$count = 0;
			$onTime = 0;
			$early = 0;
			$late = 0;
    foreach ($fetch as $result)
	{
	$count++ ?>
        <?php 
     echo"<tr class='table' style=' border-bottom: thin dashed #CCC'>";
      $sched = $result['schedule_date'];
	  		$del = $result['delivery_date'];
			$due = $result['next_due'];
			$control = "0 days, 01h 30m 00s";
			$date1 = date_create($sched);
			$date2 = date_create($del);
			$date3 = date_create($due);
			$strip = $date2->format('Y-m-d');
			?>
      <td><?php echo date('d-m-Y', strtotime($result['next_due'])); ?></td>
        <td><?php echo date('d-m-Y H:i:s', strtotime($result['schedule_date'])); ?></td>
        <td><?php echo date('d-m-Y H:i:s', strtotime($result['delivery_date'])); ?></td>
        <td><?php if ($due == $strip){
		  $onTime++;
				  echo '<span class="label label-success">On Time</span>';
	  }
		else if ($due > $strip){
			$early++;
			echo '<span class="label label-warning">Early</span>';} 
		else{ 
		$late++;
		echo '<span class="label label-danger">Late</span>';} ?></td>
        <td><?php  $diff = date_diff($date1, $date2); 
		$results = $diff->format("%d days, %Hh %Im %Ss");
		if ($results > $control){
			
			 echo '<span class="label label-danger">'. $results . '</span>';} else echo '<span class="label label-success">'.$results.'</span>';?></td>
      </tr>
      <?php }
	  echo $count . " Records found! <br /><br />";
	  echo '<p>'. $onTime . " <span class='label label-success'> On Time</span> Deliveries (" . number_format((100.0*$onTime)/$count ) . "%)";
	  echo '<p>'. $early . " <span class='label label-warning'> Early</span> Deliveries (" . number_format((100.0*$early)/$count ) . "%)";
	  echo '<p>'. $late . " <span class='label label-danger'> Late</span> Deliveries (" . number_format((100.0*$late)/$count ) . "%)";
	 
}?>
      <div class="alert alert-info" role="alert" style="width:75%; float: right; margin-top: -102px; font-size:13px; padding:10px"><strong>On Time/Late/Early</strong> deliveries is the difference between the initial agreed <strong>Due Date</strong> & actual <strong>Delivery Date</strong>. The <strong>Margin</strong> is the difference of delivery time between the <strong>Scheduled Date & Time</strong> and actual <strong> Delivery Date & Time</strong>. This result is then compared to a 90minute delivery grace period, going green if within the 90minutes or red if later.</div>
      <?php }?>
        </tbody>
      
    </table>
  </div>
</div>
