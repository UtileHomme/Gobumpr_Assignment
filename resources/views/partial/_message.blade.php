@if (session()->has('message'))
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content modal-content2" style="    height: 57px;    margin-top: 87%;">

        <div class="modal-body alert alert-success" style="    text-align: -webkit-center;">
          <p>  {{session()->get('message')}}</p>
        </div>

      </div>

    </div>
  </div>

  <script>
  $(document).ready(function(){
       $('#myModal').modal('show');
  });
  </script>
@endif
