<?php

$invoices = count(\App\Invoice::findAllInvoices($profile->id));
$invoicesP = count(\App\InvoiceP::findAllInvoices($profile->id));
$customers = count(\App\Customer::findAllCustomers($profile->id));
$suppliers = count(\App\Supplier::findAllSuppliers($profile->id));
$services = count(\App\Service::findAllServicesForAllUserServices($profile->id));
$servicesP = count(\App\ServiceP::findAllServicesForAllUserServices($profile->id));

//$lines = count($data->lines);

isset($data) ? $lines = count($data->lines) : $lines = 1;
isset($invoice) ? $countInvoice = count($invoice->services()) : $countInvoice = 1;
?>

<!-- jQuery -->
<script src="/../js/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="/../js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="/../js/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="/../js/sb-admin-2.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Count'],
            ['Faktury Sprzedaży',     <?php echo $invoices ?>],
            ['Pozycje na fakturze sprzedaży',      <?php echo $services ?>],
            ['Klienci',  <?php echo $customers ?>],
            ['Faktury Zakupu',  <?php echo $invoicesP ?>],
            ['Pozycje na fakturze zakupu',  <?php echo $servicesP ?>],
            ['Dostawcy',  <?php echo $suppliers ?>]
        ]);

        var options = {
            title: 'Statystyki księgowości'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 49 || charCode > 57)) {
            return false;
        }
        return true;
    }

    $(document).ready(function(){

        var c = 1;
        $("#add_row").click(function(){
            c++;
            $("#dynamic-add").append("<tr id=\"row"+c+"\">\n" +
                "                                    <td>"+c+"</td>\n" +
                "                                    <td><input class=\"form-control\" name=\"service[]\" type=\"text\"></td>\n" +
                "                                    <td><input id=\"quantity"+c+"\" class=\"form-control\" name=\"quantity[]\" type=\"text\" onkeypress=\"return isNumber(event)\" value=\"1\"></td>\n" +
                "                                    <td>\n" +
                "                                        <select class=\"form-control\" name=\"jm\" id=\"\">\n" +
                "                                            <option value=\"szt\">szt</option>\n" +
                "                                        </select>\n" +
                "                                    </td>\n" +
                "                                    <td><input id=\"net"+c+"\" class=\"form-control decimal\" name=\"net[]\" type=\"text\"></td>\n" +
                "                                    <td>\n" +
                "                                        <input id=\"netv"+c+"\" class=\"form-control\" name=\"netvalue[]\" type=\"text\" disabled>\n" +
                "                                    </td>\n" +
                "                                    <td><select class=\"form-control\" name=\"tax\" id=\"\">\n" +
                "                                            <option value=\"0.23\">23%</option>\n" +
                "                                        </select></td>\n" +
                "                                    <td><input id=\"tax"+c+"\" class=\"form-control\" name=\"taxvalue[]\" type=\"text\" disabled></td>\n" +
                "                                    <td><input id=\"gross"+c+"\" class=\"form-control\" name=\"gross[]\" type=\"text\" disabled></td>\n" +
                "                                    <td><button id=\""+c+"\" type=\"button\" class=\"btn btn-danger remove_row\">Usuń</button></td>\n" +
                "                                </tr>");


            function myF (i) {
                return i;
            }

            for (var i = 1; i <= c; i++) {
                let x = i;

                $(document).on("keyup", "#net"+x, function () {
                    let n = myF(x);

                    $("#netv"+n).val(($(this).val() * $("#quantity"+n).val()).toFixed(2));
                    $("#tax"+n).val(($("#netv"+n).val() * 0.23).toFixed(2));
                    $("#gross"+n).val(($("#netv"+n).val() * 1.23).toFixed(2));
                });

                $(document).on("keyup", "#quantity"+x, function () {
                    let n = myF(x);

                    $("#netv"+n).val(($(this).val() * $("#net"+n).val()).toFixed(2));
                    $("#tax"+n).val(($("#netv"+n).val() * 0.23).toFixed(2));
                    $("#gross"+n).val(($("#netv"+n).val() * 1.23).toFixed(2));
                });
            }



        });

            $(document).on("click", ".remove_row", function () {
                var button_id = $(this).attr("id");

                $("#row"+button_id+"").remove();


            });


        function myF (i) {
            return i;
        }

        for (var i = 1; i <= <?php echo $lines ?>; i++) {
            let x = i;

            $(document).on("keyup", "#net"+x, function () {
                let n = myF(x);

                $("#netv"+n).val(($(this).val() * $("#quantity"+n).val()).toFixed(2));
                $("#tax"+n).val(($("#netv"+n).val() * 0.23).toFixed(2));
                $("#gross"+n).val(($("#netv"+n).val() * 1.23).toFixed(2));
            });

            $(document).on("keyup", "#quantity"+x, function () {
                let n = myF(x);

                $("#netv"+n).val(($(this).val() * $("#net"+n).val()).toFixed(2));
                $("#tax"+n).val(($("#netv"+n).val() * 0.23).toFixed(2));
                $("#gross"+n).val(($("#netv"+n).val() * 1.23).toFixed(2));
            });
        }

        for (var i = 1; i <= <?php echo $countInvoice ?>; i++) {
            let x = i;

            $(document).on("keyup", "#net"+x, function () {
                let n = myF(x);

                $("#netv"+n).val(($(this).val() * $("#quantity"+n).val()).toFixed(2));
                $("#tax"+n).val(($("#netv"+n).val() * 0.23).toFixed(2));
                $("#gross"+n).val(($("#netv"+n).val() * 1.23).toFixed(2));
            });

            $(document).on("keyup", "#quantity"+x, function () {
                let n = myF(x);

                $("#netv"+n).val(($(this).val() * $("#net"+n).val()).toFixed(2));
                $("#tax"+n).val(($("#netv"+n).val() * 0.23).toFixed(2));
                $("#gross"+n).val(($("#netv"+n).val() * 1.23).toFixed(2));
            });
        }


            $('#net').keyup(function () {
                $("#netv").val(($(this).val() * $("#quantity").val()).toFixed(2));
                $("#tax").val(($("#netv").val() * 0.23).toFixed(2));
                $("#gross").val(($("#netv").val() * 1.23).toFixed(2));
            });

            $('#quantity').keyup(function () {
                $("#netv").val(($(this).val() * $("#net").val()).toFixed(2));
                $("#tax").val(($("#netv").val() * 0.23).toFixed(2));
                $("#gross").val(($("#netv").val() * 1.23).toFixed(2));
            });

        $(document).on("keypress", ".decimal", function (e) {
            var character = String.fromCharCode(e.keyCode);
            var newValue = this.value + character;
            if (isNaN(newValue) || parseFloat(newValue) * 100 % 1 > 0) {
                e.preventDefault();
                return false;
            }

        });







    });


</script>


</body>

</html>