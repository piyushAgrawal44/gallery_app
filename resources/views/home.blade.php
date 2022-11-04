@extends('layout.body')
@section('content')
  {{-- Welcome {{Auth::user()->email}} to --}}
<h2 class="text-center"> Gallery App </h2>
@if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {!! session('error') !!}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

    </div>
@endif
<form action="/upload" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
      <label for="exampleInput1" class="form-label">Image Type*</label>
      <br>
      <input type="radio"  name="type" id="type" value="1" id="exampleInput1"> Potrait 
      <input type="radio"  name="type" id="type" value="2" id="exampleInput2"> Landscape

      <br>
      @error('type')
      <span class="text-danger" >
          <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
    <div class="mb-3">
      <label for="image" class="form-label">File*</label>
      <input type="file" required name="image" accept=".png,.gif,.jpg,.hhpeg" class="form-control" id="image">
      @error('image')
      <span class="text-danger" >
          <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
   
    <button type="submit" class="btn btn-primary">upload</button>
</form>

<br>
<div class="gallery">
    My Gallery
</div>

<br>
<div class="row">
  @foreach ($images as $item)
    @if ($item->type ==1)
        <div class="col-6 text-center mb-2">
         
          <div class="bg-primary">
            <img src="{{$item->qr_code}}" style="max-width: 100%; margin:auto;" alt="" srcset="">
          </div>
        </div>
    @else
        <div class="col-12 text-center mb-2">
         
          <div class="bg-warning">
            <img src="{{$item->qr_code}}" style="max-width: 100%; margin:auto;" alt="" srcset="">
          </div>
        </div>
    @endif
    
  @endforeach
</div>

@endsection