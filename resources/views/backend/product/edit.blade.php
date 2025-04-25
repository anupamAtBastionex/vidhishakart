@extends('backend.layouts.master')

@section('main-content')
<style>
    #image-preview img
    {
        width:100px !important;
        height: 100px !important;
    }
    .img-div{
        width: 150px;
    display: inline-block;
    }
</style>
<div class="card">
    <h5 class="card-header">Edit Product
        <a href="{{ url('admin/product') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Back To Product List"><i class="fas fa-arrow-left"></i> Back</a>
    </h5>
    <div class="card-body">
      <form method="post" action="{{route('product.update',$product->id)}}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="cat_id">Category <span class="text-danger">*</span></label>
            <select name="cat_id" id="cat_id" class="form-control">
                <option value="">Select any category</option>
                @foreach($categories as $key=>$cat_data)
                    <option value='{{$cat_data->id}}' {{(($product->cat_id==$cat_data->id)? 'selected' : '')}}>{{$cat_data->title}}</option>
                @endforeach
            </select>
        </div>
          @php
            $sub_cat_info=DB::table('categories')->select('title')->where('id',$product->child_cat_id)->get();
          // dd($sub_cat_info);

          @endphp
          {{-- {{$product->child_cat_id}} --}}
        <div class="form-group {{(($product->child_cat_id)? '' : 'd-none')}}" id="child_cat_div">
            <label for="child_cat_id">Sub Category</label>
            <select name="child_cat_id" id="child_cat_id" class="form-control">
                <option value="">--Select any sub category--</option>

            </select>
        </div>

        <div class="form-group">
            <label for="google_category">Google Category</label>
            <input type="text" id="google_category" name="google_category" placeholder="Enter Google Category" value="{{ $product->google_category }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="brand_id">Brand</label>
            <select name="brand_id" class="form-control">
                <option value="">Select Brand</option>
               @foreach($brands as $brand)
                <option value="{{$brand->id}}" {{(($product->brand_id==$brand->id)? 'selected':'')}}>{{$brand->title}}</option>
               @endforeach
            </select>
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="title" placeholder="Enter title"  value="{{$product->title}}" class="form-control">
          @error('title')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
            <label for="code">Product Code</label>
            <input id="code" type="text" name="code" placeholder="Enter title"  value="{{$product->code}}" class="form-control">
            @error('title')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
          <label for="summary" class="col-form-label">Summary <span class="text-danger">*</span></label>
          <textarea class="form-control" id="summary" name="summary">{{$product->summary}}</textarea>
          @error('summary')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="description" class="col-form-label">Description</label>
          <textarea class="form-control" id="description" name="description">{{$product->description}}</textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>


        <div class="form-group">
          <label for="is_featured">Is Featured</label><br>
          <input type="checkbox" name='is_featured' id='is_featured' value='{{$product->is_featured}}' {{(($product->is_featured) ? 'checked' : '')}}> Yes
        </div>

        <div class="form-group">
          <label for="price" class="col-form-label">Price(AED) <span class="text-danger">*</span></label>
          <input id="price" type="number" name="price" placeholder="Enter price"  value="{{$product->price}}" class="form-control" required>
          @error('price')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group d-none">
          <label for="discount" class="col-form-label">Discount<span class="text-danger">*</span></label>
          <input id="discount" type="number" name="discount" min="0" max="100" placeholder="Enter discounted Price"  value="0" class="form-control">
          @error('discount')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
            <label for="discount" class="col-form-label">Discounted Price<span class="text-danger">*</span></label>
            <input id="discount_price" type="number" name="discount_price" placeholder="Enter discounted Price"  value="{{$product->discount_price}}" class="form-control" required>
            @error('discount_price')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="quantity_price">Quantity Text (Price By Quantity)  </label>
            <input id="quantity_price" type="text" name="quantity_price" placeholder="Ex:  35: 1 Pair, 55: 2 Pairs, 75: 3 Pairs"  value="{{$product->quantity_price}}" class="form-control">
            @error('quantity_price')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="delivery_charge">Delivery Charges  </label>
            <input id="delivery_charge" type="number" name="delivery_charge" placeholder="Ex:  30"  value="{{$product->delivery_charge}}" class="form-control">
            @error('delivery_charge')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
          <label for="size">Size</label>
          <input type="size" id="size" name="size"  placeholder="Small,Large,Medium" value="{{ $product->size }}" class="form-control">
          {{-- <select name="size[]" class="form-control selectpicker"  multiple data-live-search="true">
              <option value="">Select any size</option>
              @foreach($items as $item)
                @php
                $data=explode(',',$item->size);
                // dd($data);
                @endphp
              <option value="S"  @if( in_array( "S",$data ) ) selected @endif>Small</option>
              <option value="M"  @if( in_array( "M",$data ) ) selected @endif>Medium</option>
              <option value="L"  @if( in_array( "L",$data ) ) selected @endif>Large</option>
              <option value="XL"  @if( in_array( "XL",$data ) ) selected @endif>Extra Large</option>
              <option value="2XL"  @if( in_array( "2XL",$data ) ) selected @endif>Double Extra Large</option>
              <option value="FS"  @if( in_array( "FS",$data ) ) selected @endif>Free Size</option>
              @endforeach
          </select> --}}
        </div>
        <div class="form-group">
            <label for="color">Color</label>
            <input type="text" id="color" name="color"  placeholder="Red,Green,Blue" value="{{ $product->color }}" class="form-control">
        </div>

        <div class="form-group">
          <label for="condition">Condition</label>
          <select name="condition" class="form-control">
              <option value="">Select Condition</option>
              <option value="default" {{(($product->condition=='default')? 'selected':'')}}>Default</option>
              <option value="new" {{(($product->condition=='new')? 'selected':'')}}>New</option>
              <option value="hot" {{(($product->condition=='hot')? 'selected':'')}}>Hot</option>
          </select>
        </div>

        <div class="form-group">
            <label for="stock">Stock Quantity <span class="text-danger">*</span></label>
            <input id="quantity" type="number" name="stock" min="0" placeholder="Enter quantity"  value="{{$product->stock}}" class="form-control">
            @error('stock')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        {{-- <div class="form-group">
            <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-btn">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                  <i class="fas fa-image"></i> Choose
                  </a>
              </span>
                <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$product->photo}}">
            </div>
            <div id="holder" style="margin-top:15px;max-height:100px;"></div>
            @error('photo')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div> --}}
        <div class="form-group">
            <label for="inputPhoto" class="col-form-label">Featured Image <span class="text-danger">*</span></label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="photo" name="photo">
                <label class="custom-file-label" for="images">Choose Image</label>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPhoto" class="col-form-label">More Images</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="images" name="images[]" multiple accept="image/*" onchange="previewImages()">
                <label class="custom-file-label" for="images">Choose images</label>
            </div>
            <div class="mt-3">
                <div id="image-preview">

                    @if(!empty($images))
                        @foreach ($images as $image)
                        <div class="img-div">
                            @php
                                $fullUrl = url(env('APP_URL').'/storage/app/public/photos/'.$product->id.'/'.$image->image);
                                 $deleteUrl = route('delete.image', ['productId' => $product->id, 'imageId' => $image->id]);
                            @endphp
                                <img src="{{ $fullUrl }}" class="img-rounded m-2">
                                <button type="button" class="delete-button" data-delete-url="{{ $deleteUrl }}" onclick="deleteImage(this)">X</button>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="stock">Fake Order Sold</label>
            <input id="fake_older_sold" type="number" name="fake_older_sold" placeholder="Enter Here"  value="{{$product->fake_older_sold }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="rank">Rank</label>
            <input id="rank" type="number" name="rank" placeholder="Enter Here"  value="{{ $product->rank }}" class="form-control">
        </div>
        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
            <option value="active" {{(($product->status=='active')? 'selected' : '')}}>Active</option>
            <option value="inactive" {{(($product->status=='inactive')? 'selected' : '')}}>Inactive</option>
            </select>
            @error('status')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="is_under_deal" class="col-form-label">Is Under Deal? &nbsp;&nbsp;
                <input type="checkbox" class="form-control-label" name='is_under_deal' id='is_under_deal' value='1' {{ (($product->is_under_deal) ? 'checked' : '') }}>
            </label>
        </div>
        <div class="form-group">
            <label for="is_vat_apply" class="col-form-label">Is Vat Applicable? &nbsp;&nbsp;
                <input type="checkbox" class="form-control-label" name='is_vat_apply' id='is_vat_apply' value='yes' {{ (($product->vat == 'yes') ? 'checked' : '') }}>
            </label>
        </div>

        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Update</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
    $('#summary').summernote({
      placeholder: "Write short description.....",
        tabsize: 2,
        height: 150
    });
    });
    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "Write detail Description.....",
          tabsize: 2,
          height: 150
      });
    });
</script>

<script>
  var  child_cat_id='{{$product->child_cat_id}}';
        // alert(child_cat_id);
        $('#cat_id').change(function(){
            var cat_id=$(this).val();

            if(cat_id !=null){
                // ajax call
                $.ajax({
                    url:"/admin/category/"+cat_id+"/child",
                    type:"POST",
                    data:{
                        _token:"{{csrf_token()}}"
                    },
                    success:function(response){
                        if(typeof(response)!='object'){
                            response=$.parseJSON(response);
                        }
                        var html_option="<option value=''>--Select any one--</option>";
                        if(response.status){
                            var data=response.data;
                            if(response.data){
                                $('#child_cat_div').removeClass('d-none');
                                $.each(data,function(id,title){
                                    html_option += "<option value='"+id+"' "+(child_cat_id==id ? 'selected ' : '')+">"+title+"</option>";
                                });
                            }
                            else{
                                console.log('no response data');
                            }
                        }
                        else{
                            $('#child_cat_div').addClass('d-none');
                        }
                        $('#child_cat_id').html(html_option);

                    }
                });
            }
            else{

            }

        });
        if(child_cat_id!=null){
            $('#cat_id').change();
        }
</script>
<script>
    function previewImages() {
        var preview = document.getElementById('image-preview');
        preview.innerHTML = '';

        var files = document.getElementById('images').files;

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var reader = new FileReader();

            reader.onload = function (e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-thumbnail', 'm-2');
                preview.appendChild(img);
            };

            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function deleteImage(button) {

            if(confirm('Are you sure?'))
            {
                var deleteUrl = button.getAttribute('data-delete-url');
                // Use Axios to send a DELETE request to the server
                axios.delete(deleteUrl, {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                .then(response => {
                    // alert(response.data)
                     if(response.data == "yes"){
                        // Handle success (e.g., remove the image container from the DOM)
                        button.parentNode.remove();
                     }else{
                        alert('Item not found');
                     }

                })
                .catch(error => {
                    console.error('There was a problem with the Axios request:', error);
                });
            }

        }
    </script>
@endpush
