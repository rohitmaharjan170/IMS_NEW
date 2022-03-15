$(document).ready(function(){
    $(document).on('change','.product_name',function () {
        var id=$(this).val();

        var a=$(this).parent();
        console.log(id);
        var op="";
        $.ajax({
            type:'get',
            url:'{!!URL::to('findRate')!!}',
            data:{'id':id},
            dataType:'json',//return data will be json
            success:function(data){
                console.log("RATE");
                console.log(data.rate);

                // here price is coloumn name in products table data.coln name

                a.find('.rate').val(data.rate);

            },
            error:function(){

            }
        });

});