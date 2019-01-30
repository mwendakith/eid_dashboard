<style type="text/css">
  .display_date {
    width: 130px;
    display: inline;
  }
  #filter {
    background-color: white;
    margin-bottom: 1.2em;
    margin-right: 0.1em;
    margin-left: 0.1em;
    padding-top: 0.5em;
    padding-bottom: 0.5em;
  }
  #year-month-filter {
    font-size: 12px;
  }
</style>

<div id="first">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          Facilities Outcomes <div class="display_date"></div>
        </div>
          <div class="panel-body" id="siteOutcomes">
            <center><div class="loader"></div></center>
          </div>
      </div>
    </div>
  </div>
 
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          Facilities Without Supporting Partner <div class="display_date"></div>
        </div>
          <div class="panel-body" id="unsupportedSites">
            <center><div class="loader"></div></center>
          </div>
          
      </div>
    </div>
  </div>
</div>

<div id="second">
  <div class="row">
    <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="panel panel-default">
        
        <div class="panel-body" id="tsttrends">
          <center><div class="loader"></div></center>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="panel panel-default">
        
        <div class="panel-body" id="stoutcomes">
          <center><div class="loader"></div></center>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <!-- Map of the country -->
    <div class="col-md-5 col-sm-12 col-xs-12">
      <div class="panel panel-default">
       
        <div id="eidOutcomes">
          <center><div class="loader"></div></center>
        </div>
        
      </div>
    </div>

    <div class="col-md-4 col-sm-12 col-xs-12">
      <div class="panel panel-default">
       
        <div id="heiOutcomes">
          <center><div class="loader"></div></center>
        </div>
        
      </div>
    </div>
    
    <div class="col-md-3">
      <div class="panel panel-default">
        
        <div class="panel-body" id="heiFollowUp">
          <center><div class="loader"></div></center>
        </div>
        
      </div>
    </div>
    
   
  </div>
  <div class="row" style="display: none;">
    <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          Longitudinal Patient Tracking Statistics <div class="display_date"></div>
        </div>
        <div class="panel-body" id="pat_stats">
          <center><div class="loader"></div></center>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              Patients Outcomes <div class="display_date"></div>
            </div>
            <div class="panel-body" id="pat_out">
              <center><div class="loader"></div></center>
            </div>
          </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              Patients Graphs <div class="display_date"></div>
            </div>
            <div class="panel-body" id="pat_graph">
              <center><div class="loader"></div></center>
            </div>
          </div>
        </div>
      </div>
    </div>  
  </div>
</div>

<?php $this->load->view('sites_footer')?>