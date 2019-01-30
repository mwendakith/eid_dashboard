
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Testing Trends <div class="display_date"></div>
            </div>
            <div class="panel-body">
                <div id="testing_trends"><center><div class="loader"></div></center></div>
                <div class="col-md-12" style="margin-top: 1em;margin-bottom: 1em;">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            Summary Outcomes <div class="display_date" ></div>
          </div>
          <div class="panel-body" id="eid_outcomes">
            <center><div class="loader"></div></center>
          </div>
          
        </div>
    </div>

    <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            Outcomes By EntryPoint <div class="display_date" ></div>
          </div>
          <div class="panel-body" id="entrypoints">
            <center><div class="loader"></div></center>
          </div>
          
        </div>
    </div>

    <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            Outcomes By Age <div class="display_date" ></div>
          </div>
          <div class="panel-body" id="ages">
            <center><div class="loader"></div></center>
          </div>
          
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                County Outcomes <div class="display_date"></div>
            </div>
            <div class="panel-body">
                <div id="county_outcomes"><center><div class="loader"></div></center></div>
                <div class="col-md-12" style="margin-top: 1em;margin-bottom: 1em;">
                </div>
            </div>
        </div>
    </div>
</div>


<div id="my_empty_div"></div>

<script type="text/javascript">

  $().ready(function() {
    $.get("<?php echo base_url();?>template/dates", function(data){
      obj = $.parseJSON(data);

    if(obj['month'] == "null" || obj['month'] == null){
      obj['month'] = "";
    }
    $(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
    });

    $("#fourth").hide();
    $("#fifth").hide();

    localStorage.setItem("my_lab", 0);

    $("#testing_trends").load("<?php echo base_url();?>charts/poc/testing_trends");
    $("#eid_outcomes").load("<?php echo base_url();?>charts/poc/eid_outcomes");

    $("button").click(function () {
        var first, second;
        first = $(".date-picker[name=startDate]").val();
        second = $(".date-picker[name=endDate]").val();

          var new_title = set_multiple_date(first, second);

          $(".display_date").html(new_title);
        
        from  = format_date(first);
        to    = format_date(second);
        var error_check = check_error_date_range(from, to);
          
        if (!error_check) {

            localStorage.setItem("from_year", from[1]);
            localStorage.setItem("from_month", from[0]);

            localStorage.setItem("to_year", to[1]);
            localStorage.setItem("to_month", to[0]);

            var em = localStorage.getItem("my_lab");
      
          $("#testing_trends").html("<div>Loading...</div>");
          $("#eid_outcomes").html("<div>Loading...</div>");

          $("#testing_trends").load("<?php echo base_url();?>charts/poc/testing_trends/"+em+"/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
          $("#eid_outcomes").load("<?php echo base_url();?>charts/poc/eid_outcomes/"+em+"/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
        }
            
    });

    $("select").change(function(){
        em = $(this).val();
        em = parseInt(em);
        localStorage.setItem("my_lab", em);

        console.log(em);

        $("#testing_trends").html("<div>Loading...</div>");
        $("#eid_outcomes").html("<div>Loading...</div>");
        
        $("#testing_trends").load("<?php echo base_url();?>charts/poc/testing_trends/"+em);
        $("#eid_outcomes").load("<?php echo base_url();?>charts/poc/eid_outcomes/"+em);
      
      });


  });
  

function date_filter(criteria, id)
  {
    localStorage.setItem("to_year", 'null');
    localStorage.setItem("to_month", 'null');

    if (criteria === "monthly") {
        localStorage.setItem("from_year", 'null');
        localStorage.setItem("from_month", id);
        year = null;
        month = id;
    }else {
        localStorage.setItem("from_year", id);
        localStorage.setItem("from_month", 'null');
        year = id;
        month = null;
    }

    var posting = $.post( '<?php echo base_url();?>template/filter_date_data', { 'year': year, 'month': month } );

    // Put the results in a div
    posting.done(function( data ) {
      obj = $.parseJSON(data);
      console.log(obj);
      if(obj['month'] == "null" || obj['month'] == null){
        obj['month'] = "";
      }
      $(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
      
      $("#testing_trends").html("<div>Loading...</div>");
      $("#eid_outcomes").html("<div>Loading...</div>");

      var em = localStorage.getItem("my_lab");

        $("#testing_trends").load("<?php echo base_url();?>charts/poc/testing_trends/"+em+"/"+obj['year']+"/"+obj['month']);
        $("#eid_outcomes").load("<?php echo base_url();?>charts/poc/eid_outcomes/"+em+"/"+obj['year']+"/"+obj['month']);
      });    
  }
   
</script>