
@extends('layouts.main')

@section('title','Holiday calendar')

@section('content')

<div class="card mt-5">
    <h2 class="text-center mt-5 mb-3">List of holidays</h2>
    
    <div class="card">
        <div class="card-header">
            <!-- <button class="btn btn-outline-primary" > 
                Create New Project
            </button> -->
        </div>
        <div class="card-body">
            <div id="alert-div">
              
            </div>
            <table class="table table-bordered" id="projects_table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Month</th>
                        <th>Type</th>
                        <!-- <th width="240px">Action</th> -->
                    </tr>
                </thead>
                <tbody id="projects-table-body">
                      
                </tbody>
                  
            </table>
        </div>
    </div>
</div>


<!-- view project modal -->
<div class="modal " tabindex="-1" role="dialog" id="view-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Project Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <b>Holiday Title:</b>
        <p id="name-info"></p>
        <b>Description:</b>
        <p id="description-info"></p>
      </div>
    </div>
  </div>
</div>

@endsection


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    


<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>


<script type="text/javascript">
  var SITEURL = "{{ url('/') }}";
    $(function() {
        
        console.log('sdfsdfsfsf');
       
       
        // var baseUrl = $('meta[name=app-url]').attr("content");
        // let url = baseUrl + '/projects';
        // create a datatable
        $('#projects_table').DataTable({
            processing: true,
            ajax: "{{ route('holiday-list') }}",
             "order": [[ 1, "asc" ]],
            columns: [
                { data: 'holiday_name'},
                { data: 'date_of_holiday'},
                { data: 'month'},
                { data: 'type'},
                // { data: 'action'},
            ],
              
        });
      });


       /*
        get and display the record info on modal
    */
    function showHoliday(id)
    {
        
        $("#name-info").html("");
        $("#description-info").html("");
        var tempUrl = "{{route('showholidaydetail',['id'=>":id"])}}",
        tempUrl = tempUrl.replace(":id", id);
        $.ajax({
            url: tempUrl,    
            type: "GET",
            success: function(response) {
                let holidayDetail = response.holidayDetail;
                $("#name-info").html(holidayDetail.holiday_name);
                $("#description-info").html(holidayDetail.description);
                $("#view-modal").modal('show'); 
  
            },
            error: function(response) {
                console.log(response.responseJSON)
            }
        });
    }

</script>




