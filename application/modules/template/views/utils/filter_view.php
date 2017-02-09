<style type="text/css">
  .ui-datepicker-calendar {
display: none;
}
</style>
<div class="row" id="filter">
    <div class="col-md-3">
        <form action="<?php echo base_url();?>template/filter_county_data" method="post" id="filter_form">
            <select class="btn btn-primary js-example-basic-single" style="background-color: #C5EFF7;" name="county">
                <option value="0" disabled="true" selected="true">Select County:</option>
                <option value="48">National</option>
                <?php echo $filter; ?>
            </select>
        </form>
    </div>
    <div class="col-md-2">
        <div id="breadcrum" class="alert" style="background-color: #1BA39C;/*display:none;"></div>
    </div>
    <div class="col-md-4" id="year-month-filter">
        <div class="filter">
            Year: 
            <a href="javascript:void(0)" onclick="date_filter('yearly', 2010 )" class="alert-link"> 2010 </a>|
            <a href="javascript:void(0)" onclick="date_filter('yearly', 2011 )" class="alert-link"> 2011 </a>|
            <a href="javascript:void(0)" onclick="date_filter('yearly', 2012 )" class="alert-link"> 2012 </a>|
            <a href="javascript:void(0)" onclick="date_filter('yearly', 2013 )" class="alert-link"> 2013 </a>|
            <a href="javascript:void(0)" onclick="date_filter('yearly', 2014 )" class="alert-link"> 2014 </a>|
            <a href="javascript:void(0)" onclick="date_filter('yearly', 2015 )" class="alert-link"> 2015 </a>|
            <a href="javascript:void(0)" onclick="date_filter('yearly', 2016 )" class="alert-link"> 2016 </a>|
            <a href="javascript:void(0)" onclick="date_filter('yearly', 2017 )" class="alert-link"> 2017 </a>|
            <a href="javascript:void(0)" onclick="date_filter('yearly', 2018 )" class="alert-link"> 2018 </a>
        </div>
        <div class="filter">
            Month: 
            <a href='javascript:void(0)' onclick='date_filter("monthly", 1)' class='alert-link'> Jan </a>|
            <a href='javascript:void(0)' onclick='date_filter("monthly", 2)' class='alert-link'> Feb </a>|
            <a href='javascript:void(0)' onclick='date_filter("monthly", 3)' class='alert-link'> Mar </a>|
            <a href='javascript:void(0)' onclick='date_filter("monthly", 4)' class='alert-link'> Apr </a>|
            <a href='javascript:void(0)' onclick='date_filter("monthly", 5)' class='alert-link'> May </a>|
            <a href='javascript:void(0)' onclick='date_filter("monthly", 6)' class='alert-link'> Jun </a>|
            <a href='javascript:void(0)' onclick='date_filter("monthly", 7)' class='alert-link'> Jul </a>|
            <a href='javascript:void(0)' onclick='date_filter("monthly", 8)' class='alert-link'> Aug </a>|
            <a href='javascript:void(0)' onclick='date_filter("monthly", 9)' class='alert-link'> Sep </a>|
            <a href='javascript:void(0)' onclick='date_filter("monthly", 10)' class='alert-link'> Oct </a>|
            <a href='javascript:void(0)' onclick='date_filter("monthly", 11)' class='alert-link'> Nov </a>|
            <a href='javascript:void(0)' onclick='date_filter("monthly", 12)' class='alert-link'> Dec</a>
        </div>
    </div>
    <div class="col-md-2">
        <label for="startDate">From :</label>
        <input name="startDate" id="startDate" class="date-picker" onchange="youFunction();" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"/>
        <label for="startDate">To :</label>
        <input name="endDate" id="endDate" class="date-picker" /><button id="filter" class="btn btn-primary">Filter</button>
    </div>
</div>
<script type="text/javascript">
  $(function() {
    $('.date-picker').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MM yy',
        onClose: function(dateText, inst) { 
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
    });
  });
  $().ready(function(){
    $(".js-example-basic-single").select2();
    //Getting the URL dynamically
    var url = $(location).attr('href');
    // Getting the file name i.e last segment of URL (i.e. example.html)
    var fn = url.split('/').indexOf("partner");
    console.log(fn);
    
    if (fn==-1) {
      $.get("<?php echo base_url();?>template/breadcrum", function(data){
        $("#breadcrum").html(data);
      });
    } else {
      $.get("<?php echo base_url();?>template/breadcrum", function(data){
        $("#breadcrum").html(data);
      });
    }
    
  });
</script>