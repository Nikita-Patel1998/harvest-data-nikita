<?php
class Harvest_data()
{

   public $crop_codes = array();
   public function __construct()
   {
   	
   }

   public function get_crop_codes()
   {

      $this->crop_codes = array(
         'W'  => 'Wheat',
         'B'  => 'Barley',
         'M'  => 'Maize',
         'BE' => 'Beetroot',
         'C'  => 'Carrot',
         'PO' => 'Potatoes',
         'PA' => 'Parsnips',
         'O'  => 'Oats',
      );
   }

   public function clean_csv( $path )
   {

   }

   public function validation( $path )
   {

   }

   public function overide( $path )
   {

   }

}
