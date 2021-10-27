<?php
class Harvest_data
{

   public $crop_codes = array();

   public function process_data($data, $overide_data = array())
   {

      $har_data = array();
      $har_data = array(
         $data[0] => array_chunk(array_slice($data, 1), 2),
      );
      return $har_data;
   }
   public function get_crop_codes($key)
   {
      $key        = trim($key);
      $crop_codes = array(
         'W'  => 'Wheat',
         'B'  => 'Barley',
         'M'  => 'Maize',
         'BE' => 'Beetroot',
         'C'  => 'Carrot',
         'PO' => 'Potatoes',
         'PA' => 'Parsnips',
         'O'  => 'Oats',
      );

      if (isset($crop_codes[$key])) {
         return $crop_codes[$key];
      }

   }

   public function get_crop_weight_percentage($data)
   {
      $sum   = 0;
      $count = count($data);

      foreach ($data as $val) {
         if (isset($val[1])) {
            if (!is_numeric($val[1])) {
               $this->error_log("Enter Proper Value \n");
            }
            $sum += (int) $val[1];
         }
      }

      return floor($sum / $count);
   }

   public function error_log($message, $line = '')
   {

      // path of the log file where errors need to be logged
      $log_file = "./errors-log.log";

      // logging error message to given log file
      error_log($message, 3, $log_file);
   }
   public function clean_csv($path, $overide = '')
   {
      $old_data     = array();
      $overide_data = array();
      $handle       = @fopen($path, "r");
      //print_r(fgetcsv($handle));
      $i     = 0;
      $table = '';
      while (($row = fgetcsv($handle, 4096)) !== false) {
         $old_data[] = $row;
         $har_data   = $this->process_data($row);
         foreach ($har_data as $key => $h_data) {
            $table .= '<table border="1" style="margin-top:30px">';
            $table .= '<tr>
                  <th>Country Name</th>
                  <td>' . $key . '</td>
                  </tr>
                  <tr>
                     <th>Crop Name</th>
                     <th>Weight</th>
                  </tr>
                  ';

            foreach ($h_data as $k => $data) {

               if (!isset($data[0]) || empty($data[0])) {
                  $this->error_log('No Crop Name Found at line number - ' . $i . "\n");
               } else {
                  $table .= '<tr>

                     <td>' . $this->get_crop_codes($data[0]) . '</td>
                 ';
               }
               if (!isset($data[1]) || empty($data[1])) {
                  $this->error_log('No Crop Weight Found at line number - ' . $i . "\n");
               } else {
                  $table .= '

                     <td>' . $data[1] . '</td>
                  </tr>';
               }

            }
            $table .= '<tfoot>
               <tr>
                  <th>Crop percentage</th>
                  <td>' . $this->get_crop_weight_percentage($h_data) . '</td>
               </tr>
            </tfoot>';
            $table .= '</table>';

            // echo "Crop percentage:" . $this->get_crop_weight_percentage($h_data);
            // echo "<br/>";
            // echo "<br/>";
            // echo "<br/>";
            $i++;
         }

      }

      echo $table;
      fclose($handle);

   }
   public function update_csv($path, $overide)
   {

      $old_data     = array();
      $overide_data = array();
      $handle       = @fopen($path, "r");
      $i            = 0;
      while (($row = fgetcsv($handle, 4096)) !== false) {
         $old_data[] = $row;
      }
      fclose($handle);
      $handle = @fopen($overide, "r");
      $i      = 0;
      while (($row = fgetcsv($handle, 4096)) !== false) {
         $overide_data[] = $row;
      }
      fclose($handle);

      foreach ($old_data as $val) {
         $old_filter[] = $this->process_overide_data($val);
      }
      foreach ($overide_data as $val) {
         $overide_data_filter[] = $this->process_overide_data($val);
      }

      $overided_data = array_merge_recursive($old_filter, $overide_data_filter);

      $table = '';
      foreach ($overided_data as $key => $h_data) {

         foreach ($h_data as $k => $d) {
            $table .= '<table border="1" style="margin-top:30px">';
            $table .= '<tr>
                  <th>Country Name</th>
                  <td>' . $k . '</td>
                  </tr>
                  <tr>
                     <th>Crop Name</th>
                     <th>Weight</th>
                  </tr>
                  ';

            foreach ($d as $k1 => $data) {

               if (!isset($data[0]) || empty($data[0])) {
                  $this->error_log('No Crop Name Found at line number - ' . $i . "\n");
               } else {
                  $table .= '<tr>

                     <td>' . $this->get_crop_codes($data[0]) . '</td>
                 ';
                  // echo "<br/>";
                  // echo "Crop Name:" . $this->get_crop_codes($data[0]);
                  // echo "<br/>";
               }
               if (!isset($data[1]) || empty($data[1])) {
                  $this->error_log('No Crop Weight Found at line number - ' . $i . "\n");
               } else {
                  $table .= '

                     <td>' . $data[1] . '</td>
                  </tr>';
                  // echo "Crop Weight:" . $data[1];
                  // echo "<br/>";
               }
            }

            $table .= '<tfoot>
               <tr>
                  <th>Crop percentage</th>
                  <td>' . $this->get_crop_weight_percentage($h_data) . '</td>
               </tr>
            </tfoot>';
            $table .= '</table>';

         }
         $i++;
      }

      echo $table;
   }
   public function process_overide_data($data)
   {
      //print_r($data);
      $har_data = array();
      $har_data = array(
         $data[0] => array_chunk(array_slice($data, 1), 2),
      );
      return $har_data;
   }

}
