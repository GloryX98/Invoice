<?php include"../Include/header.php";?>
<?php include"../Include/sidebar.php";?>
<?php
include("../inc/connect.php") ;

//session_start();
if(isset($_POST['Save']))
{ 
    
    /*Invoice*/
    $invoice_id="INV-". rand(100,900);
    $patient_id=$_POST['patient_id'];
    $doctor_id=$_POST['doctor_id'];
    $tax_id=$_POST['tax_id'];
    $invoice_date= date("Y-m-d");
    $due_date=$_POST['due_date'];
    $discount=$_POST['discount'];
    $grand_total=$_POST['grand_total'];
    $paid_amount=$_POST['paid_amount'];
    $due=$_POST['due'];
    
 

    $write =mysqli_query($con,"INSERT INTO invoice(Invoice_id,Patient_id,Tax_id,InvoiceDate,DueDate,Doctor_id,Discount,GrandTotal,PaidAmount,Due) VALUES ('$invoice_id','$patient_id','$tax_id','$invoice_date','$due_date','$doctor_id','$discount','$grand_total','$paid_amount','$due')") or die(mysqli_error($con));

    /*End Invoice*/


    /*Invoice Items*/
    $invoice_i_id=$invoice_id;
    $s_id=$_POST['s_id'];
    $m_id=$_POST['m_id'];
    $quantity=$_POST['quantity'];
    $amount=$_POST['amount'];
 

    $write =mysqli_query($con,"INSERT INTO invoice_items(Invoice_id,S_id,M_id,Quantity,Amount) VALUES ('$invoice_i_id','$s_id','$m_id','$quantity','$amount')") or die(mysqli_error($con));

    /*End Invoice Items*/

    }

?>



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Add New Invoice
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../Index/index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add New Invoice</li>
      </ol>
    </section>

            <div class="page-wrapper">
            <div class="content">
                
    <!-- Main content -->
    <section class="content">
        

        <div class="row">
            <div class="row">
            <div class="col-sm-12">

                        <div class="panel panel-bd">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4>New Invoice</h4>
                        </div>
                    </div>

                    <form  class="form-vertical"  method="post" accept-charset="utf-8">
                                                                                                                 

                    <div class="panel-body">

                        <div class="row">
                      <div class="col-md-6">
                  <div class="form-group">
                    <label>Patient Name</label>

                    <select class="form-control" name="patient_id" required="">
                      <option>Select
                        <?php
                        $counter=1;
                        $GD="SELECT* from patient ;";
                        $show = mysqli_query($con,$GD);
                        while($row_patient = mysqli_fetch_assoc($show)) { 
                            ?></option>
                      <option value="<?php echo $row_patient['Patient_id'];?>" ><?php echo ($row_patient['FirstName'] ." ". $row_patient['LastName'] );?></option>
                      <?php $counter++; } ?>
                    </select>

                    
                  </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Doctor</label>
                                        <select class="form-control" name="doctor_id" required="">
                      <option>Select
                        <?php
                        $counter=1;
                        $GD="SELECT* from doctor ;";
                        $show = mysqli_query($con,$GD);
                        while($row_doctor = mysqli_fetch_assoc($show)) { 
                            ?></option>
                      <option value="<?php echo $row_doctor['Doctor_id'];?>"  ><?php echo ($row_doctor['FirstName'] ." ". $row_doctor['LastName'] );?></option>
                      <?php $counter++; } ?>
                    </select>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tax</label>
                                        <select class="form-control" name="tax_id" required="">
                      <option>Select
                        <?php
                        $counter=1;
                        $GD="SELECT* from tax ;";
                        $show = mysqli_query($con,$GD);
                        while($row_tax = mysqli_fetch_assoc($show)) { 
                            ?></option>
                      <option value="<?php echo $row_tax['Tax_id'];?>"><?php echo ($row_tax['Tax_Name']);?></option>
                      <?php $counter++; } ?>
                    </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Due Date</label>
                                        <div class="time-icon">
                                            <input type="date" name="due_date" class="form-control" id="datetimepicker3" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>



                        <div class="table-responsive" style="margin-top: 10px">
                            <table class="table table-bordered table-hover" id="normalinvoice">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-center">Items<i class="text-danger">*</i></th>
                                        
                                        <th class="text-center">Quantity <i class="text-danger">*</i></th>
                                        <th class="text-center">Price <i class="text-danger">*</i></th>
                                        <th class="text-center">Total <i class="text-danger">*</i></th>

                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="addinvoiceItem">

                                    <tr>
                                        <td></td>
                                        <td>
                                            <input name="s_id" onkeypress="invoice_itemslist(1);" class="form-control productSelection" placeholder="Items" required="" id="s_id" type="text">
                                            <input class="autocomplete_hidden_value s_id_1" name="s_id[]" id="SchoolHiddenId" type="hidden">
                                            <input class="baseUrl" value="" type="hidden">
                                        </td>

                                       

                                        <td>
                                            <input name="product_quantity[]" onkeyup="quantity_calculate(1);" id="total_qntt_1" class="form-control text-right" value="1" min="1" type="number">
                                        </td>

                                        <td>
                                            <input name="product_rate[]" readonly="" value="0.00" id="price_item_1" class="price_item1 form-control text-right" type="text">
                                        </td>

                                        
                                        <td>
                                            <input class="total_price form-control text-right" name="total_price[]" id="total_price_1" value="0.00" tabindex="-1" readonly="readonly" type="text">
                                        </td>

                                        

                                         <td>
                                            <!-- Tax calculate start-->
                                            <input id="total_tax_1" class="total_tax_1" type="hidden">
                                            <input id="all_tax_1" class=" total_tax" value="0" type="hidden">
                                            <!-- Tax calculate end -->
                                            <button style="text-align: right;" class="btn btn-danger" type="button" value="Delete" onclick="deleteRow(this)">Delete</button>
                                        </td>


                                    </tr>


                                <tfoot>


                                    <tr>
                                        <td style="text-align:right;" colspan="4"><b>Total Tax:</b></td>
                                        <td class="text-right">
                                            <input id="total_tax_ammount" tabindex="-1" class="form-control text-right" name="total_tax" value="0.00" readonly="readonly" type="text">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="text-align:right;" colspan="4"><b>Discount (%):</b></td>
                                        <td class="text-right">
                                            <input id="total_tax_ammount" tabindex="-1" class="form-control text-right" name="total_tax" value="0.00" readonly="readonly" type="text">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="4" style="text-align:right;"><b>Grand Total:</b></td>
                                        <td class="text-right">
                                            <input id="grandTotal" tabindex="-1" class="form-control text-right" name="grand_total_price" value="0.00" readonly="readonly" type="text">
                                        </td>
                                    </tr>

                                    <tr>
                                        
                                        <td style="text-align:right;" colspan="4"><b>Paid Ammount:</b></td>
                                        <td class="text-right">
                                            <input id="paidAmount" onkeyup="invoice_paidamount();" tabindex="-1" class="form-control text-right" name="paid_amount" value="0.00" type="text">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center">
                                            <input id="add-invoice-item" class="btn btn-info" name="add-invoice-item" onclick="addInputField('addinvoiceItem');" value="Add New Service" type="button">
                                            <input name="baseUrl" class="baseUrl" value="http://dims.16mb.com/clinic/" type="hidden">
                                        </td>
                                        <td style="text-align:right;" colspan="3"><b>Due:</b></td>
                                        <td class="text-right">
                                            <input id="dueAmmount" class="form-control text-right" name="due_amount" value="0.00" readonly="readonly" type="text">
                                        </td>
                                    </tr>

                                </tfoot>
                            </table>
                        </div>

                        

                        <div class="form-group row">
                            <div class="col-sm-offset-4 col-sm-4">
                                <input id="add-invoice" class="btn btn-success" name="add-invoice" value="Save And Paid" type="submit">
                            </div>
                        </div>


                    </div>
                   </form>                    </div>
            </div>
        </div>

        </div>  

    </section>
</div>

        </div>


<!-- <script type="text/javascript">

    $(document).ready(function() {  
        
        $('.add-invoice').prop('disabled', true);

        $('body').on('keyup change', '#phone', function() {
            var phone = $(this).val();
            if(phone.length > 0)
            $.ajax({

                'url': 'http://dims.16mb.com/clinic/' + 'admin/Ajax_controller/load_patient_info/'+phone,
                'type': 'GET',
                'dataType': 'JSON',
                'success': function(data){ 

                    if (data.patient_id) {

                        $('#patient_name').val(data.family_name);
                        $('#patient_id').val(data.patient_id);
                        $('#csc').removeClass('text-danger');
                        $(".invlid_patient_id").text(' Patient Pnone Number is Valid').addClass("text-success");
                       
                    } else {
                        $('#csc').removeClass('text-success');
                        $(".invlid_patient_id").text('Invalid Patient Phone Number').addClass("text-danger");
                    }
                }, error   : function() {
                    alert('failed!');
                } 
               
            });
        });

    });

</script> -->


<!--Invoice js-->
<script type="text/javascript">
    var itemslist = [{"label":"Basic One","value":"1"},{"label":"Basic Two","value":"2"},{"label":"Basic Three","value":"3"},{"label":"Disease Management","value":"4"},{"label":"Women Health 1","value":"5"},{"label":"Women Health 2","value":"6"},{"label":"Women Health 3","value":"7"},{"label":"Women Health 4","value":"8"},{"label":"Nutrition","value":"9"},{"label":"Analyses","value":"10"},{"label":"Blood Sample","value":"11"},{"label":"Cancer Treatments","value":"12"},{"label":"Surgeries","value":"13"}] ; 


APchange = function(event, ui){
    $(this).data("autocomplete").menu.activeMenu.children(":first-child").trigger("click");
}
    function invoice_itemslist(cName) {

        var qnttClass = 'ctnqntt'+cName;
        var priceClass = 'price_item'+cName;
        var total_tax_price = 'total_tax_'+cName;
        var available_quantity = 'available_quantity_'+cName;

        $( ".productSelection" ).autocomplete(
        {

            source: itemslist,
            delay:300,
            focus: function(event, ui) {
                $(this).parent().find(".autocomplete_hidden_value").val(ui.item.value);
                $(this).val(ui.item.label);
                return false;
            },
            select: function(event, ui) {
                $(this).parent().find(".autocomplete_hidden_value").val(ui.item.value);
                $(this).val(ui.item.label);
                
                var id=ui.item.value;
                var base_url = $('.baseUrl').val();
                var csrf_test_name = $("[name=csrf_test_name]").val();
                
                $.ajax
                   ({
                        type: "POST",
                        url: base_url+"admin/Service/retrieve_service",
                        data: {product_id:id,csrf_test_name:csrf_test_name},
                        cache: false,
                        success: function(data)
                        {
                            var obj = jQuery.parseJSON(data);
                            $('.'+priceClass).val(obj.service_price);
                            $('.'+total_tax_price).val(obj.tax);
                            $('.'+available_quantity).val(obj.total_product);
                            //This Function Stay on others.js page
                            quantity_calculate(cName);
                        } 
                    });
                
                $(this).unbind("change");
                return false;
            }
        });
        $( ".productSelection" ).focus(function(){
            $(this).change(APchange);
        
        });
    }

</script>


<script type="text/javascript">
    
function addInputField(t) {
    if (count == limits) alert("You have reached the limit of adding " + count + " inputs");
    else {
        var a = "product_name" + count,
            e = document.createElement("tr");
        e.innerHTML = "<td><input type='text' name='product_name' onkeypress='invoice_itemslist(" + count + ");' class='form-control productSelection' placeholder='Service name' id='" + a + "' required><input type='hidden' class='autocomplete_hidden_value  product_id_" + count + "' name='product_id[]' id ='SchoolHiddenId'/></td> <td class='text-right'><input type='number' name='product_quantity[]' id='total_qntt_" + count + "' onkeyup='quantity_calculate(" + count + "); stockLimit(" + count + ");' class='total_qntt" + count + " form-control text-right' value='1'/></td><td><input type='number' name='product_rate[]' readonly value='0.00' id='price_item_" + count + "' class='price_item" + count + " form-control text-right' required/></td><td><input type='number' name='discount[]' onkeyup='quantity_calculate(" + count + "); stockLimit(" + count + ");' id='discount_" + count + "' class='form-control text-right' placeholder='Discount' /></td><td class='text-right'><input class='total_price form-control text-right' type='text' name='total_price[]' id='total_price_" + count + "' value='0.00' readonly='readonly'/></td><td><input type='hidden' id='total_tax_" + count + "' class='total_tax_" + count + "' /><input type='hidden' id='all_tax_" + count + "' class='total_tax'/><button style='text-align: right;' class='btn btn-danger' type='button' value='Delete' onclick='deleteRow(this)'>Delete</button></td>", document.getElementById(t).appendChild(e), document.getElementById(a).focus(), count++
    }
}

function quantity_calculate(t) {
    var a = $("#total_qntt_" + t).val(),
        e = $("#price_item_" + t).val(),
        o = $("#discount_" + t).val(),
        l = $("#total_tax_" + t).val();
    if (a > 0) {
        var n = a * e;
        $("#total_price_" + t).val(n);
        var c = a * l;
        $("#all_tax_" + t).val(c)
    } else {
        var n = a * e;
        $("#total_price_" + t).val(n), $("#all_tax_" + t).val(l)
    }
    if (o > 0) {
        var n = a * e - o;
        $("#total_price_" + t).val(n), $("#total_tax_" + t).val(l)
    } else if (0 > o) {
        var n = a * e;
        $("#total_price_" + t).val(n), $("#total_tax_" + t).val(l)
    }
    calculateSum(), invoice_paidamount()
}

function calculateSum() {
    var t = 0,
        a = 0,
        e = 0,
        o = 0;
    $(".total_tax").each(function() {
        isNaN(this.value) || 0 == this.value.length || (a += parseFloat(this.value))
    }), $("#total_tax_ammount").val(a.toFixed(0)), $(".total_price").each(function() {
        isNaN(this.value) || 0 == this.value.length || (t += parseFloat(this.value))
    }), o = a.toFixed(0), e = t.toFixed(0), $("#grandTotal").val(+o + +e)
}

function invoice_paidamount() {
    var t = $("#grandTotal").val(),
        a = $("#paidAmount").val(),
        e = t - a;
    $("#dueAmmount").val(e)
}

function stockLimit(t) {
    var a = $("#total_qntt_" + t).val(),
        e = $(".product_id_" + t).val(),
        o = $(".baseUrl").val();
    $.ajax({
        type: "POST",
        url: o + "Cinvoice/product_stock_check",
        data: {
            product_id: e
        },
        cache: !1,
        success: function(e) {
            if (a > Number(e)) {
                var o = "You can purchase maximum " + e + " Items";
                alert(o), $("#qty_item_" + t).val("0"), $("#total_qntt_" + t).val("0"), $("#total_price_" + t).val("0")
            }
        }
    })
}

function stockLimitAjax(t) {
    var a = $("#total_qntt_" + t).val(),
        e = $(".product_id_" + t).val(),
        o = $(".baseUrl").val();
    $.ajax({
        type: "POST",
        url: o + "Cinvoice/product_stock_check",
        data: {
            product_id: e
        },
        cache: !1,
        success: function(e) {
            if (a > Number(e)) {
                var o = "You can purchase maximum " + e + " Items";
                alert(o), $("#qty_item_" + t).val("0"), $("#total_qntt_" + t).val("0"), $("#total_price_" + t).val("0.00"), calculateSum()
            }
        }
    })
}

function deleteRow(t) {
    var a = $("#normalinvoice > tbody > tr").length;
    if (1 == a) alert("There only one row you can't delete.");
    else {
        var e = t.parentNode.parentNode;
        e.parentNode.removeChild(e), calculateSum()
    }
}

var count = 2,
    limits = 500;
</script>
<!--End Invoice js-->
<?php include "../Include/footer.php";?>

 
