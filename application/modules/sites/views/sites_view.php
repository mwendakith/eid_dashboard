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
      <a href="<?php echo base_url('charts/sites/download_unsupported_sites');?>">Download List</a>
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
    <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="panel panel-default">
       
        <div id="vlOutcomes">
          <center><div class="loader"></div></center>
        </div>
        
      </div>
    </div>
    
    <div class="col-md-6">
      <div class="panel panel-default">
        
        <div class="panel-body" id="ageGroups">
          <center><div class="loader"></div></center>
        </div>
        
      </div>
    </div>
    
   
  </div>
</div>

<?php $this->load->view('sites_footer')?>