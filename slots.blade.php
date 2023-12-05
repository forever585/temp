<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head><base href="../../">
    <title></title>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <link rel="shortcut icon" href="o" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <style>
        body{
            overflow: hidden!important;
        }

        .container{
            overflow: scroll!important;
        }

        .modal-overlay{
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            background: #00000061;
        }
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
<!--begin::Main-->
<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
    <span class="svg-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
            <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
        </svg>
    </span>
    <!--end::Svg Icon-->
</div>
<!--end::Scrolltop-->
<div class="front-header">
    <div class="container">
        <div class="front-header-container">
            <div class="front-header-top-wrapper">
                <h6 class="front-header-top">💎 💎 {{ strtoupper($title) }} 💎 💎</h6>
            </div>
            <div class="front-header-bottom-wrapper">
                <p class="front-header-bottom">{{$filled}}% out of 100%</p>
            </div>
        </div>
        <div class="row my-5">
            <div class="col-md-6 mt-1">
                <input type="text" class="form-control" placeholder="Search" onkeyup="searchStringChanged(this)" value="{{$string}}"/>
            </div>
            <div class="col-md-6 mt-1">
                <select class="form-select form-select-solid" aria-label="" onchange="searchCategoryChanged(this)">
                    <option value="all" {{$category == 'all' ? " selected" : ""}}>All</option>
                    <option value="available" {{$category == 'available' ? " selected" : ""}}>Available</option>
                    <option value="reserved" {{$category == 'reserved' ? " selected" : ""}}>Reserved</option>
                    <option value="approved" {{$category == 'approved' ? " selected" : ""}}>Approved</option>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <input id="reserve_slot_url" type="hidden" value="{{route('reserve_slot')}}"/>
    <input id="slots_url" type="hidden" value="{{route('slots',  $title)}}"/>
    <div class="wrapper mt-2 d-flex flex-wrap">
        <!-- Start Items Container -->
        @for ($i = 0; $i < count($slots); $i++)
            @if($slots[$i]['status'] == 'Pending')
                <div class="slot-item" id="slot_id_{{$slots[$i]->id}}" style="background: orange;">
                    @elseif($slots[$i]['status'] == 'Approved')
                        <div class="slot-item" id="slot_id_{{$slots[$i]->id}}" style="background: greenyellow;">
                            @else
                                <div class="slot-item" id="slot_id_{{$slots[$i]->id}}">
                                    @endif
                                    <div class="checkbox-container">
                                        @if($slots[$i]['status'] == 'Not Reserved')
                                            <input class="form-check-input" type="checkbox" value="" id="{{$slots[$i]['event_id'] . '-' . $slots[$i]['id']}}" onchange="slotCheckChanged(this)" />
                                        @else
                                            <input class="form-check-input" checked disabled type="checkbox" value="" id="{{$slots[$i]['event_id'] . '-' . $slots[$i]['id']}}" onchange="slotCheckChanged(this)" />
                                        @endif
                                    </div>
                                    <span class="inner-border"></span>
                                    <div>
                                        <label class="form-check-label slot-number" for="" id="{{$slots[$i]['event_id'] . '-' . $slots[$i]['id'] . '_label'}}" slot_id="{{$slots[$i]->id}}">
                                            {{$slots[$i]['slot_number']}}
                                        </label>
                                    </div>
                                    <span class="inner-border"></span>
                                    @if($slots[$i]['status'] == 'Pending')
                                        <div class="border-paragraph-left bg-orange">
                                            <p class="m-0 username" status="reserved" slot_id="{{$slots[$i]->id}}">
                                                {{$slots[$i]['username']}}
                                            </p>
                                        </div>
                                    @elseif($slots[$i]['status'] == 'Approved')
                                        <div class="bg-green">
                                            <p class="m-0 username" status="approved" slot_id="{{$slots[$i]->id}}">
                                                {{$slots[$i]['username']}}
                                            </p>
                                        </div>
                                    @else
                                        <div class="">
                                            <p class="m-0 username" status="available" slot_id="{{$slots[$i]->id}}">

                                            </p>
                                        </div>
                                    @endif
                                </div>
                                @endfor
                        </div>
                        <div class="button-container mt-2">
                            <div class="container">
                                <button type="button" class="btn btn-primary w-100" onclick="handleUserClick()">
                                    RESERVE SLOTS HERE
                                </button>
                            </div>
                        </div>
                </div>

                <div class="modal" id="modal_no_selected_warning">
                    <div class="modal-overlay"></div>
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Reservation Form</h5>

                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm ms-2" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal('modal_no_selected_warning')">
                                    <span class="svg-icon svg-icon-2x">x</span>
                                </div>
                                <!--end::Close-->
                            </div>

                            <div class="modal-body">
                                <p>Upang makapagpareserve ng slots, icheck nyo lang po yung checkbox dun sa list namin.</p>
                            </div>

                            <div class="modal-footer">
                                <button href="#" class="btn btn-outline btn-outline-primary btn-active-light-primary w-100" onclick="closeModal('modal_no_selected_warning')">PICK SLOTS</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal" id="modal_selected">
                    <div class="modal-overlay"></div>
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Reservation Form</h5>

                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm ms-2" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal('modal_selected')">
                                    <span class="svg-icon svg-icon-2x">x</span>
                                </div>
                                <!--end::Close-->
                            </div>

                            <div class="modal-body pt-2">
                                <div class="mb-3">
                                    <label for="" class="required form-label fw-bolder">Facebook Name</label>
                                    <input id="frontend_facebook_name" type="text" class="form-control form-control-solid" placeholder="Please Input Your Facebook Name" required/>
                                </div>

                                <div class="mb-3">
                                    <label for="" class="required form-label fw-bolder">Mobile Number</label>
                                    <input id="frontend_mobile_number" type="text" class="form-control form-control-solid" placeholder="Please Input Your Mobile Number" required/>
                                </div>

                                <div class="selected-slots-container">
                                    <label id="slot_tag_label" for="" class="form-label fw-bolder"></label>
                                    <div id="slot_tag_html_container" class="slot-tags-container">

                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer pt-0">
                                <button href="#" class="btn btn-primary w-100" onclick="reserveSlot()">RESERVE</button>
                                <button href="#" class="btn btn-outline btn-outline-primary btn-active-light-primary w-100 mt-3" onclick="closeModal('modal_selected')">PICK SLOTS</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal" tabindex="-1" id="modal_success">
                    <div class="modal-overlay"></div>
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Successfully Registered</h5>

                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm ms-2" data-bs-dismiss="modal" aria-label="Close" onclick="closeModalAndRefresh('modal_success')">
                                    <span class="svg-icon svg-icon-2x">x</span>
                                </div>
                                <!--end::Close-->
                            </div>

                            <div class="modal-body">
                                <div class="payment-info-container">
                                    <img src="{{asset('assets/media/thankyou.jpg')}}" alt="" class="border-3 mb-3" style="width: 96px; height: 96px; border-radius: 5px"/>
                                    <span>Gcash name: <span class="fw-bolder">{{$gcash_name}}</span></span>
                                    <span>Gcash number: <span class="fw-bolder">{{$gcash_number}} <i class="fa fa-copy" onclick="copyCashNumber()"></i> </span></span>
                                    <span>Amount payable: <span id="amount_payable" class="fw-bolder"></span></span>
                                </div>
                                <p class="mt-3">{{$thankyou_message}}<br/>
                            </div>

                            <div class="modal-footer">
                                <a href="{{$message_link}}" class="btn btn-primary btn-active-light-primary w-100" onclick="closeModalAndRefresh('modal_success')">GO TO MESSENGER</a>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
</div>
<!--begin::Javascript-->
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
<!--end::Page Custom Javascript-->
<!--end::Javascript-->
<script>
    let searchString = "{{$string}}";
    let searchCategory = "{{$category}}";
    let checkedSlotIds = [];
    let slotsCount = 0;
    const userSlotsLimit = parseInt("{{$user_slots_limit}}");
    const priceStyle = "{{$price_style}}";
    const slotPrice = parseInt("{{$slot_price}}");
    const gCashNumber = "{{$gcash_number}}";

    const searchStringChanged = (element) =>{
        searchString = element.value;
        searchSlots();
    };

    const searchCategoryChanged = (element) =>{
        searchCategory = element.value;
        searchSlots();
    };

    const searchSlots = () => {
        const slotNumberDomList = $('.slot-number');
        const usernameDomList = $('.username');
        const slotLength = slotNumberDomList.length;
        for( let i = 0; i < slotLength; i++){
            const slotNumber = slotNumberDomList[i].textContent.trim();
            const username = usernameDomList[i].textContent.trim();
            const slotId = slotNumberDomList[i].attributes.slot_id.nodeValue;
            const slotItemContainer = $('#slot_id_' + slotId);
            const status = usernameDomList[i].attributes.status.nodeValue;
            const stringCondition = slotNumber.includes(searchString) || username.includes(searchString);
            const categoryCondition = status === searchCategory || searchCategory === 'all';
            if( stringCondition && categoryCondition){
                slotItemContainer.show();
            }
            else{
                slotItemContainer.hide();
            }
        }
    };

    const slotCheckChanged = (element) => {
        const id = element.attributes.id.nodeValue;
        if(element.checked === true) $('#' + id).addClass(' checked');
        else $('#' + id).removeClass(' checked');
    };

    const handleUserClick = () => {
        const checkedElements = $('.checked');
        if(checkedElements.length === 0) {
            $('.modal').hide();
            $('#modal_no_selected_warning').show();
        }
        else {
            $('.modal').hide();
            const checkElementsCount = checkedElements.length;
            slotsCount  = checkElementsCount;
            const price = calcPrice(checkElementsCount);
            $('#slot_tag_label').html(`Slot Numbers( ${checkElementsCount} slots = ₱${price} )`);
            $('#amount_payable').html(`₱${price}(${checkElementsCount} slots)`);
            showCheckedTags(checkedElements);
            $('#modal_selected').show();
        }
    };

    const showCheckedTags = (checkedElements) => {
        let checkedLabelTagHtml = '';
        checkedSlotIds = [];
        for (let i = 0; i < checkedElements.length; i++){
            const checkedElementId = checkedElements[i].attributes.id.nodeValue;
            const checkedElementLabel = $('#' + checkedElementId + '_label')[0].innerHTML;
            checkedLabelTagHtml += `<span class="slot-tag">#${checkedElementLabel} <span class="slot-tag-close" onclick="removeTag('${checkedElementId}')">x</span></span>`;
            checkedSlotIds.push(checkedElementId.split('-')[1]);
        }
        $('#slot_tag_html_container').html(checkedLabelTagHtml);
    };

    const removeTag = (elementId) => {
        const checkBoxElement =  $('#' + elementId);
        checkBoxElement.prop('checked', false);
        checkBoxElement.removeClass(' checked');
        handleUserClick();
    };

    const reserveSlot = () => {
        const facebookName = $('#frontend_facebook_name').val();
        if(facebookName === '') {
            toastr.error('You must input your facebook name!');
            return;
        }
        const mobileNumber = $('#frontend_mobile_number').val();
        if(mobileNumber === '') {
            toastr.error('You must input your mobile number!');
            return;
        }

        if(!testPhoneNumber(mobileNumber)){
            toastr.error('You must input valid phone number');
            return;
        }

        if(slotsCount > userSlotsLimit){
            Swal.fire({
                text: `You have to select till ${userSlotsLimit}`,
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-warning"
                }
            });
            return;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: $('#reserve_slot_url').val(),
            data:{
                'facebook_name': facebookName,
                'mobile_number': mobileNumber,
                'slot_ids': checkedSlotIds
            },
            success: function (result) {
                console.log(result);
                if(result.success) {
                    toastr.success(result.message);
                    closeModal('modal_selected');
                    $('#modal_success').show();
                }
                else {
                    Swal.fire({
                        text: result.message,
                        icon: "warning",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-warning"
                        }
                    }).then((res) => {
                        location.reload();
                    });
                }

            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    };

    const closeModal = (id) =>{
        $('#' + id).hide();
    };

    const closeModalAndRefresh = (id) => {
        $('#' + id).hide();
        location.reload();
    };

    const testPhoneNumber = (phoneNumber) => {
        let ph = new RegExp(/^(09|\+639)\d{9}$/)
        return ph.test(phoneNumber);
    };

    const calcPrice = (slotsCount) => {
        let price = 0;
        if(priceStyle === 'standard_price'){
            price = slotPrice * slotsCount;
        }else{
            if( slotsCount === 1)
                price = slotPrice;
            else if( slotsCount <= 3 )
                price = slotPrice * 2;
            else if( slotsCount <= 6 )
                price = slotPrice * 4;
            else if( slotsCount <= 9 )
                price = slotPrice * 6;
            else if( slotsCount <= 12 )
                price = slotPrice * 8;
            else if( slotsCount <= 15 )
                price = slotPrice * 10;
            else if( slotsCount <= 30 )
                price = slotPrice * 20;
            else if( slotsCount <= 60 )
                price = slotPrice * 40;
            else price = slotPrice * 50;
        }
        return Math.round(price);
    };

    const copyCashNumber = () => {
        navigator.clipboard.writeText(gCashNumber).then(() => {
            toastr.success('GCashNumber successfully copied to clipboard!')
        }, () => {
            toastr.error('Failed to copy. Try again!')
        })
    }

</script>
</body>
<!--end::Body-->
</html>