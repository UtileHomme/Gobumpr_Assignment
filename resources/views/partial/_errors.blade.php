@if (count($errors)>0)
  @foreach ($errors->all() as $error)

  <style media="screen">
      .modal-content2
      {
          height: 57px;
          margin-top: 87%;
      }
  </style>

  <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content modal-content2">

          <div class="modal-body alert alert-success" style="    text-align: -webkit-center;">
            <p>  {{$error}}<br></p>
          </div>

        </div>

      </div>
    </div>

    <script>
    $(document).ready(function(){
         $('#myModal').modal('show');
    });
    </script>
  @endforeach

@endif
