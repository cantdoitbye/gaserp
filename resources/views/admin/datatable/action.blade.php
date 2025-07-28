<div class="d-flex align-items-center justify-content-center">
    @if(!isset(request()->deleted))
        @if(isset($is_view) && $is_view && $view_route)
            <a href="{{ $view_route }}" target="_blank"class=""
               title="View detail" style="color:#359FFF;">View
               {{-- <i class="fas fa-eye"></i> --}}
            </a>
        @endif
          {{-- New PDF Download Button --}}
          @if(isset($is_pdf) && $is_pdf && isset($pdf_route))
          <a href="{{ $pdf_route }}" class="btn btn-info actionBtn mx-1" 
             title="Download PDF" target="_blank">
              <i class="fas fa-file-pdf"></i>
          </a>
      @endif
        @if(isset($is_hotel) && $is_hotel && isset($hotel_route))
        <button class="btn btn-sm btn-primary addHotel" data-id="{{ $model->id }}">Add Hotel</button>
        {{-- <a href="{{ $hotel_route }}" class="btn btn-info addHotel" title="Hotel"
           data-id="{{ $model->id }}"  data-name="{{ $name }}">Hotel</a> --}}
    @endif
        @if(isset($is_edit) && $is_edit)
            <a href="javascript:;" class="btn btn-secondary actionBtn editRow mx-1" title="Edit"
               data-id="{{ $model->id }}"><i
                    class="fas fa-edit"></i></a>
        @endif
        @if(isset($is_delete) && $is_delete && isset($delete_route))
            <a href="javascript:;" class="btn btn-danger table-dbtn actionBtn deleteRow mx-1" title="Delete"
               data-id="{{ $model->id }}" data-type="1" data-url="{{ $delete_route }}" data-name="{{ $name }}"><i
                    class="fas fa-trash"></i></a>
        @endif
        @if(isset($is_tourplan) && $is_tourplan && isset($tour_plan_route))
        <a href="{{ $tour_plan_route }}" class="btn btn-primary " title="Tour Plan"
           data-id="{{ $model->id }}"  data-name="{{ $name }}">Plan Data</a>
    @endif
    @if(isset($is_view_rooms) && $is_view_rooms)
    <!-- Button to trigger the modal for room details -->
    <button class="btn btn-primary view-rooms" 
            data-bs-toggle="modal" 
            data-bs-target="#roomsModal" 
            data-rooms='@json($model->rooms)'>
        View Rooms
    </button>
@endif

@if(isset($is_view_enquiry) && $is_view_enquiry)
<!-- Button to trigger the modal for room details -->
<button class="btn btn-primary view-enquiry" 
        data-bs-toggle="modal" 
        data-bs-target="#enquiryModal" 
        data-id="{{$model->id}}">
    View Enquiry
</button>
@endif


    @else
        <a href="javascript:;" class="btn btn-danger table-rbtn actionBtn deleteRow mx-1"
           data-id="{{ $model->id }}" data-type="2" data-url="{{ $delete_route }}" data-name="{{ $name }}"
           title="Restore"><i class="fas fa-undo"></i></a>
{{--        <a href="javascript:;" class="btn btn-danger table-dbtn actionBtn deleteRow" title="Delete User"--}}
{{--           data-id="{{ $model->id }}" data-type="3" data-url="{{ $delete_route }}" data-name="{{ $name }}"><i--}}
{{--                class="fas fa-trash"></i></a>--}}
    @endif
</div>
