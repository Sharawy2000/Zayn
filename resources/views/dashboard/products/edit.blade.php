@extends('dashboard.layouts.app')
@inject('category','App\Models\Category')
@inject('color','App\Models\Color')
@inject('size','App\Models\Size')
@section('body')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Product #{{ $product->id }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">product</li>
              <li class="breadcrumb-item"><a href="{{ route('products.index') }}"><i class="fas fa-arrow-left"> </i> back</a></li>

            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
              
              <div class="card card-primary">
                  <form action="{{ route('products.update',$product->id) }}" method="post" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                      <div class="card-body">
                          @include('inc.success-error-msg')
                        <div class="form-group">
                          <label for="exampleInputEmail1">Name</label>
                          <input type="text" name='name' class="form-control" id="exampleInputEmail1" value="{{ $product->name }}">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Description</label>
                          <textarea name="description" class="form-control" id="exampleInputEmail1" cols="30" rows="10" placeholder="Write a description . . .">{{ $product->description }}</textarea>
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Price</label>
                          <input type="number" name='price' class="form-control" id="exampleInputEmail1" value="{{ $product->price }}" min="1">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Category</label>
                          <select name="category_id" class="form-control">
                            @foreach ($category->all() as $cat )
                              <option value="{{ $cat->id }}" {{ $cat->id == $product->category_id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Images</label><br>
                          @foreach ($product->images as $img )
                          <img src="{{ asset($img->url) }}" style="display: inline;margin-bottom:10px" height="150" width="150" alt="No img">                      
                          @endforeach
                          <input type="file" class="form-control" name="images[]" id="images" multiple>
                        </div>
                          <!-- Image Preview Section -->
                        <div id="image-preview" class="mt-3" style="display: flex; gap: 10px; flex-wrap: wrap;"></div>
                        
                        <div class="form-group">
                          <label for="exampleInputEmail1">Colors</label><br>
                          <button type="button" class="btn btn-secondary" style="margin-bottom: 20px" id="add-color">Add Color</button>
                          <div id="colors-container">
                            @foreach ($product->colors as $productColor )              
                            <div class="color-selection">
                                <select name="colors[]" style="margin-top: 5px" class="form-control color-select" onchange="checkColorForDuplicate(this)">
                                  <option value="" selected disabled>Select a color</option>
                                    @foreach ($color->all() as $color)
                                        <option value="{{ $color->id }}" {{ $productColor->id == $color->id ? 'selected' : '' }}>{{ $color->name }}</option>
                                    @endforeach
                                </select>
                                <input type="number" name="colors_price_adjustment[]" style="margin: 5px 0px 20px 0px" class="form-control price-adjustment" min="0" value="{{ $productColor->pivot->price_adjustment }}"/>
                            </div>
                            @endforeach
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Sizes</label><br>
                          <button type="button" class="btn btn-secondary" style="margin-bottom: 20px" id="add-size">Add Size</button>
                          <div id="sizes-container">
                            @foreach ($product->sizes as $productSize )
                              <div class="size-selection">
                                  <select name="sizes[]" style="margin-top: 5px" class="form-control size-select" onchange="checkSizeForDuplicate(this)">
                                    <option value="" selected disabled>Select a size</option>
                                      @foreach ($size->all() as $size)
                                          <option value="{{ $size->id }}" {{ $productSize->id == $size->id ? 'selected' : '' }}>{{ $size->name }}</option>
                                      @endforeach
                                  </select>
                                  <input type="number" name="sizes_price_adjustment[]" style="margin: 5px 0px 20px 0px" class="form-control price-adjustment" min="0" value="{{ $productSize->pivot->price_adjustment }}" />
                              </div>
                            @endforeach
                          </div>
                        </div>
                      </div>
                      <!-- /.card-body -->
      
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                      </div>
                  </form>
              </div>
              
            </div>
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
@section('scripts')
<script>
  document.getElementById('images').addEventListener('change', function(event) {
      const previewContainer = document.getElementById('image-preview');
      previewContainer.innerHTML = ''; // Clear previous previews

      const files = event.target.files;
      if (files) {
          Array.from(files).forEach((file, index) => {
              const reader = new FileReader();

              reader.onload = function(e) {
                  // Create container for each image and number
                  const imageWrapper = document.createElement('div');
                  imageWrapper.style.display = 'flex';
                  imageWrapper.style.flexDirection = 'column';
                  imageWrapper.style.alignItems = 'center';
                  imageWrapper.style.marginRight = '10px';

                  // Create number label
                  const numberLabel = document.createElement('span');
                  numberLabel.textContent = `${index + 1}`;
                  numberLabel.style.marginBottom = '5px';
                  numberLabel.style.fontSize = '14px';
                  numberLabel.style.color = '#555';

                  // Create image element
                  const img = document.createElement('img');
                  img.src = e.target.result;
                  img.alt = `Image ${index + 1}`;
                  img.style.width = '100px';
                  img.style.height = '100px';
                  img.style.marginBottom = '10px';
                  img.style.borderRadius = '5px';

                  // Append elements
                  imageWrapper.appendChild(numberLabel);
                  imageWrapper.appendChild(img);
                  previewContainer.appendChild(imageWrapper);
              };

              reader.readAsDataURL(file);
          });

      }
  });
  document.getElementById('add-color').addEventListener('click', function() {
        const container = document.getElementById('colors-container');
        const newColorIndex = container.children.length;
        const newColorField = `
            <div class="color-selection">
                <select name="colors[]" style="margin-top: 5px" class="form-control color-select" onchange="checkColorForDuplicate(this)">
                  <option value="" selected disabled>Select a color</option>
                    @foreach ($color->all() as $color)
                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                    @endforeach
                </select>
                <input type="number" name="colors_price_adjustment[]" style="margin: 5px 0px 20px 0px" class="form-control price-adjustment" placeholder="Price Adjustment" />
            </div>
        `;
        container.insertAdjacentHTML('beforeend', newColorField);
  });
  document.getElementById('add-size').addEventListener('click', function() {
        const container = document.getElementById('sizes-container');
        const newSizeIndex = container.children.length;
        const newSizeField = `
            <div class="size-selection">
              <select name="sizes[]" style="margin-top: 5px" class="form-control size-select" onchange="checkSizeForDuplicate(this)">
                <option value="" selected disabled>Select a size</option>
                  @foreach ($size->all() as $size)
                      <option value="{{ $size->id }}">{{ $size->name }}</option>
                  @endforeach
              </select>
              <input type="number" name="sizes_price_adjustment[]" style="margin: 5px 0px 20px 0px" class="form-control price-adjustment" placeholder="Price Adjustment" />
            </div>
        `;
        container.insertAdjacentHTML('beforeend', newSizeField);
  });
  function checkColorForDuplicate(selectElement) {
        const selectedColor = selectElement.value;
        if (!selectedColor) return; // Do nothing if no color is selected

        const colorDropdowns = document.querySelectorAll('.color-select');
        for (const dropdown of colorDropdowns) {
            if (dropdown !== selectElement && dropdown.value === selectedColor) {
                alert("This color is already selected!");
                selectElement.value = ""; // Reset the selection
                return ;
            }
        }
  }
  function checkSizeForDuplicate(selectElement) {
        const selectedSize = selectElement.value;
        // const previousValue = this.getAttribute('data-previous-value');
        if (!selectedSize) return; // Do nothing if no color is selected

        const sizeDropdowns = document.querySelectorAll('.size-select');
        for (const dropdown of sizeDropdowns) {
            if (dropdown !== selectElement && dropdown.value === selectedSize) {
                alert("This size is already selected!");
                selectElement.value = ""; // Reset the selection
                return ;
            }
        }
  }
</script>
@endsection