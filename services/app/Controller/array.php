$questions = $this->Question->find('all');
         $id=array();
        foreach ($questions as $question) {
            if($question['Question']['CATEGORY']=="aptitude"){
            array_push($id,$question['Question']['ID']);
        }
    }
        print_r($id);
        if (array_key_exists(20, $id)){
            print_r("present");
        }
        else{
            print_r("no");
        }
        shuffle($id);
        print_r($id);
        $min=min($id);
        $max=max($id);
        print_r(rand($min,$max));