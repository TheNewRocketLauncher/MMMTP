<?php

?>
<script>
    
    
    function checkFluency()
	{
		alert("Js imported!");
	}
    function changecheck(check_id)
    {
        
        
        var check_idplus = check_id + 1;
        var id = 'bdt'+check_id;
        var id2 = 'bdt'+check_idplus;
        alert(id2);
        if (document.getElementById(id2).checked == false)
        {
            document.getElementById(id2).checked = true;
        }
        else
        {
            document.getElementById(id2).checked = false;
        }


        // var check_idplus = check_id;
        // var id2 = 'bdt'+check_idplus;
        // if(document.getElementById(id2).checked == true){
        //     arr.push(check_id);
        //     // document.getElementById(id2).checked = false

        // }
        // // neu un check thi pop
        // else if(document.getElementById(id2).checked == false){
            
        //     var idx = arr.findIndex(e=> {return e == check_id})
            
        //     if(idx >=0){
        //         arr.splice(idx, 1)
        //     }
        // }
        // alert('xinchao');
        
    }
    function actiondel()
	{
        
		alert("Actiondel!");     
	}
    function actiondelphp(xt)
	{
        
        var phpadd = <?php session_start();
        require_once('../../model/bacdt_model.php');
        $_SESSION['mmmy'] = 422;
        if(xt==5)
        {
            $param1 = new stdClass();
        // $param1->id = 1;
        $param1->ma_bac = 'DH2';
        $param1->ten = 'Đại học 222';
        $param1->mota = 'Bậc Đại học 234 HCMUS';
        // $param1 = new stdClass();
        // $param2 = new stdClass();
        // $param3 = new stdClass();
        // // $param
        // $param1->id = 1;
        // $param1->ma_bac = 'DH';
        // $param1->ten = 'Đại học';
        // $param1->mota = 'Bậc Đại học HCMUS';
        // // $param
        // $param2->id = 2;
        // $param2->ma_bac = 'CD';
        // $param2->ten = 'Cao đẳng';
        // $param2->mota = 'Bậc Cao đẳng HCMUS';
        // // $param
        // $param3->id = 3;
        // $param3->ma_bac = 'DTTX';
        // $param3->ten = 'Đào tạo từ xa';
        // $param3->mota = 'Bậc Đào tạo từ xa HCMUS';
        if(1){
            insert_bacdt($param1);

        }
        }
        
        // insert_bacdt($param2);
        // insert_bacdt($param3);?>
        
		alert("Js 12347!");     
	}
</script>

