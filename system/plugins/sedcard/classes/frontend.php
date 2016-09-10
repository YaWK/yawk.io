<?php
namespace YAWK\PLUGINS\SEDCARD {

    class helper
    {
        protected $rndItem = array();

        public function randomize($i, $start, $end){
            while ($i > 0) {
                $this->rndItem[] = rand($start,$end);
                --$i;
            }

            // only unique items in array
            $this->rndItem = array_unique($this->rndItem);
            if (count($this->rndItem > $i)){
              //  $this->randomize($i, $start, $end);
            }
            else {
                return $rndItem;
            }
            return null;
        }
    }
}