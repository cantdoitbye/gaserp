<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User detail | Admin panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    @include('admin.layout.css')

    <style>
.user-info-p{
    font-size: 14px; 
    color: rgba(154, 154, 154, 1);
                           
}

.user-info-h5{
    margin-top: -10px;
    font-weight: 600;
    font-size: 16px;
    color: rgba(37, 37, 37, 1);
}

th ,td{
    height: 50px;
    text-align: center;
    font-size: 13px
}

.sidebar-item {
    font-size: 25px;
    height: 57px;
     /* margin-left: 0px; */
    text-align: center;
    cursor: pointer;
}

.second-div {
    display: none;
}

.second-div.active {
    display: block;
}




.sidebar-item {
    font-size: 25px;
    height: 57px;
     margin-left: 0px;
    text-align: center;
    cursor: pointer;
}

.second-div {
    display: none;
}

.second-div.active {
    display: block;
}

.second-div-child{
    margin-top: 25px;
    height: 130px;
    width: 29vw;
    margin-left: 0px;
    background: rgba(245, 245, 245, 1);
    border-radius: 0px, 16px, 16px, 16px;
     padding:10px 10px;
}

.second-div-child p:nth-child(1){
    background: rgb(232, 226, 241);
    font-size: 12px;
    width: auto;
    height: 23px;
    color: rgba(114, 16, 255, 1);
    border-radius: 5px;
    font-weight: 500;
}

.second-div-child p:nth-child(2){
    font-size: 14px;
    /* width: auto; */
    font-weight: 400;
    padding: 0%;
}
.second-div-bottom{
  margin-top: 100%;
  width: 32.7vw;
  height: 112px;
  margin-left: -13px;
  background: rgba(74, 222, 128, 0.1);
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;

}
.second-div-bottom div{
    height: 50px;
    width: 200px;
    
}
.second-div-bottom p{
    color: rgba(74, 175, 87, 1);
}
.feedback-box {
    border: 1px solid #ccc; /* Border for the feedback box */
    border-radius:10px;
    margin-bottom: 10px; /* Spacing between each feedback box */
    padding: 10px; /* Padding inside the feedback box */
    word-wrap: break-word; /* Allow long words to wrap within the box */
}

.feedback-title {
    font-weight: bold; /* Bold font for the feedback title */
    margin-bottom: 5px; /* Spacing between title and message */
    word-wrap: break-word; /* Allow long words to wrap within the title */
}

.feedback-message {
    /* Styles for the feedback message */
    word-wrap: break-word; /* Allow long words to wrap within the message */
}

/* ----------------------------------------------------- */
@media (max-width: 576px){

/* ----------------------------------------------------- */
    .custom-div-two-child div p {
        font-size: 15px;
    }

/* ----------------------------------------------------- */
    .on-the-way {
        width: 100px;
        height: 27px;
        margin: 0px;
        padding: 0px;
        font-size: 8px;
        padding-top: -10px;
    }

/* ----------------------------------------------------- */
    .custom-div-two-child-date {
        font-weight: 600;
        font-size: 20px;
        text-align: start;
        margin-left: 34px;
    }

/* ----------------------------------------------------- */

    .custom-div-three {
        display: flex;
        flex-direction: column;
        height: auto;
    }

    .custom-div-three-child {
        margin-top: 50px;
        width: auto;
    }
}
.second-div-child-reviews{
    margin-top: 16px;
    max-height: 200px;
    max-width: 23vw;
    margin-left: 0px;
    background: hsl(0, 0%, 90%);
    border-radius: 0px, 16px, 16px, 16px;
     padding:10px 10px;
}

</style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9" style="background: #f9f9f9;" >
                <div style="background: rgba(255, 255, 255, 1); font-size: 32px;  font-weight: 600;" class="custom-div row border ">
                    <h1>User Details</h1>
                </div>
                <div class="row ps-4  p-2 mt-4 user-info">
                <div class="row  border rounded">
                    <div class="row pt-4">
                        <div class="col">
                            <p class="user-info-p">name</p>
                            <h5 class="user-info-h5">{{$userData->name}}</h5>
                        </div>
                   
                        <div class="col">
                            <p class="user-info-p">Phone Number</p>
                            <h5 class="user-info-h5">+{{$userData->mobile}}</h5>
                        </div>
                        <div class="col">
                            <p class="user-info-p">Email</p>
                            <h5 class="user-info-h5">{{$userData->email ?? '--'}}</h5>
                        </div>
                        <div class="col">
                            <p class="user-info-p">Total orders</p>
                            <h5 class="user-info-h5">{{$parcelCount}}</h5>
                        </div>
                        <div class="col">
                            <p class="user-info-p">Registration Date</p>
                            <h5 class="user-info-h5">{{$registration_date}}</h5>
                        </div>
                    </div>
                    <div class="row pt-4  ">
                     
                      
                        <div class="col">
                            <p class="user-info-p">Last Login</p>
                            <h5 class="user-info-h5"> 11-02-2022</h5>
                        </div>
                        <div class="col">
                            <p class="user-info-p">Account Status</p>
                            <h5 class="user-info-h5"  style="color: rgba(53, 159, 255, 1);" > Active</h5>
                        </div>
                        <div class="col">
    <p class="user-info-p">Ratings</p>
    <h5 class="user-info-h5">
        @for($i = 1; $i <= 5; $i++)
            @if ($i <= $rating)
                <i class="fas fa-star" style="color: #FFD700;"></i> <!-- Dark yellow color for filled stars -->
            @else
                <i class="far fa-star" style="color: #FFD700;"></i> <!-- Yellow color for empty stars -->
            @endif
        @endfor
    </h5>
</div>

                        <div class="col">
                            <p class="user-info-p">Highest Value Order</p>
                            <h5 class="user-info-h5"> GHS {{$highestOrder}}</h5>
                        </div>
                        <div class="col ">
                          
                        </div>
                    </div>
                    
                    <div class="row pt-4 mb-4">
                      
                      
                    </div>
                    
                </div>
                <div class="row  mt-3 ">

                @include('admin.component.ordertable')

                </div>
                
                </div>
            </div>
            <div class="col-md-3 border" id="sidebar" >
                
                    <div class="first-div border-bottom row">
                        <div class="col">
                            <h2 class="sidebar-item" id="sos">Reviews</h2>
                        </div>
                        <div class="col">
                            <h2 class="sidebar-item" id="review">Feedback</h2>
                        </div>
                       
                    </div>
                    <div class="second-div" id="reviews">
      
        <div id="reviews-content">
           
            @foreach($reviews as $review)
            <div class="review second-div-child-reviews" style="border: 
            ; border-radius: 13px;">
                <div class="feedback-message text-center">{{ $review->comment }}</div>
            </div>
          
        @endforeach
        </div>
    </div>
    <div class="second-div" id="feedback">
        @foreach($feedbacks as $feedback)
        <div id="feedback-content">
          
            <div class="feedback-box second-div-child-reviews">
        <div class="feedback-title">{{ $feedback->title }}</div>
        <div class="feedback-message">{{ $feedback->feedback }}</div>
    </div>
            @endforeach
        </div>
    </div>
                 
              
            </div>

        </div>
    </div>
    <input type="hidden" name="id" id="id" value="{{ $id }}">

    
    @include('admin.layout.script')

    
<script>

   
var table = $('#roleTable');
    $(document).ready(function () {

  console.log(id);

        table.DataTable({
            "scrollX": true,
            processing: true,
            serverSide: true,
            "order": [[0, "asc"]],
            "bAutoWidth": false, // Disable the auto width calculation
            ajax: {
                url: globalSiteUrl + "/admin/orders",
                data: function (data) {
                    data.filterStartDate = $('#filterStartDate').val();
                data.filterEndDate = $('#filterEndDate').val();
                data.filterStatus = $('#filterStatus').val();
                data.userId = $('#id').val();
                }
            },
            columns: [
                {data: 'created_at', name: 'created_at', searchable: false},
                {data: 'id', name: 'id', searchable: true},
                {data: 'display_name', name: 'display_name', searchable: true},

                {data: 'submit_by_user', name: 'submit_by_user', searchable: false},
                {data: 'rider', name: 'rider', searchable: false},
                {data: 'subtotal', name: 'subtotal', searchable: false},
                {data: 'taxes', name: 'taxes', searchable: false},
                {data: 'final_ammount', name: 'final_ammount', searchable: false},
                {data: 'payment_method', name: 'payment_method', searchable: false},
                {data: 'rating', name: 'rating', searchable: false},
                {data: 'status', name: 'status', searchable: false},
                {data: 'action', name: 'action', sortable: false, searchable: false},
            ],
            "drawCallback": function (settings) {
                $('#total_record').html(settings.json.recordsTotal)

                $('.role_count').html(settings.json.recordsTotal)
            }
        });

    });
   
    const sidebarItems = document.querySelectorAll('.sidebar-item');
    const secondDivs = document.querySelectorAll('.second-div');
    
    sidebarItems.forEach(item => {
        item.addEventListener('click', () => {
           
            sidebarItems.forEach(item => {
                item.style.color = '';
                item.style.borderBottom = '';
            });
    
          
            item.style.color = 'rgba(255, 9, 32, 1)';
            item.style.borderBottom =  '2px solid rgba(255, 9, 32, 1)';
        });
    
    
        if (item.textContent === 'Reviews') {
            item.style.color = 'red';
            item.style.borderBottom = '2px solid rgba(255, 9, 32, 1)';
        }
    });
    
    
    
    sidebarItems.forEach((item, index) => {
        item.addEventListener('click', () => {
            sidebarItems.forEach(item => {
                item.classList.remove('active');
            });
    
            item.classList.add('active');
    
            secondDivs.forEach(div => {
                div.classList.remove('active');
            });
    
            secondDivs[index].classList.add('active');
        });
    
        if (item.textContent === 'Reviews') {
            item.classList.add('active');
            secondDivs[index].classList.add('active');
        }
    });
    
    
    
    </script>

</body>
</html>
