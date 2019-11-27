<?php
 header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"rc.xls\"");
header("Cache-Control: max-age=0");
?>   
	
List Research Corner	
	 <table id="table" border="1">
					      <thead class="text-white" style="background-color: #1089ff;">
					          <tr>
					              <th width="7%">No</th>
					              <th>Title (EN)</th>
					              <th>Type</th>
					              <th>Country</th>
					              <th>Publish Date</th>
					          </tr>
					      </thead>
						  <tbody>
						  <?php $no=1; foreach($research as $vo){ ?>
						  <tr>
							<td><?php echo $no; ?></td>
							<td><?php echo $vo->title_en; ?></td>
							<td><?php 
							$data =  DB::select("select * from csc_research_type where id='".$vo->id_csc_research_type."'");
							foreach($data as $d1){ echo $d1->nama_en; } 
							?></td>
							<td><?php 
							echo $no; 
							?></td>
							<td><?php echo $vo->publish_date; ?></td>
						  </tr>
						  <?php $no++; } ?>
						  </tbody>
					    </table>